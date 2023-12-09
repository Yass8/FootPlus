<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::truncate();

        $admin = User::create([
            'nom' => "admin",
            'prenom' => "admin",
            'email' => "admin@admin.com",
            'password' => Hash::make('password')
        ]);

        // $super = User::create([
        //     'nom' => "super",
        //     'prenom' => "admin",
        //     'email' => "super@super.com",
        //     'password' => Hash::make('password')
        // ]);

        $user2 = User::create([
            'nom' => "user2",
            'prenom' => "users2",
            'email' => "user2@user.com",
            'password' => Hash::make('password')
        ]);

        $charge = User::create([
            'nom' => "charge",
            'prenom' => "competition",
            'email' => "charger@chager.com",
            'password' => Hash::make('password')
        ]);

        // $admin = User::where('id',1)->first();

        // $superRole = Role::where('nom_role','Super Admin')->first();
        $adminRole = Role::where('nom_role','Admin')->first();
        $userRole = Role::where('nom_role','Utilisateur')->first();
        $chargerRole = Role::where('nom_role','Chager competition')->first();
    
        // $super->roles()->attach($superRole);
        $admin->roles()->attach($adminRole);
        $user2->roles()->attach($userRole);
        $charge->roles()->attach($chargerRole);
    
    }
}
