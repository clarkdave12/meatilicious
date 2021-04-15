<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Role::where('role', 'user')->first();

        if(!$user) {
            Role::factory()->create([
                'role' => 'user'
            ]);
        }

        $admin = Role::where('role', 'admin')->first();

        if(!$admin) {
            Role::factory()->create([
                'role' => 'admin'
            ]);
        }
    }
}
