<?php

namespace Tests\Feature;

use App\Models\Commodity;
use App\Models\DailyPrice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPriceTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_admin_can_view_price_publishing_page(): void
    {
        Commodity::factory()->count(3)->create();

        $this->actingAs($this->adminUser())
             ->get('/admin/prices')
             ->assertOk()
             ->assertSee('Daily Commodity Prices');
    }

    public function test_admin_can_bulk_publish_prices(): void
    {
        $c1 = Commodity::factory()->create(['name' => 'Sugar']);
        $c2 = Commodity::factory()->create(['name' => 'Wheat Flour']);

        $today = today()->toDateString();

        $response = $this->actingAs($this->adminUser())
             ->post('/admin/prices', [
                 'active_date' => $today,
                 'prices' => [
                     $c1->id => 140.50,
                     $c2->id => 110.00,
                 ]
             ]);

        $response->assertRedirect('/admin/prices?date=' . $today);

        $this->assertDatabaseHas('daily_prices', [
            'commodity_id'   => $c1->id,
            'official_price' => 140.50,
        ]);

        $this->assertDatabaseHas('daily_prices', [
            'commodity_id'   => $c2->id,
            'official_price' => 110.00,
        ]);
    }
}