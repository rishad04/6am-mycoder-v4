<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        for ($i = 1; $i <= 5; $i++) {
            $title = "Sample Task $i";

            Task::create([
                'user_id'      => $user->id,
                'title'        => $title,
                'description'  => "This is the description for task $i.",
                'is_completed' => (bool)rand(0, 1),
                'order'        => $i,
                'is_active'    => true,
            ]);
        }
    }
}
