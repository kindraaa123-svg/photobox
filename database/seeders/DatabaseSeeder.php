<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Frame;
use App\Models\Creation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Test User
        $user = User::firstOrCreate(
            ['email' => 'admin@photobox.com'],
            [
                'name' => 'Photobox Admin',
                'password' => bcrypt('password123'),
            ]
        );

        // Delete old creations and frames to re-seed cleanly
        Creation::query()->delete();
        Frame::query()->delete();

        // 1. Vertical Strip (4 Slots)
        Frame::create([
            'name' => 'Vertical Strip (4 Slots)',
            'user_id' => null,
            'layout_type' => 'strip',
            'bg_color' => '#ffe5ec', // Pastel Pink
            'is_public' => true,
            'slots' => [
                ['x' => 40, 'y' => 50, 'width' => 320, 'height' => 240],
                ['x' => 40, 'y' => 330, 'width' => 320, 'height' => 240],
                ['x' => 40, 'y' => 610, 'width' => 320, 'height' => 240],
                ['x' => 40, 'y' => 890, 'width' => 320, 'height' => 240],
            ]
        ]);

        // 2. 2x2 Grid (4 Slots)
        Frame::create([
            'name' => '2x2 Grid (4 Slots)',
            'user_id' => null,
            'layout_type' => 'grid',
            'bg_color' => '#e0f2fe', // Pastel Sky Blue
            'is_public' => true,
            'slots' => [
                ['x' => 50, 'y' => 50, 'width' => 420, 'height' => 315],
                ['x' => 530, 'y' => 50, 'width' => 420, 'height' => 315],
                ['x' => 50, 'y' => 415, 'width' => 420, 'height' => 315],
                ['x' => 530, 'y' => 415, 'width' => 420, 'height' => 315],
            ]
        ]);

        // 3. 3x2 Grid (6 Slots)
        Frame::create([
            'name' => '3x2 Grid (6 Slots)',
            'user_id' => null,
            'layout_type' => 'grid',
            'bg_color' => '#fef3c7', // Pastel Warm Cream
            'is_public' => true,
            'slots' => [
                ['x' => 50, 'y' => 50, 'width' => 420, 'height' => 315],
                ['x' => 530, 'y' => 50, 'width' => 420, 'height' => 315],
                ['x' => 50, 'y' => 425, 'width' => 420, 'height' => 315],
                ['x' => 530, 'y' => 425, 'width' => 420, 'height' => 315],
                ['x' => 50, 'y' => 800, 'width' => 420, 'height' => 315],
                ['x' => 530, 'y' => 800, 'width' => 420, 'height' => 315],
            ]
        ]);

        // 4. 3-Photo Strip (3 Slots)
        Frame::create([
            'name' => '3-Photo Strip (3 Slots)',
            'user_id' => null,
            'layout_type' => 'strip',
            'bg_color' => '#f3e8ff', // Pastel Lilac/Purple
            'is_public' => true,
            'slots' => [
                ['x' => 40, 'y' => 80, 'width' => 320, 'height' => 250],
                ['x' => 40, 'y' => 390, 'width' => 320, 'height' => 250],
                ['x' => 40, 'y' => 700, 'width' => 320, 'height' => 250],
            ]
        ]);
    }
}
