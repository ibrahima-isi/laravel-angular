<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Role::factory()->count(3)->create();
        /**
         * Run the database seeds.
         */
        $roles = ['admin', 'user', 'manager'];

        foreach ($roles as $role) {
            Role::factory()->create(['name' => $role]);
        }
    }
}
