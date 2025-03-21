<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'score' => $this->faker->numberBetween(100, 140),
        ];
    }

    public function withBookings()
    {
        return $this->has(\App\Models\Booking::factory()->count(3), 'bookings');
    }
}
