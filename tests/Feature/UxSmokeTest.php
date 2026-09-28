<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Visual/structure smoke tests: every primary route must render with the new
 * design-system shell (navbar, sidebar, cards). No business logic is exercised.
 */
class UxSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_landing_page_renders_header_and_feature_cards(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('SIMPEK', false);
        $response->assertSee('id="fitur"', false);
        $response->assertSee('Mulai Hitung Simulasi', false);
        $response->assertDontSee('⚖');
    }

    public function test_login_page_renders_guest_shell(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('SIMPEK', false);
        $response->assertSee('Masuk', false);
    }

    public function test_register_page_renders_guest_shell(): void
    {
        $response = $this->get('/register');

        $response->assertOk();
        $response->assertSee('SIMPEK', false);
    }

    public function test_user_dashboard_renders_stat_cards_and_table(): void
    {
        $user = User::where('email', 'budi@simpek.com')->firstOrFail();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Dashboard', false);
        $response->assertSee('table-shell', false);
        $response->assertSee('appMenuBtn', false);
        // Navigation is sidebar-only: the top bar must not repeat the menu.
        $response->assertSee('Menu Utama', false);
        $response->assertDontSee('hidden lg:inline', false);
    }

    public function test_user_pages_render(): void
    {
        $user = User::where('email', 'budi@simpek.com')->firstOrFail();

        foreach (['/hitung' => 'Langkah', '/riwayat' => 'Riwayat', '/peraturan' => 'Skenario', '/profile' => 'Profil'] as $uri => $needle) {
            $response = $this->actingAs($user)->get($uri);
            $response->assertOk();
            $response->assertSee($needle, false);
        }
    }

    public function test_admin_pages_render_with_sidebar(): void
    {
        $admin = User::where('email', 'admin@simpek.com')->firstOrFail();

        $uris = [
            '/admin/dashboard' => 'Dashboard Admin',
            '/admin/hitung' => 'adminTerminationReasonId',
            '/admin/penghitungan' => 'Penghitungan',
            '/admin/verifikasi' => 'Verifikasi',
            '/admin/user' => 'Pengguna',
            '/admin/aturan' => 'Aturan',
            '/admin/peraturan' => 'Regulasi',
            '/admin/laporan' => 'Laporan',
            '/admin/alasan-phk' => 'Alasan',
        ];

        foreach ($uris as $uri => $needle) {
            $response = $this->actingAs($admin)->get($uri);
            $response->assertOk();
            $response->assertSee('Menu Admin', false);
            $response->assertSee($needle, false);
        }
    }

    public function test_admin_dashboard_shows_stat_cards(): void
    {
        $admin = User::where('email', 'admin@simpek.com')->firstOrFail();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertOk();
        $response->assertSee('Total pengguna', false);
        $response->assertSee('Menunggu verifikasi', false);
        $response->assertSee('Menu Admin', false);
        $response->assertDontSee('hidden lg:inline', false);
    }
}
