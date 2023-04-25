<?php

namespace App\Services;

use App\Models\Quote;

interface FinancialQuoteServiceInterface
{
    public function quote(string $symbol): Quote;
}
