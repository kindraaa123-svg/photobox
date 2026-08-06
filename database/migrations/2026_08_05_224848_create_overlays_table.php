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
        Schema::create('overlays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_path');
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Seed default overlays
        $defaults = [
            [
                'name' => 'Frame Design 1',
                'image_path' => 'images/overlays/overlay_1.png',
                'description' => 'Cute themed overlay',
            ],
            [
                'name' => 'Frame Design 2',
                'image_path' => 'images/overlays/overlay_2.png',
                'description' => 'Cool aesthetic border',
            ],
            [
                'name' => 'Frame Design 3',
                'image_path' => 'images/overlays/overlay_3.png',
                'description' => 'Retro memory vibe',
            ],
        ];

        foreach ($defaults as $d) {
            DB::table('overlays')->insert(array_merge($d, [
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
        Schema::dropIfExists('overlays');
    }
};
