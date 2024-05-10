<?php

namespace Database\Factories;

use App\Enums\MovementCategoryType;
use App\Models\MovementCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MovementCategory>
 */
class MovementCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all();
        if ($users->isEmpty()) {
            $users->add(User::factory()->create());
        }

        return [
            'user_id' => $users->random()->id,
            'type' => $this->faker->randomElement([
                MovementCategoryType::DEBIT,
                MovementCategoryType::CREDIT,
            ]),
            'name' => $this->faker->text(20),
            'icon' => $this->faker->randomElement(config('icons')),
        ];
    }
}
