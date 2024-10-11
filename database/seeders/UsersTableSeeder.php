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
                'firstname' => 'Jean',
                'lastname' => 'Dupont',
                'email' => 'jean.dupont@example.com',
                'email_verified_at' => now(),
                'phone' => '0601020304',
                'address' => '123 Rue de Paris',
                'zip_code' => '75001',
                'city' => 'Paris',
                'password' => Hash::make('password123'), // Crypter le mot de passe
                'role' => 'USER',
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
                'firstname' => 'Marc',
                'lastname' => 'Leclerc',
                'email' => 'marc.leclerc@example.com',
                'email_verified_at' => now(),
                'phone' => '0611121314',
                'address' => '77 Rue de la République',
                'zip_code' => '13001',
                'city' => 'Marseille',
                'password' => Hash::make('password123'),
                'role' => 'ADMIN',
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
