<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\job;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Ananda Biswas',
            'email' => 'ananda@biswas.com',
        ]);

        \App\Models\User::factory(300)-> create();
        $users= \App\Models\User:: all()-> shuffle();
        for ($i=0; $i < 20; $i++){
            \App\Models\Employer::factory()-> create([
                'user_id' => $users-> pop()-> id
            ]);
        }
        // User::factory(10)->create();
        $employers = \App\Models\Employer:: all();

        for ($i=0; $i <100; $i++){
            job::factory()-> create([
                'employer_id' => $employers-> random()->id
            ]);
        }

        foreach ($users as $user){
            $jobs=\App\Models\job::inRandomOrder()->take(rand(0,4))->get();
            foreach($jobs as $job){
                \App\Models\jobApplication::factory()->create([
                    'job_id' => $job-> id,
                    'user_id' => $user->id
                ]);
            }
        }
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
