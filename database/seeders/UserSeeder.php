<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole  = Role::create(['name' => 'admin']);
        $clientRole = Role::create(['name' => 'client']);


        $user = \App\Models\User::create([
            'name'     => 'admin',
            'password' => '123',
            'email'    => 'admin@admin.com'
        ]);

        $user->assignRole($adminRole);
    }
}
