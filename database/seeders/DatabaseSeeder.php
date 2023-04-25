<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\Shareholding;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $portfolio = Portfolio::factory()->create();
        
        Shareholding::factory()->create([
            'symbol' => 'AAPL',
            'quantity' => 10,
            'portfolio_id' => $portfolio->id,
        ]);

        Shareholding::factory()->create([
            'symbol' => 'MSFT',
            'quantity' => 10,
            'portfolio_id' => $portfolio->id,
        ]);
    }
}
