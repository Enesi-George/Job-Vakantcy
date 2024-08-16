<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'George Enesi',
            'email' => 'jobvakantcy@gmail.com',
            'password' => bcrypt('Nepotism8964$'),
            'email_verified_at' => now(),
            'role' => 'super-admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
