<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

    
        $adminRole = Role::query()->where('name', 'Admin')->first();

        // 3. Create the Admin user
        User::create([
            'full_name' => 'admin sey', 
            'email'     => 'admin@sstore.com',
            'password'  => Hash::make('123456'),
            'role_id'   => $adminRole->id,
           
        ]);

        // Optional: Generate 10 fake customers using the factory we just built!
        // User::factory(10)->create();
    }
}
