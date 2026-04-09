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
        // Create 2 admins
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

        // Create 5 recruteurs with 2-3 offres each
        for ($i = 1; $i <= 5; $i++) {
            $recruteur = User::create([
                'name'     => "Recruteur $i",
                'email'    => "recruteur$i@linkedin.ma",
                'password' => bcrypt('password'),
                'role'     => 'recruteur',
            ]);

            // 2 to 3 offres per recruteur
            Offre::factory(rand(2, 3))->create([
                'user_id' => $recruteur->id,
            ]);
        }

        // Create 10 candidats with profil and competences
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
            // attach 2 to 4 random competences
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
