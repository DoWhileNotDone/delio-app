<?php

namespace Tests\Feature;

use App\Models\Quote;
use App\Services\FinancialQuoteServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class QuotePutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a put request will 404 if the symbol is not valid.
     *
     * @return void
     */
    public function test_the_put_quote_returns_not_found_for_invalid_symbol()
    {
        $response = $this->put('/quote/NNN');

        $response->assertNotFound();
    }

    /**
     * Test that a put request will return 201 if the symbol is valid.
     *
     * @return void
     */
    public function test_the_put_quote_returns_created_for_valid_symbol()
    {
        $mock = $this->mock(FinancialQuoteServiceInterface::class, function (MockInterface $mock) {
          
            $mock->shouldReceive('quote')
                ->once()
                ->with('AAPL')
                ->andReturn(
                    new Quote([
                        'symbol' => 'AAPL', 
                        'current_price' => 105.00,
                        'change' => 5.00,
                        'percent_change' => 5.0000,
                        'previous_close_price' => 100.00,
                    ])
                );
        });

        $response = $this->put('/quote/AAPL');

        $response->assertCreated();

        $this->assertDatabaseHas('quotes',[
            'symbol' => 'AAPL', 
            'current_price' => 105.00,
            'change' => 5.00,
            'percent_change' => 5.0000,
            'previous_close_price' => 100.00,
        ]);
    }
}
