<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'name' => 'Tech Innovators',
                'logo' => 'tech_innovators_logo.png', // Nom d'un fichier logo, si tu en as un
                'address' => '123 Rue de la Technologie',
                'zip_code' => '75001',
                'city' => 'Paris',
                'aboutUs' => 'Nous sommes des pionniers dans les solutions tech modernes, offrant des services novateurs pour les entreprises du monde entier.',
                'collaborators' => json_encode([2, 3]),
                'user_id' => 1, // Assure-toi que cet ID correspond à un utilisateur existant dans ta table `users`
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Creative Design Studio',
                'logo' => 'creative_design_logo.png', // Logo optionnel
                'address' => '45 Rue des Arts',
                'zip_code' => '69001',
                'city' => 'Lyon',
                'aboutUs' => 'Un studio de design axé sur la création visuelle innovante et l\'expérience utilisateur exceptionnelle.',
                'collaborators' => json_encode([4]),
                'user_id' => 2, // ID de l'utilisateur propriétaire de cette entreprise
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Green Energy Solutions',
                'logo' => 'green_energy_logo.png', // Logo optionnel
                'address' => '10 Avenue des Champs-Élysées',
                'zip_code' => '75008',
                'city' => 'Paris',
                'aboutUs' => 'Nous offrons des solutions d\'énergie verte et durable pour les entreprises à travers l\'Europe.',
                'collaborators' => json_encode([1,4]),
                'user_id' => 3, // ID de l'utilisateur propriétaire
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HealthCare Partners',
                'logo' => 'healthcare_partners_logo.png',
                'address' => '77 Rue de la Santé',
                'zip_code' => '13001',
                'city' => 'Marseille',
                'aboutUs' => 'Un groupe de professionnels de la santé offrant des services et conseils spécialisés pour les hôpitaux et cliniques.',
                'collaborators' => json_encode([1,2]),
                'user_id' => 4, // ID de l'utilisateur
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
