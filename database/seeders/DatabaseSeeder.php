<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $adminExist = User::where('email', '=', 'admin@mail.com')->exists();
        if (!$adminExist) {
            User::factory()->create([
                'name' => 'John Doe',
                'email' => 'admin@mail.com',
                'password' => 'password',
                'is_admin' => true,
            ]);
        }

        $userExist = User::where('email', '=', 'user@mail.com')->exists();
        if (!$userExist) {
            User::factory()->create([
                'name' => 'Jane Doe',
                'email' => 'user@mail.com',
                'password' => 'password',
            ]);
        }

        User::factory(5)->create()->each(function($user) {
            $ticket = Ticket::factory(rand(1, 3))->create([
                'user_id' => $user->id
            ])->each(function($user, $ticket) {
                Comment::factory(rand(0, 16))->create([
                    'user_id' => $user->id,
                ]);
            });
        });
    }
}
