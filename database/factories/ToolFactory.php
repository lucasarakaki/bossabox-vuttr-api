<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tool>
 */
class ToolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $options = ['Node', 'PHP', 'Back-end', 'Front-end', 'Tecnologia', 'Finanças', 'Notícias', 'Futebol', 'Entreterimento'];

        return [
            'user_id'     => User::factory()->create(),
            'title'       => fake()->domainName(),
            'link'        => fake()->url(),
            'description' => fake()->text(),
            'tags'        => fake()->randomElements($options, 5),
        ];
    }
}
