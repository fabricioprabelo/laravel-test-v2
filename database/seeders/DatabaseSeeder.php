<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $email = 'admin@example.com';
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Admin',
                'email' => $email,
            ]);
        }

        $team = Team::where('name', 'Administrator')->first();

        if (!$team) {
            $team = Team::create([
                'user_id' => $user->id,
                'name' => 'Administrator',
                'personal_team' => true
            ]);
        }

        User::factory(10)->create();
    }
}
