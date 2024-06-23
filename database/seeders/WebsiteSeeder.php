<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Website;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $websites = [
            [
                'name' => 'TechCrunch',
                'url' => 'https://techcrunch.com',
                'description' => 'Technology news and analysis.',
            ],
            [
                'name' => 'Coursera',
                'url' => 'https://coursera.org',
                'description' => 'Online courses from top universities.',
            ],
            [
                'name' => 'WebMD',
                'url' => 'https://webmd.com',
                'description' => 'Health information and news.',
            ],
            [
                'name' => 'Forbes',
                'url' => 'https://forbes.com',
                'description' => 'Business news and financial information.',
            ],
            [
                'name' => 'Netflix',
                'url' => 'https://netflix.com',
                'description' => 'Streaming entertainment service.',
            ],
        ];

        foreach ($websites as $website) {
            Website::firstOrCreate($website);
        }
    }
}
