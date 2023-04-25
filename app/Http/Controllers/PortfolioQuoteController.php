<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Quote;
use App\Models\Shareholding;

class PortfolioQuoteController extends Controller
{    
    /**
     * Retrieve a quote for a portfolio, persist, and return resource response.
     *
     * @param  \App\Models\Portfolio $portfolio
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Portfolio $portfolio)
    {
        $summary = $portfolio->shareholdings->map(function (Shareholding $holding) {

            //Try Getting Latest For today or fail with 404
            $quote = Quote::where('symbol',  $holding->symbol)
                ->latest()
                ->firstOrFail();

            return [
                'symbol' => $holding->symbol,
                'current_value' => number_format($quote->current_price * $holding->quantity, 2),
                'closing_price_value' =>  number_format($quote->previous_close_price * $holding->quantity, 2),
                'changed_in_value' => number_format($quote->change * $holding->quantity, 2),
            ];           
        });

        return response()->json($summary);
    }
}
