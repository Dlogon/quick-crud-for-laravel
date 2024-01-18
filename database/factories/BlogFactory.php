<?php

namespace Dlogon\QuickCrudForLaravel\Database\Factories;

use Dlogon\QuickCrudForLaravel\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Blog::class;
    public function definition(): array
    {
        return [
            'name' => fake()->city,
            'content' => \fake()->text(100),
        ];
    }
}
