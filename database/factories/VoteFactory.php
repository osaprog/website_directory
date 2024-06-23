<?php
namespace Database\Factories;

use App\Models\Vote;
use App\Models\Website;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    protected $model = Vote::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'website_id' => Website::factory()
        ];
    }
}
