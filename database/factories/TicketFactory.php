<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'=> User::factory(),
            'title' => $this->faker->realText(rand(10, 20)),
            'status'=> $this->faker->boolean(),
            'body'=> $this->faker->paragraph(),
            // 'status'=> $this->faker->randomElement(['Open', 'Closed']),
            // 'priority'=> $this->faker->randomElement(['Low', 'High']),
        ];
    }
}
