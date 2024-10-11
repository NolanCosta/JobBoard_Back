<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\FollowAdvertisement;

class FollowAdvertisementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('follow_advertisements')->insert([
            [
                'email_sent' => 'Votre candidature a été envoyée pour l\'offre Développeur Full Stack.',
                'lastname' => 'Dupont',
                'firstname' => 'Jean',
                'email' => 'jean.dupont@example.com',
                'phone' => '0601020304',
                'message' => 'Je suis très intéressé par cette opportunité et je pense correspondre parfaitement au profil recherché.',
                'status' => 'SENT',
                'user_id' => 1, // ID de l'utilisateur candidat
                'advertisement_id' => 1, // ID de l'annonce à laquelle il postule
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_sent' => 'Votre candidature a été envoyée pour l\'offre Designer UX/UI.',
                'lastname' => 'Martin',
                'firstname' => 'Alice',
                'email' => 'alice.martin@example.com',
                'phone' => '0605060708',
                'message' => 'Je suis une designer UX/UI expérimentée et motivée à rejoindre votre équipe.',
                'status' => 'ACCEPTED',
                'user_id' => 2,
                'advertisement_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email_sent' => 'Votre candidature a été envoyée pour l\'offre Chef de projet IT.',
                'lastname' => 'Leclerc',
                'firstname' => 'Marc',
                'email' => 'marc.leclerc@example.com',
                'phone' => '0611121314',
                'message' => 'Je suis ravi de postuler à cette offre, et j\'espère avoir l\'opportunité de discuter davantage de cette opportunité.',
                'status' => 'REFUSED',
                'user_id' => 3,
                'advertisement_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
