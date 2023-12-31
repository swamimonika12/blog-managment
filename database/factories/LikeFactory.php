<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'likable_type' => app(Blog::class)->getMorphClass(),
            'likable_id' => Blog::inRandomOrder()->first()->id,
        ];
    }
}
