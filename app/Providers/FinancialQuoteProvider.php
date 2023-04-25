<?php

namespace App\Providers;

use App\Services\FinancialQuoteServiceInterface;
use App\Services\FinnHubQuoteService;
use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class FinancialQuoteProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FinancialQuoteServiceInterface::class, function (Application $app) {
            return new FinnHubQuoteService(new Client());
        });
    }
}
