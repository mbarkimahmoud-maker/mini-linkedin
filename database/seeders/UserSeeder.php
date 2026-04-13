<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Competence;
use App\Models\Offre;
use App\Models\Profil;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2 admin creer
        User::create([
            'name'     => 'Admin Mahmoud',
            'email'    => 'admin@linkedin.ma',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Admin Salma',
            'email'    => 'admin2@linkedin.ma',
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        // 5 recruteur avec 2 a 3 offres
        for ($i = 1; $i <= 5; $i++) {
            $recruteur = User::create([
                'name'     => "Recruteur $i",
                'email'    => "recruteur$i@linkedin.ma",
                'password' => bcrypt('password'),
                'role'     => 'recruteur',
            ]);

            // 2 a 3 offres par recruteur
            Offre::factory(rand(2, 3))->create([
                'user_id' => $recruteur->id,
            ]);
        }

        // Creer 10 candidats
        $competences = Competence::all();

        for ($i = 1; $i <= 10; $i++) {
            $candidat = User::create([
                'name'     => "Candidat $i",
                'email'    => "candidat$i@linkedin.ma",
                'password' => bcrypt('password'),
                'role'     => 'candidat',
            ]);

            // create profil for each candidat
            $profil = Profil::factory()->create([
                'user_id' => $candidat->id,
            ]);
            // attach 2, 4 random competences
            $randomCompetences = $competences->random(rand(2, 4));
            foreach ($randomCompetences as $competence) {
                $profil->competences()->attach($competence->id, [
                    'niveau' => fake()->randomElement([
                        'débutant',
                        'intermédiaire',
                        'expert'
                    ]),
                ]);
            }
        }
    }
}
