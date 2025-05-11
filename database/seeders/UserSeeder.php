<?php

namespace Database\Seeders;

use App\Enum\UserType;
use App\Models\Inventory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'=>'Mobizilla Store',
            'email'=>'mobizillastore@gmail.com',
            'password'=>bcrypt('mobizilla101'),
            'username'=>'mobizillastore',
            'user_type'=> UserType::ADMIN,
        ]);

//        User::factory()->create([
//            'name' => 'Admin Account',
//            'email' => 'admin@admin.com',
//            'username' => 'admin',
//            'password'=> bcrypt('password'),
//            'user_type'=>UserType::ADMIN
//        ]);
    }
}
