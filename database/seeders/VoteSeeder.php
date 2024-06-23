<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vote;
use App\Models\Website;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        foreach ($users as $user) {
            $websites = Website::inRandomOrder()->limit(rand(1,2))->get(); // Get random number of websites
            foreach ($websites as $website) {
                Vote::firstOrCreate([
                    'user_id' => $user->id,
                    'website_id' => $website->id,
                ]);
            }
        }
    }
}
