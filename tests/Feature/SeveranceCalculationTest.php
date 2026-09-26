<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\TerminationReason;
use App\Services\CalculationService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeveranceCalculationTest extends TestCase
{
    use RefreshDatabase;

    protected CalculationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->service = new CalculationService();
    }

    public function test_efficiency_loss_calculation()
    {
        // 4 tahun kerja, gaji pokok 5.000.000 + tunjangan tetap 1.000.000 = 6.000.000
        // Standar UP (4 thn - <5 thn) = 5 bulan
        // Standar UPMK (3 thn - <6 thn) = 2 bulan
        // Pengali efisiensi rugi: UP = 0.5x, UPMK = 1.0x
        // UP = 6.000.000 * 5 * 0.5 = 15.000.000
        // UPMK = 6.000.000 * 2 * 1.0 = 12.000.000
        $reason = TerminationReason::where('slug', 'efisiensi-kerugian')->firstOrFail();

        $result = $this->service->calculate([
            'employee_name' => 'Ahmad',
            'start_date' => '2020-01-01',
            'termination_date' => '2024-01-01',
            'basic_salary' => 5000000,
            'fixed_allowance' => 1000000,
            'termination_reason_id' => $reason->id,
            'cuti_remaining' => 0,
        ]);

        $this->assertEquals(6000000, $result['wage_basis']);
        $this->assertEquals(5, $result['base_severance_months']);
        $this->assertEquals(2, $result['base_upmk_months']);
        $this->assertEquals(15000000, $result['severance_amount']);
        $this->assertEquals(12000000, $result['upmk_amount']);
        $this->assertEquals(27000000, $result['total_amount']);
    }

    public function test_retirement_calculation()
    {
        // 10 tahun kerja, gaji 10.000.000
        // Standar UP (>= 8 thn) = 9 bulan
        // Standar UPMK (9 - <12 thn) = 4 bulan
        // Pensiun (Pasal 56): UP 1.75x, UPMK 1.0x
        // UP = 10.000.000 * 9 * 1.75 = 157.500.000
        // UPMK = 10.000.000 * 4 * 1.0 = 40.000.000
        $reason = TerminationReason::where('slug', 'pensiun')->firstOrFail();

        $result = $this->service->calculate([
            'employee_name' => 'Bambang',
            'start_date' => '2014-01-01',
            'termination_date' => '2024-01-01',
            'basic_salary' => 10000000,
            'fixed_allowance' => 0,
            'termination_reason_id' => $reason->id,
            'cuti_remaining' => 0,
        ]);

        $this->assertEquals(9, $result['base_severance_months']);
        $this->assertEquals(4, $result['base_upmk_months']);
        $this->assertEquals(157500000, $result['severance_amount']);
        $this->assertEquals(40000000, $result['upmk_amount']);
        $this->assertEquals(197500000, $result['total_amount']);
    }

    public function test_resignation_calculation()
    {
        // Resign (Pasal 50): UP 0, UPMK 0, UPH + Uang Pisah (1x upah)
        $reason = TerminationReason::where('slug', 'pengunduran-diri')->firstOrFail();

        $result = $this->service->calculate([
            'employee_name' => 'Citra',
            'start_date' => '2020-01-01',
            'termination_date' => '2024-01-01',
            'basic_salary' => 8000000,
            'fixed_allowance' => 0,
            'termination_reason_id' => $reason->id,
            'cuti_remaining' => 5, // (8.000.000 / 25) * 5 = 1.600.000
        ]);

        $this->assertEquals(0, $result['severance_amount']);
        $this->assertEquals(0, $result['upmk_amount']);
        $this->assertEquals(8000000, $result['separation_money']);
        $this->assertEquals(1600000, $result['uph_amount']);
        $this->assertEquals(9600000, $result['total_amount']);
    }

    public function test_pailit_with_traceable_wage_basis()
    {
        // TEST CASE 1 — Perusahaan Pailit (Pasal 47):
        // Upah Pokok 3.000.000 + Tunjangan Tetap 300.000 + Tidak Tetap 0
        // => Dasar Upah HARUS 3.300.000 (bukan 5.000.000 dari mana pun).
        // Masa kerja 4 thn 8 bln => dasar UP 5 bln, dasar UPMK 2 bln.
        // UP = 3.300.000 x 5 x 0,5 = 8.250.000
        // UPMK = 3.300.000 x 2 x 1 = 6.600.000
        // UPH = 200.000 => TOTAL = 15.050.000 (bukan 22.700.000)
        $reason = TerminationReason::where('slug', 'perusahaan-pailit')->firstOrFail();

        $result = $this->service->calculate([
            'employee_name' => 'Eko',
            'start_date' => '2020-01-01',
            'termination_date' => '2024-09-01',
            'basic_salary' => 3000000,
            'fixed_allowance' => 300000,
            'non_fixed_allowance' => 0,
            'termination_reason_id' => $reason->id,
            'cuti_remaining' => 0,
            'other_rights' => 200000,
            'return_cost' => 0,
        ]);

        $this->assertEquals(3300000, $result['wage_basis']);
        $this->assertEquals(5, $result['base_severance_months']);
        $this->assertEquals(2, $result['base_upmk_months']);
        $this->assertEquals(8250000, $result['severance_amount']);
        $this->assertEquals(6600000, $result['upmk_amount']);
        $this->assertEquals(200000, $result['uph_amount']);
        $this->assertEquals(15050000, $result['total_amount']);
    }

    public function test_wage_basis_without_fixed_allowance()
    {
        // TEST CASE 2 — Tanpa Tunjangan Tetap:
        // Upah Pokok 5.000.000 + Tunjangan Tetap 0 => Dasar Upah 5.000.000.
        $reason = TerminationReason::where('slug', 'efisiensi-kerugian')->firstOrFail();

        $result = $this->service->calculate([
            'employee_name' => 'Fajar',
            'start_date' => '2020-01-01',
            'termination_date' => '2024-01-01',
            'basic_salary' => 5000000,
            'fixed_allowance' => 0,
            'non_fixed_allowance' => 0,
            'termination_reason_id' => $reason->id,
            'cuti_remaining' => 0,
        ]);

        $this->assertEquals(5000000, $result['wage_basis']);
    }

    public function test_non_fixed_allowance_excluded_from_wage_basis()
    {
        // TEST CASE 3 — Tunjangan Tidak Tetap tidak masuk dasar UP/UPMK:
        // 5.000.000 + 500.000 (+ 1.000.000 tidak tetap) => Dasar Upah 5.500.000.
        $reason = TerminationReason::where('slug', 'efisiensi-kerugian')->firstOrFail();

        $result = $this->service->calculate([
            'employee_name' => 'Gita',
            'start_date' => '2020-01-01',
            'termination_date' => '2024-01-01',
            'basic_salary' => 5000000,
            'fixed_allowance' => 500000,
            'non_fixed_allowance' => 1000000,
            'termination_reason_id' => $reason->id,
            'cuti_remaining' => 0,
        ]);

        $this->assertEquals(5500000, $result['wage_basis']);
    }

    public function test_explicit_minimum_wage_floor_still_applies()
    {
        // Batas bawah UMK tetap berlaku bila pengguna MENGISI kolom UMK:
        // 3.000.000 + 300.000 = 3.300.000 < UMK 4.000.000 => Dasar Upah 4.000.000.
        $reason = TerminationReason::where('slug', 'efisiensi-kerugian')->firstOrFail();

        $result = $this->service->calculate([
            'employee_name' => 'Hadi',
            'start_date' => '2020-01-01',
            'termination_date' => '2024-01-01',
            'basic_salary' => 3000000,
            'fixed_allowance' => 300000,
            'minimum_wage' => 4000000,
            'termination_reason_id' => $reason->id,
            'cuti_remaining' => 0,
        ]);

        $this->assertEquals(4000000, $result['wage_basis']);
    }

    public function test_detained_without_company_loss()
    {
        // Ditahan tanpa rugi perusahaan (Pasal 54 ayat 2): UP 0, UPMK 1x, UPH
        // 6 tahun kerja (6 - <9 thn) = UPMK 3 bulan
        $reason = TerminationReason::where('slug', 'pekerja-ditahan-tanpa-kerugian')->firstOrFail();

        $result = $this->service->calculate([
            'employee_name' => 'Dodi',
            'start_date' => '2018-01-01',
            'termination_date' => '2024-01-01',
            'basic_salary' => 5000000,
            'fixed_allowance' => 0,
            'termination_reason_id' => $reason->id,
            'cuti_remaining' => 0,
        ]);

        $this->assertEquals(0, $result['severance_amount']);
        $this->assertEquals(3, $result['base_upmk_months']);
        $this->assertEquals(15000000, $result['upmk_amount']);
        $this->assertEquals(15000000, $result['total_amount']);
    }
}

