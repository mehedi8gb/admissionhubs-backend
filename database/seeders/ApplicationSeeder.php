<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ApplicationSeeder extends Seeder
{
    public function run()
    {
        Application::factory()
            ->count(100)
            ->create();
    }
}
