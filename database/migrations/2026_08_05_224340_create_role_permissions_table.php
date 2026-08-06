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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('permission');
            $table->timestamps();
        });

        // Seed default permissions
        $defaults = [
            // Superadmin has all by default, but let's seed anyway
            ['role' => 'superadmin', 'permission' => 'manage_settings'],
            ['role' => 'superadmin', 'permission' => 'manage_users'],
            ['role' => 'superadmin', 'permission' => 'manage_templates'],
            ['role' => 'superadmin', 'permission' => 'backup_database'],
            ['role' => 'superadmin', 'permission' => 'view_logs'],
            ['role' => 'superadmin', 'permission' => 'use_studio'],
            ['role' => 'superadmin', 'permission' => 'view_trash'],

            // Admin permissions
            ['role' => 'admin', 'permission' => 'manage_settings'],
            ['role' => 'admin', 'permission' => 'manage_users'],
            ['role' => 'admin', 'permission' => 'manage_templates'],
            ['role' => 'admin', 'permission' => 'backup_database'],
            ['role' => 'admin', 'permission' => 'view_logs'],
            ['role' => 'admin', 'permission' => 'use_studio'],
            ['role' => 'admin', 'permission' => 'view_trash'],

            // User permissions
            ['role' => 'user', 'permission' => 'use_studio'],
        ];

        foreach ($defaults as $d) {
            DB::table('role_permissions')->insert(array_merge($d, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
