<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Random\RandomException;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @throws RandomException
     */
    public function run(): void
    {
        User::factory(20)->create();

        User::query()->inRandomOrder()->limit(10)->get()
            ->each(function (User $u) {

                $project = Project::factory()->create(['created_by' => $u->id]);
                Proposal::factory()->count(random_int(4,45))->create(
                    ['project_id' => $project->id]
                );
                }
            );
        //Project::factory(10)->create();
    }
}
