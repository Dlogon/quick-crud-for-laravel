<?php

namespace Dlogon\QuickCrudForLaravel\Database\Seeders;

use Dlogon\QuickCrudForLaravel\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::factory()->count(10)->create();
        Blog::factory()->count(1)->create([
            'name' => 'dlogon',
            'content' => 'Hello from quick-crud',
        ]);
    }
}
