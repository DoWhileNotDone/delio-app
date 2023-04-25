<?php

namespace Database\Factories;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shareholding>
 */
class ShareholdingFactory extends Factory
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
            'quantity' =>  $this->faker->randomNumber(5, false),
            'portfolio_id' => Portfolio::make(),
        ];
    }
}
