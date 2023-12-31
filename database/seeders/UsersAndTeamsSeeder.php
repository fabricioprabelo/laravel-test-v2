<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersAndTeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
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

        $team = Team::where('name', RoleEnum::MANAGER->value)->first();

        if (!$team) {
            $team = Team::create([
                'user_id' => $user->id,
                'name' => RoleEnum::MANAGER->value,
                'personal_team' => false
            ]);
        }


        User::factory(10)->create();
    }
}
