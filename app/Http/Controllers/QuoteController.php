<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Services\FinancialQuoteServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuoteController extends Controller
{
    public function __construct(private FinancialQuoteServiceInterface $quoteService)
    {
    }
    
    /**
     * Retrieve a quote for a symbol and persist
     *
     * @param  string $symbol
     *
     * @return \Illuminate\Http\Response
     */
    public function store(string $symbol)
    {
        $validator = Validator::make(
            ['symbol' => $symbol], 
            [
                'symbol' => [
                    'required',
                    Rule::in(['AAPL', 'MSFT']),
                ]
            ]
        );
    
        if ($validator->fails()) {
            abort(404);
        }

        //TODO: Handle Exceptions
        $quote = $this->quoteService->quote($symbol);
        
        $quote->save();

        return response()->noContent(Response::HTTP_CREATED);
    }
}
