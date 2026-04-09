<?php

namespace Database\Factories;

use App\Models\Competence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Competence>
 */
class CompetenceFactory extends Factory
{
    protected $model = Competence::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $competences = [
            'Java', 'C#', 'Go', 'TypeScript',
            'Spring Boot', 'Django', 'Flask', 'Express.js',
            'Kubernetes', 'AWS', 'Azure', 'Google Cloud',
            'Redis', 'PostgreSQL', 'GraphQL', 'REST API',
            'CI/CD', 'Jenkins', 'GitHub Actions',
            'Microservices', 'Clean Architecture',
            'Unit Testing', 'TDD', 'Agile/Scrum',
            'Cybersecurity Basics', 'OAuth2', 'JWT',
            'Machine Learning', 'Data Analysis',
            'TensorFlow', 'Pandas'
        ];

        $categories = [
                'Backend',
                'Frontend',
                'DevOps',
                'Database',
                'Cloud Computing',
                'Software Architecture',
                'Testing & QA',
                'Security',
                'Data Science',
                'AI & Machine Learning',
                'Mobile Development',
                'Project Management'
            ];

        return [
            'nom'       => fake()->randomElement($competences),
            'categorie' => fake()->randomElement($categories),
        ];
    }
}
