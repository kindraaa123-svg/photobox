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
            $table->string('layout_type')->default('all')->after('image_path');
        });

        // Update default seeded overlays to have correct layout types
        DB::table('overlays')
            ->where('image_path', 'images/overlays/overlay_1.png')
            ->update(['layout_type' => 'strip']);

        DB::table('overlays')
            ->where('image_path', 'like', '%overlay_2.png')
            ->orWhere('image_path', 'like', '%overlay_3.png')
            ->update(['layout_type' => 'grid']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overlays', function (Blueprint $table) {
            $table->dropColumn('layout_type');
        });
    }
};
