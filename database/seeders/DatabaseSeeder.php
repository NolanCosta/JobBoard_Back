<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Advertisement;
use App\Models\FollowAdvertisement;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            CompaniesTableSeeder::class,
            AdvertisementsTableSeeder::class,
            FollowAdvertisementsTableSeeder::class,
            UsersTableSeeder::class,
             
            
        ]);
    }
}
