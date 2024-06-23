<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Website;
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
            ['name' => 'Technology'],
            ['name' => 'Education'],
            ['name' => 'Health'],
            ['name' => 'Business'],
            ['name' => 'Entertainment'],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        $websites = Website::all();
        foreach ( $websites as $website ) {
            $categories = Category::inRandomOrder()->limit(rand(1,2))->get(); // Attach random categories to each website
            $website->categories()->attach($categories);
        }
    }
}
