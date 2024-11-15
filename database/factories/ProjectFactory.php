<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'title'=>collect(fake()->words(5))->join(' '),
            'description'=>fake()->realText(),
            'ends_at'=>fake()->dateTimeBetween('now', '+3 days'),
            'status'=>fake()->randomElement(['open', 'closed']),
            'tech_stack'=>fake()->randomElements(['react','vite','nodejs','javascript','nextjs'],random_int(1,5)),
            'created_by'=>User::Factory(),
        ];
    }
}
