<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Competence;


class CompetenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $competences = [
            ['nom' => 'Laravel',     'categorie' => 'Backend'],
            ['nom' => 'React',       'categorie' => 'Frontend'],
            ['nom' => 'Vue.js',      'categorie' => 'Frontend'],
            ['nom' => 'Python',      'categorie' => 'Backend'],
            ['nom' => 'Docker',      'categorie' => 'DevOps'],
            ['nom' => 'MySQL',       'categorie' => 'Database'],
            ['nom' => 'MongoDB',     'categorie' => 'Database'],
            ['nom' => 'PHP',         'categorie' => 'Backend'],
            ['nom' => 'JavaScript',  'categorie' => 'Frontend'],
            ['nom' => 'Node.js',     'categorie' => 'Backend'],
            ['nom' => 'Git',         'categorie' => 'DevOps'],
            ['nom' => 'Linux',       'categorie' => 'DevOps'],
        ];

        foreach ($competences as $competence) {
            Competence::create($competence);
        }
    }
}
