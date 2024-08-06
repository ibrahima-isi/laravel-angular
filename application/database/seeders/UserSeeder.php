<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'firstname' => 'Admin',
            'lastname' => 'Administrator',
            'role_id' => 1,
            'email' => 'admin@mail.gn',
            'password' => bcrypt('passer'),
        ]);

        User::factory(10)->create();
    }
}
