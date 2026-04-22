<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            ['name' => 'Science',     'slug' => 'science',     'icon' => '🔬', 'color' => '#534AB7'],
            ['name' => 'History',     'slug' => 'history',     'icon' => '📜', 'color' => '#185FA5'],
            ['name' => 'Technology',  'slug' => 'technology',  'icon' => '💻', 'color' => '#1D9E75'],
            ['name' => 'Pop Culture', 'slug' => 'pop-culture', 'icon' => '🎬', 'color' => '#A32D2D'],
            ['name' => 'Music',       'slug' => 'music',       'icon' => '🎵', 'color' => '#D4537E'],
            ['name' => 'Laravel',     'slug' => 'laravel',     'icon' => '🪐', 'color' => '#F9322C'],
            ['name' => 'PHP',         'slug' => 'php',         'icon' => '🐘', 'color' => '#4F5B93'],
        ];

        foreach ($topics as $t) {
            \App\Models\Topic::firstOrCreate(['slug' => $t['slug']], $t);
        }
    }
}
