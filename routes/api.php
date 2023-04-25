<?php

use App\Http\Controllers\PortfolioQuoteController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return 'Delio App';
});

Route::put(
    '/quote/{symbol}', 
    [QuoteController::class, 'store']
)->whereAlpha('symbol');

Route::get(
    '/portfolio/{portfolio}/quote', 
    [PortfolioQuoteController::class, 'get']
)->whereNumber('portfolio');