<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\Quote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PortfolioGetTest extends TestCase
{
    use RefreshDatabase;

    private Portfolio $portfolio;

    /**
     * Test that a get request will return 200 for a valid portfolio
     *
     * @return void
     */
    public function test_the_get_portfolio_returns_ok_with_json()
    {
        // Run the DatabaseSeeder...
        $this->seed();

        Quote::factory()
                ->count(2)
                ->sequence(
                    [
                        'symbol' => 'AAPL', 
                        'current_price' => 105.00,
                        'change' => 5.00,
                        'percent_change' => 5.0000,
                        'previous_close_price' => 100.00,
                    ],
                    [
                        'symbol' => 'MSFT', 
                        'current_price' => 190.00,
                        'change' => -10.00,
                        'percent_change' => -5.0000,
                        'previous_close_price' => 200.00,
                    ],
                )
                ->create();

        $this->portfolio = Portfolio::first();

        $response = $this->get("/portfolio/{$this->portfolio->id}/quote");

        $response->assertStatus(200);

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has(2)
                    ->has('0', fn ($json) =>
                        $json->where('symbol', 'AAPL')
                             ->where('current_value', '1,050.00')
                             ->where('closing_price_value', '1,000.00')
                             ->where('changed_in_value', '50.00')
                             ->etc()
                    )
                    ->has('1', fn ($json) =>
                        $json->where('symbol', 'MSFT')
                        ->where('current_value', '1,900.00')
                        ->where('closing_price_value', '2,000.00')
                        ->where('changed_in_value', '-100.00')
                        ->etc()
                )
        );
    }
}
