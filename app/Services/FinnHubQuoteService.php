<?php

namespace App\Services;

use App\Models\Quote;
use GuzzleHttp\Client;

class FinnHubQuoteService implements FinancialQuoteServiceInterface
{
    public function __construct(private Client $client)
    {
    }

    public function quote(string $symbol): Quote
    {
        //TODO: Try Catch 4xx/5xx
        $response = $this->client->request('GET', 'https://finnhub.io/api/v1/quote', [
            'query' => [
                'symbol' => $symbol,
                'token' => env('FINNHUB_API_KEY', false),
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return new Quote([
            'symbol' => $symbol, 
            'current_price' => $result['c'],
            'change' => $result['d'],
            'percent_change' => $result['dp'],
            'previous_close_price' => $result['pc'],
        ]);
    }
}


