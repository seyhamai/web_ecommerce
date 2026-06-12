<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role; // Import the Model!

class RoleSeeder extends Seeder
{
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        Role::create(['id' => 1, 'name' => 'Admin']);
        Role::create(['id' => 2, 'name' => 'Customer']);
    }
}
