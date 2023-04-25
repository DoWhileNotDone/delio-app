<?php

namespace Database\Factories;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'symbol' => $this->faker->randomElement(['AAPL' ,'MSFT']),
            'current_price' => $this->faker->randomFloat(2),
            'change' => $this->faker->randomFloat(2),
            'percent_change' => $this->faker->randomFloat(4, 0, 100),
            'previous_close_price' => $this->faker->randomFloat(2),
        ];
    }
}
