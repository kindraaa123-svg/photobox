<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Creation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;
use App\Models\Overlay;
use App\Models\Category;
use Illuminate\Support\Str;

class PhotoboxController extends Controller
{
    /**
     * Show the landing page (company profile) for guests.
     */
    public function landing()
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('dashboard');
        }
        $frames = Frame::where('is_public', true)
            ->orderBy('id', 'asc')
            ->get();
        return view('landing', compact('frames'));
    }

    /**
     * Show the main Photobox workspace.
     */
    public function index()
    {
        if (request('action') === 'custom' && !Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat custom template.');
        }

        $user = Auth::user();

        if ($user) {
            // Get user's custom frames + public preset frames
            $frames = Frame::where('user_id', $user->id)
                ->orWhere('is_public', true)
                ->orderBy('created_at', 'desc')
                ->get();

            // Get user's creations
            $creations = Creation::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Guest: only public frames, no creations
            $frames = Frame::where('is_public', true)
                ->orderBy('created_at', 'desc')
                ->get();
            $creations = collect([]);
        }

        $overlays = Overlay::with('category')->orderBy('created_at', 'desc')->get();

        return view('workspace', compact('frames', 'creations', 'overlays'));
    }

    /**
     * Store a new custom frame.
     */
    public function saveFrame(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please sign in to create custom frames.'
            ], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'layout_type' => 'required|string|in:strip,grid,single',
            'bg_color' => 'nullable|string|max:50',
            'overlay_image' => 'nullable|image|mimes:png,svg|max:4096', // Max 4MB transparent PNG/SVG
            'slots' => 'nullable|string', // JSON string
        ]);

        $overlayPath = null;
        if ($request->hasFile('overlay_image')) {
            $file = $request->file('overlay_image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $overlayPath = $file->storeAs('frames', $filename, 'public');
        }

        $slots = [];
        $slotShape = $request->input('slot_shape', 'rect');
        if ($request->filled('slots')) {
            $slots = json_decode($request->slots, true);
            foreach ($slots as &$slot) {
                if (!isset($slot['shape'])) {
                    $slot['shape'] = $slotShape;
                }
            }
        } else {
            // Default slots layout if none provided based on type
            $slots = $this->getDefaultSlots($request->layout_type, $slotShape);
        }

        $frame = Frame::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'layout_type' => $request->layout_type,
            'bg_color' => $request->bg_color ?? '#ffffff',
            'overlay_image' => $overlayPath ? 'storage/' . $overlayPath : null,
            'slots' => $slots,
            'is_public' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Custom frame saved successfully!',
            'frame' => $frame
        ]);
    }

    /**
     * Store a completed photobox creation.
     */
    public function saveCreation(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => true,
                'saved' => false,
                'message' => 'Photo downloaded! Sign in to save photos to your history.'
            ]);
        }

        $request->validate([
            'image' => 'required|string', // Base64 data URI
            'frame_id' => 'nullable|integer|exists:frames,id',
            'metadata' => 'nullable|string', // JSON string
        ]);

        // Decode base64 image
        $image = $request->image;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageBinary = base64_decode($image);

        $filename = Str::uuid() . '.png';
        $path = 'creations/' . $filename;
        Storage::disk('public')->put($path, $imageBinary);

        $metadata = [];
        if ($request->filled('metadata')) {
            $metadata = json_decode($request->metadata, true);
        }

        $creation = Creation::create([
            'user_id' => Auth::id(),
            'frame_id' => $request->frame_id,
            'image_path' => 'storage/' . $path,
            'metadata' => $metadata
        ]);

        return response()->json([
            'success' => true,
            'saved' => true,
            'message' => 'Creation saved successfully!',
            'creation' => $creation
        ]);
    }

    /**
     * Delete a creation.
     */
    public function deleteCreation($id)
    {
        $creation = Creation::where('user_id', Auth::id())->findOrFail($id);

        // Delete the physical file
        $relativePath = str_replace('storage/', '', $creation->image_path);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }

        $creation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Creation deleted successfully!'
        ]);
    }

    /**
     * Delete a custom frame.
     */
    public function deleteFrame($id)
    {
        $frame = Frame::where('user_id', Auth::id())->findOrFail($id);

        // Delete the overlay image if exists
        if ($frame->overlay_image) {
            $relativePath = str_replace('storage/', '', $frame->overlay_image);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }

        $frame->delete();

        return response()->json([
            'success' => true,
            'message' => 'Frame deleted successfully!'
        ]);
    }

    /**
     * Get default slot positions for layouts.
     */
    private function getDefaultSlots($layoutType, $slotShape = 'rect')
    {
        // Dimensions out of 1000x1500 layout canvas (standard 2:3 ratio)
        switch ($layoutType) {
            case 'strip':
                // Classic vertical strip: 4 slots stacked vertically
                // Canvas width 400, height 1200
                return [
                    ['x' => 40, 'y' => 50, 'width' => 320, 'height' => 240, 'shape' => $slotShape],
                    ['x' => 40, 'y' => 330, 'width' => 320, 'height' => 240, 'shape' => $slotShape],
                    ['x' => 40, 'y' => 610, 'width' => 320, 'height' => 240, 'shape' => $slotShape],
                    ['x' => 40, 'y' => 890, 'width' => 320, 'height' => 240, 'shape' => $slotShape],
                ];
            case 'grid':
                // 2x2 grid on a 1000x1200 canvas
                return [
                    ['x' => 50, 'y' => 50, 'width' => 420, 'height' => 315, 'shape' => $slotShape],
                    ['x' => 530, 'y' => 50, 'width' => 420, 'height' => 315, 'shape' => $slotShape],
                    ['x' => 50, 'y' => 415, 'width' => 420, 'height' => 315, 'shape' => $slotShape],
                    ['x' => 530, 'y' => 415, 'width' => 420, 'height' => 315, 'shape' => $slotShape],
                ];
            case 'single':
                // 1 big landscape photo in the center
                return [
                    ['x' => 50, 'y' => 50, 'width' => 900, 'height' => 675, 'shape' => $slotShape],
                ];
            default:
                return [];
        }
    }

    /**
     * Show custom studio templates and results manager.
     */
    public function customStudio(Request $request)
    {
        $user = Auth::user();

        // Get user's custom frames / templates (Drafts)
        $drafts = Frame::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get completed / public frames (Ready templates)
        $completed = Frame::where('is_public', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('studio.custom', compact('drafts', 'completed'));
    }

    /**
     * Import an image from gallery/device as a completed creation.
     */
    public function uploadFromGallery(Request $request)
    {
        $request->validate([
            'image_file' => 'required|image|mimes:png,jpg,jpeg,gif|max:4096',
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('creations', $filename, 'public');

            Creation::create([
                'user_id' => Auth::id(),
                'image_path' => 'storage/' . $path,
            ]);

            return back()->with('success', 'Image successfully imported to your results gallery!');
        }

        return back()->withErrors(['image_file' => 'Failed to upload image.']);
    }

    /**
     * Export the database as a SQL file.
     */
    public function backupDatabase()
    {
        if (!auth()->user()->hasPermission('backup_database')) {
            abort(403, 'Unauthorized action.');
        }

        ActivityLog::log('Database Backup', 'Downloaded database SQL backup');

        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE', 'photobox');
        $keyName = "Tables_in_" . $dbName;
        
        $sql = "-- Photobox Studio Database Backup\n";
        $sql .= "-- Generated: " . now()->toDateTimeString() . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$keyName;
            
            // Get create table statement
            $createStatement = DB::select("SHOW CREATE TABLE `{$tableName}`")[0]->{'Create Table'};
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createStatement . ";\n\n";
            
            // Get table data
            $rows = DB::table($tableName)->get();
            foreach ($rows as $row) {
                $rowArray = (array) $row;
                $columns = array_keys($rowArray);
                $escapedColumns = array_map(function($col) { return "`{$col}`"; }, $columns);
                
                $values = array_map(function($val) {
                    if (is_null($val)) return 'NULL';
                    return "'" . addslashes($val) . "'";
                }, array_values($rowArray));
                
                $sql .= "INSERT INTO `{$tableName}` (" . implode(', ', $escapedColumns) . ") VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n";
        }
        
        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        $filename = 'photobox_backup_' . date('Y_m_d_His') . '.sql';

        return response($sql)
            ->header('Content-Type', 'application/sql')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Show activity logs.
     */
    public function activityLogs()
    {
        if (!auth()->user()->hasPermission('view_logs')) {
            abort(403, 'Unauthorized action.');
        }

        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('dashboard.activity_logs', compact('logs'));
    }

    /**
     * Show Category templates gallery.
     */
    public function categoryTemplates($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $overlays = Overlay::where('category_id', $category->id)->orderBy('created_at', 'desc')->get();
        return view('gallery.category', compact('category', 'overlays'));
    }
}
