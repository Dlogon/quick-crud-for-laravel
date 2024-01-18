<?php

namespace Dlogon\QuickCrudForLaravel\Tests\Database\Seeders;

use Dlogon\QuickCrudForLaravel\Tests\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::factory()->count(10)->create();
    }
}
