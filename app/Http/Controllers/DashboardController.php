<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Frame;
use App\Models\Creation;
use App\Models\Setting;
use App\Models\ActivityLog;
use App\Models\RolePermission;
use App\Models\Overlay;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Show the main Dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Fetch some basic stats for dashboard cards
        $stats = [
            'total_users' => User::count(),
            'total_frames' => Frame::count(),
            'total_creations' => Creation::count(),
            'my_creations' => Creation::where('user_id', $user->id)->count(),
        ];

        // Fetch recent creations
        $recentCreations = Creation::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard.index', compact('stats', 'recentCreations'));
    }

    /**
     * Show user profile form.
     */
    public function profile()
    {
        return view('dashboard.profile', ['user' => Auth::user()]);
    }

    /**
     * Update user profile.
     */
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Show system settings form.
     */
    public function settings()
    {
        if (!Auth::user()->hasPermission('manage_settings')) {
            abort(403, 'Unauthorized action.');
        }

        $webName = Setting::getVal('web_name', 'Photobox Studio');
        $webLogo = Setting::getVal('web_logo');

        return view('dashboard.settings', compact('webName', 'webLogo'));
    }

    /**
     * Update system settings.
     */
    public function settingsUpdate(Request $request)
    {
        if (!Auth::user()->hasPermission('manage_settings')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'web_name' => ['required', 'string', 'max:255'],
            'web_logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
        ]);

        Setting::setVal('web_name', $request->web_name);

        if ($request->hasFile('web_logo')) {
            $file = $request->file('web_logo');
            $filename = 'logo.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('settings', $filename, 'public');
            Setting::setVal('web_logo', 'storage/' . $path);
        }

        return back()->with('success', 'System settings updated successfully!');
    }

    /**
     * Show Users Master Data.
     */
    public function users()
    {
        if (!Auth::user()->hasPermission('manage_users')) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.users', compact('users'));
    }

    /**
     * Store a newly created user.
     */
    public function userStore(Request $request)
    {
        if (!Auth::user()->hasPermission('manage_users')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', 'in:superadmin,admin,user'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        ActivityLog::log('User Created', "Created user account: {$user->name} ({$user->email}) with role: {$user->role}");

        return back()->with('success', 'User account created successfully!');
    }

    /**
     * Update the specified user.
     */
    public function userUpdate(Request $request, $id)
    {
        if (!Auth::user()->hasPermission('manage_users')) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'string', 'in:superadmin,admin,user'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        ActivityLog::log('User Updated', "Updated user account: {$user->name} ({$user->email})");

        return back()->with('success', 'User account updated successfully!');
    }

    /**
     * Delete the specified user.
     */
    public function userDelete($id)
    {
        if (!Auth::user()->hasPermission('manage_users')) {
            abort(403, 'Unauthorized action.');
        }

        if (Auth::id() == $id) {
            return back()->withErrors(['users' => 'You cannot delete your own logged-in account.']);
        }

        $user = User::findOrFail($id);
        $name = $user->name;
        $email = $user->email;
        $user->delete();

        ActivityLog::log('User Deleted', "Deleted user account: {$name} ({$email})");

        return back()->with('success', 'User account deleted successfully!');
    }

    /**
     * Show Templates Master Data.
     */
    public function templates()
    {
        if (!Auth::user()->hasPermission('manage_templates')) {
            abort(403, 'Unauthorized action.');
        }

        $templates = Overlay::with('category')->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::orderBy('name', 'asc')->get();
        return view('dashboard.templates', compact('templates', 'categories'));
    }

    /**
     * Store a newly created template (overlay design).
     */
    public function templateStore(Request $request)
    {
        if (!Auth::user()->hasPermission('manage_templates')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_file' => ['required', 'image', 'mimes:png,svg', 'max:4096'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('overlays', $filename, 'public');

            $overlay = Overlay::create([
                'name' => $request->name,
                'image_path' => 'storage/' . $path,
                'category_id' => $request->category_id,
                'description' => $request->description,
            ]);

            ActivityLog::log('Template Created', "Uploaded new overlay design: {$overlay->name} for category ID: {$overlay->category_id}");

            return back()->with('success', 'New overlay template design uploaded successfully!');
        }

        return back()->withErrors(['image_file' => 'Failed to upload overlay image file.']);
    }

    /**
     * Update the specified template (overlay design).
     */
    public function templateUpdate(Request $request, $id)
    {
        if (!Auth::user()->hasPermission('manage_templates')) {
            abort(403, 'Unauthorized action.');
        }

        $overlay = Overlay::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'mimes:png,svg', 'max:4096'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $overlay->name = $request->name;
        $overlay->category_id = $request->category_id;
        $overlay->description = $request->description;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('overlays', $filename, 'public');
            $overlay->image_path = 'storage/' . $path;
        }

        $overlay->save();

        ActivityLog::log('Template Updated', "Updated overlay design: {$overlay->name}");

        return back()->with('success', 'Overlay template design updated successfully!');
    }

    /**
     * Delete the specified template (overlay design).
     */
    public function templateDelete($id)
    {
        if (!Auth::user()->hasPermission('manage_templates')) {
            abort(403, 'Unauthorized action.');
        }

        $overlay = Overlay::findOrFail($id);
        $name = $overlay->name;
        $overlay->delete();

        ActivityLog::log('Template Deleted', "Deleted overlay design: {$name}");

        return back()->with('success', 'Overlay template design deleted successfully!');
    }

    /**
     * Show Trash Bin (Tong Sampah) for deleted master data.
     */
    public function trash()
    {
        if (!Auth::user()->hasPermission('view_trash')) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch soft-deleted users and templates (overlays)
        $deletedUsers = User::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        $deletedFrames = Overlay::onlyTrashed()->orderBy('deleted_at', 'desc')->get();

        return view('dashboard.trash', compact('deletedUsers', 'deletedFrames'));
    }

    /**
     * Restore a soft-deleted item.
     */
    public function restore($type, $id)
    {
        if (!Auth::user()->hasPermission('view_trash')) {
            abort(403, 'Unauthorized action.');
        }

        if ($type === 'user') {
            $item = User::onlyTrashed()->findOrFail($id);
            $item->restore();
            ActivityLog::log('User Restored', "Restored user account: {$item->name} ({$item->email})");
        } elseif ($type === 'template') {
            $item = Overlay::onlyTrashed()->findOrFail($id);
            $item->restore();
            ActivityLog::log('Template Restored', "Restored overlay design: {$item->name}");
        } else {
            return back()->withErrors(['trash' => 'Invalid model type requested.']);
        }

        return back()->with('success', 'Data successfully restored from Trash Bin.');
    }

    /**
     * Permanently delete an item from database.
     */
    public function forceDelete($type, $id)
    {
        if (!Auth::user()->hasPermission('view_trash')) {
            abort(403, 'Unauthorized action.');
        }

        if ($type === 'user') {
            $item = User::onlyTrashed()->findOrFail($id);
            $name = $item->name;
            $email = $item->email;
            $item->forceDelete();
            ActivityLog::log('User Force Deleted', "Permanently deleted user: {$name} ({$email})");
        } elseif ($type === 'template') {
            $item = Overlay::onlyTrashed()->findOrFail($id);
            $name = $item->name;
            $item->forceDelete();
            ActivityLog::log('Template Force Deleted', "Permanently deleted overlay design: {$name}");
        } else {
            return back()->withErrors(['trash' => 'Invalid model type requested.']);
        }

        return back()->with('success', 'Data permanently deleted from system database.');
    }

    /**
     * Show Role Permissions configuration matrix.
     */
    public function permissions()
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Unauthorized action. Only Superadmins can manage role permissions.');
        }

        // Fetch all active permissions from database group by role
        $rolePermissions = RolePermission::all();
        
        // Define list of system permissions
        $permissionsList = [
            'manage_settings' => [
                'name' => 'Manage Settings',
                'description' => 'Modify global website configuration, website name, brand logo.'
            ],
            'manage_users' => [
                'name' => 'Manage Users',
                'description' => 'Full access to register, edit, and delete user profiles and roles.'
            ],
            'manage_templates' => [
                'name' => 'Manage Templates',
                'description' => 'Create, select, edit, and delete frame layouts and overlays.'
            ],
            'backup_database' => [
                'name' => 'Backup Database',
                'description' => 'Download complete MySQL database structure and record entries.'
            ],
            'view_logs' => [
                'name' => 'View Activity Logs',
                'description' => 'Access and audit all mutative system requests and event history logs.'
            ],
            'use_studio' => [
                'name' => 'Access Capture Studio',
                'description' => 'Access the webcam photo studio capturing sandbox frame sandbox.'
            ],
            'view_trash' => [
                'name' => 'Access Trash Bin',
                'description' => 'Audit, restore or permanently purge soft-deleted users and templates.'
            ],
        ];

        // Format into matrix
        $matrix = [];
        foreach ($rolePermissions as $rp) {
            $matrix[$rp->role][$rp->permission] = true;
        }

        return view('dashboard.permissions', compact('matrix', 'permissionsList'));
    }

    /**
     * Update Role Permissions configuration matrix.
     */
    public function permissionsUpdate(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        // We will sync the table
        RolePermission::truncate();

        // Get array from request
        $inputPermissions = $request->input('permissions', []);

        foreach ($inputPermissions as $role => $perms) {
            if (in_array($role, ['superadmin', 'admin', 'user'])) {
                foreach ($perms as $perm) {
                    RolePermission::create([
                        'role' => $role,
                        'permission' => $perm
                    ]);
                }
            }
        }

        ActivityLog::log('Permissions Updated', 'Updated role permissions matrix configuration');

        return back()->with('success', 'Role access permissions synchronized successfully!');
    }
}
