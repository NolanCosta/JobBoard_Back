<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'firstname' => 'Melia',
                'lastname' => 'Reriouedj',
                'email' => 'melia.reri@example.com',
                'email_verified_at' => now(),
                'phone' => '0601020304',
                'address' => '123 Rue de Paris',
                'zip_code' => '06500',
                'city' => 'Menton',
                'password' => Hash::make('password123'), // Crypter le mot de passe
                'role' => 'ADMIN',
                'remember_token' => \Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'firstname' => 'Nolan',
                'lastname' => 'Costa',
                'email' => 'nolan.costa@example.com',
                'email_verified_at' => now(),
                'phone' => '0678787867',
                'address' => '123 Rue de Paris',
                'zip_code' => '06600',
                'city' => 'Grasse',
                'password' => Hash::make('password123'), // Crypter le mot de passe
                'role' => 'ADMIN',
                'remember_token' => \Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstname' => 'Alice',
                'lastname' => 'Martin',
                'email' => 'alice.martin@example.com',
                'email_verified_at' => now(),
                'phone' => '0605060708',
                'address' => '45 Rue des Lilas',
                'zip_code' => '69001',
                'city' => 'Lyon',
                'password' => Hash::make('password123'), // Mot de passe crypté
                'role' => 'PRO',
                'remember_token' => \Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
          
            [
                'firstname' => 'Sophie',
                'lastname' => 'Moreau',
                'email' => 'sophie.moreau@example.com',
                'email_verified_at' => now(),
                'phone' => '0622232425',
                'address' => '33 Avenue du Général',
                'zip_code' => '75008',
                'city' => 'Paris',
                'password' => Hash::make('password123'),
                'role' => 'USER',
                'remember_token' => \Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
