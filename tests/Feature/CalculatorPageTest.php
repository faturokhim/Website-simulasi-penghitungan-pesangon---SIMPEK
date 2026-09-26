<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculatorPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_user_calculator_page_renders()
    {
        $user = User::where('email', 'budi@simpek.com')->firstOrFail();

        $response = $this->actingAs($user)->get('/hitung');

        $response->assertOk();
        $response->assertSee('Langkah 1', false);
        $response->assertSee('terminationReasonId', false);
    }

    public function test_admin_calculator_page_renders()
    {
        $admin = User::where('email', 'admin@simpek.com')->firstOrFail();

        $response = $this->actingAs($admin)->get('/admin/hitung');

        $response->assertOk();
        $response->assertSee('adminTerminationReasonId', false);
    }

    public function test_user_regulations_page_renders()
    {
        $user = User::where('email', 'budi@simpek.com')->firstOrFail();

        $response = $this->actingAs($user)->get('/peraturan');

        $response->assertOk();
        $response->assertSee('23 Skenario', false);
    }
}
