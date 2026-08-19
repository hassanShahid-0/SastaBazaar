<?php

namespace Tests\Feature;

use App\Models\Commodity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCommodityTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    private function regularUser(): User
    {
        return User::factory()->create(['is_admin' => false]);
    }

    // ── Access control ─────────────────────────────────────────

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }

    public function test_regular_user_cannot_access_admin_area(): void
    {
        $this->actingAs($this->regularUser())
             ->get('/admin/dashboard')
             ->assertForbidden();
    }

    public function test_admin_can_access_dashboard(): void
    {
        $this->actingAs($this->adminUser())
             ->get('/admin/dashboard')
             ->assertOk();
    }

    // ── Commodity CRUD ─────────────────────────────────────────

    public function test_admin_can_view_commodities_index(): void
    {
        Commodity::factory()->count(3)->create();

        $this->actingAs($this->adminUser())
             ->get('/admin/commodities')
             ->assertOk()
             ->assertSee('Commodity List');
    }

    public function test_admin_can_create_commodity(): void
    {
        $this->actingAs($this->adminUser())
             ->post('/admin/commodities', [
                 'name'      => 'Test Sugar',
                 'urdu_name' => 'چینی',
                 'unit'      => 'kg',
             ])
             ->assertRedirect('/admin/commodities');

        $this->assertDatabaseHas('commodities', ['name' => 'Test Sugar']);
    }

    public function test_commodity_creation_requires_name(): void
    {
        $this->actingAs($this->adminUser())
             ->post('/admin/commodities', ['unit' => 'kg'])
             ->assertSessionHasErrors('name');
    }

    public function test_admin_can_update_commodity(): void
    {
        $commodity = Commodity::factory()->create(['name' => 'Old Name', 'unit' => 'kg']);

        $this->actingAs($this->adminUser())
             ->put("/admin/commodities/{$commodity->id}", [
                 'name' => 'New Name',
                 'unit' => 'kg',
             ])
             ->assertRedirect('/admin/commodities');

        $this->assertDatabaseHas('commodities', ['name' => 'New Name']);
    }

    public function test_admin_can_delete_commodity(): void
    {
        $commodity = Commodity::factory()->create();

        $this->actingAs($this->adminUser())
             ->delete("/admin/commodities/{$commodity->id}")
             ->assertRedirect('/admin/commodities');

        $this->assertDatabaseMissing('commodities', ['id' => $commodity->id]);
    }
}