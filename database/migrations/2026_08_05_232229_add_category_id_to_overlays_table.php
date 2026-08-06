<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('overlays', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('image_path')->constrained('categories')->nullOnDelete();
        });

        // Map existing layout_type to category_id
        $overlays = DB::table('overlays')->get();
        foreach ($overlays as $o) {
            $slug = $o->layout_type;
            if (in_array($slug, ['all', 'single'])) {
                $slug = 'strip'; // fallback to strip
            }
            $category = DB::table('categories')->where('slug', $slug)->first();
            if ($category) {
                DB::table('overlays')->where('id', $o->id)->update([
                    'category_id' => $category->id
                ]);
            }
        }

        // Make category_id non-nullable if needed (keep nullable to support soft deletes or cascade defaults)
        Schema::table('overlays', function (Blueprint $table) {
            $table->dropColumn('layout_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overlays', function (Blueprint $table) {
            $table->string('layout_type')->default('strip')->after('image_path');
        });

        // Restore layout_type from category
        $overlays = DB::table('overlays')->get();
        foreach ($overlays as $o) {
            if ($o->category_id) {
                $category = DB::table('categories')->where('id', $o->category_id)->first();
                if ($category) {
                    DB::table('overlays')->where('id', $o->id)->update([
                        'layout_type' => $category->slug
                    ]);
                }
            }
        }

        Schema::table('overlays', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
