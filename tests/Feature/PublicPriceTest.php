<?php

namespace Tests\Feature;

use App\Models\Commodity;
use App\Models\DailyPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPriceTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_home_page_is_accessible(): void
    {
        $response = $this->get('/');

        $response->assertOk()
                 ->assertSee('Daily Grocery & Commodity Rates')
                 ->assertSee('SastaBazaar');
    }

    public function test_public_home_page_displays_commodities_and_official_prices(): void
    {
        $sugar = Commodity::factory()->create([
            'name'      => 'Sugar',
            'urdu_name' => 'چینی',
            'unit'      => 'kg',
        ]);

        $today = today()->toDateString();

        DailyPrice::create([
            'commodity_id'   => $sugar->id,
            'official_price' => 140.00,
            'active_date'    => $today,
        ]);

        $response = $this->get('/');

        $response->assertOk()
                 ->assertSee('Sugar')
                 ->assertSee('چینی')
                 ->assertSee('Rs. 140.00');
    }

    public function test_public_home_page_supports_date_filter(): void
    {
        $flour = Commodity::factory()->create(['name' => 'Wheat Flour']);
        $pastDate = '2026-07-01';

        DailyPrice::create([
            'commodity_id'   => $flour->id,
            'official_price' => 95.00,
            'active_date'    => $pastDate,
        ]);

        $response = $this->get('/?date=' . $pastDate);

        $response->assertOk()
                 ->assertSee('Wheat Flour')
                 ->assertSee('Rs. 95.00');
    }
}