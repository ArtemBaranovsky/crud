<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            Post::factory()
                ->count(rand(10, 15))
                ->create([
                    'user_id' => $user->id,
                ]);
        }
    }
}
