<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::where('email', '$uper_admin@email.org')->first();

        if(!$user) {
            $admin = User::factory()->create([
                'name' => 'Super Admin',
                'email' => '$uper_admin@email.org',
                'password' => bcrypt('meat@123456')
            ]);

            $adminRole = Role::where('role', 'admin')->first();

            $admin->roles()->attach($adminRole);
        }
    }
}
