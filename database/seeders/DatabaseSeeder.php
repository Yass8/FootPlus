<?php

namespace Database\Seeders;

use App\Models\Championnat;
use App\Models\Parametre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Parametre::truncate();
        Championnat::truncate();

        //$this->call(RolesTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
