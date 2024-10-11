<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Advertisement;

class AdvertisementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('advertisements')->insert([
            [
                'title' => 'Développeur Full Stack',
                'type' => 'CDI',
                'sector' => 'Informatique',
                'description' => 'Nous recherchons un développeur full stack avec 5 ans d\'expérience en PHP et JavaScript.',
                'wage' => '45000',
                'working_time' => 'Temps plein',
                'skills' => json_encode(['PHP', 'JavaScript', 'MySQL']),
                'tags' => json_encode(['Développement', 'Full Stack', 'CDI']),
                'zip_code' => '75001',
                'city' => 'Paris',
                'status' => 'PUBLISHED',
                'company_id' => 1, // Doit correspondre à une entrée existante dans la table companies
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Designer UX/UI',
                'type' => 'CDD',
                'sector' => 'Design',
                'description' => 'Nous cherchons un designer UX/UI créatif pour un projet de 6 mois.',
                'wage' => '35000',
                'working_time' => 'Temps partiel',
                'skills' => json_encode(['Figma', 'Adobe XD', 'Wireframing']),
                'tags' => json_encode(['Design', 'CDD', 'Freelance']),
                'zip_code' => '69001',
                'city' => 'Lyon',
                'status' => 'STANDBY',
                'company_id' => 2, // Doit correspondre à une entrée existante dans la table companies
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Chef de projet IT',
                'type' => 'FREELANCE',
                'sector' => 'Gestion de projet',
                'description' => 'Nous cherchons un chef de projet IT expérimenté pour une mission freelance.',
                'wage' => null,
                'working_time' => 'Temps plein',
                'skills' => json_encode(['Gestion de projet', 'Scrum', 'Agile']),
                'tags' => json_encode(['Projet', 'Freelance', 'Scrum']),
                'zip_code' => '13001',
                'city' => 'Marseille',
                'status' => 'PUBLISHED',
                'company_id' => 3, // Doit correspondre à une entrée existante dans la table companies
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
