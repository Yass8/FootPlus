<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        Role::create(['nom_role' => 'Super Admin']);
        Role::create(['nom_role' => 'Admin']);
        Role::create(['nom_role' => 'Utilisateur']);
        Role::create(['nom_role' => 'Chager competition']);

    }
}
