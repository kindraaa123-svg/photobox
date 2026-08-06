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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->timestamps();
        });

        // Seed layout categories
        $categories = [
            ['slug' => 'strip', 'name' => 'Vertical Strip (4 Slots)'],
            ['slug' => 'strip_3', 'name' => '3-Photo Strip (3 Slots)'],
            ['slug' => 'grid', 'name' => '2x2 Grid (4 Slots)'],
            ['slug' => 'grid_6', 'name' => '3x2 Grid (6 Slots)'],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->insert(array_merge($cat, [
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
        Schema::dropIfExists('categories');
    }
};
