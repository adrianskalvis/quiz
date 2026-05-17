<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [
            ['name' => 'HTML',              'slug' => 'html',              'icon' => '🌐', 'color' => '#E44D26'],
            ['name' => 'Laravel',           'slug' => 'laravel',           'icon' => '🪐', 'color' => '#F9322C'],
            ['name' => 'PHP',               'slug' => 'php',               'icon' => '🐘', 'color' => '#4F5B93'],
            ['name' => 'VTDT',              'slug' => 'vtdt',              'icon' => '🏫', 'color' => '#1D6FA4'],
            ['name' => 'IPB24',             'slug' => 'ipb24',             'icon' => '🎓', 'color' => '#2D8A4E'],
            ['name' => 'Underground Music', 'slug' => 'underground-music', 'icon' => '🎵', 'color' => '#6B21A8'],
            ['name' => 'History',           'slug' => 'history',           'icon' => '📜', 'color' => '#185FA5'],
            ['name' => 'Popular Brands',    'slug' => 'popular-brands',    'icon' => '🍔', 'color' => '#DA291C'],
            ['name' => 'Koju dzīve',        'slug' => 'koju-dzive',        'icon' => '🏠', 'color' => '#78350F'],
            ['name' => 'Gaming',            'slug' => 'gaming',            'icon' => '🎮', 'color' => '#1D4ED8'],
        ];

        foreach ($topics as $t) {
            Topic::firstOrCreate(['slug' => $t['slug']], $t);
        }
    }
}
