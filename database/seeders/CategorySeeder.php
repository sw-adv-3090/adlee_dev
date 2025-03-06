<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electric',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coffee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Towels',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Flowers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kiddush',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Party',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tehillim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Uvos ibonim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Shlosh Seudios',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        \DB::table('categories')->insert($categories);
    }
}
