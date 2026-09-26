<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TerminationReason;
use App\Models\Regulation;
use App\Models\CalculationRule;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===========================================
        // PENGGUNA DEFAULT (ADMIN & USER)
        // ===========================================
        User::updateOrCreate(
            ['email' => 'admin@simpek.com'],
            [
                'name' => 'Admin SIMPEK',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            ['email' => 'budi@simpek.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            ['email' => 'siti@simpek.com'],
            [
                'name' => 'Siti Aminah',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
            ]
        );

        // ===========================================
        // REGULASI RESMI PEMERINTAH REPUBLIK INDONESIA
        // ===========================================
        $regulationPp35 = Regulation::updateOrCreate(
            ['number' => '35', 'year' => '2021'],
            [
                'name' => 'PP No. 35 Tahun 2021',
                'article' => 'Pasal 40 s.d. Pasal 58',
                'description' => 'Peraturan Pemerintah tentang Perjanjian Kerja Waktu Tertentu, Alih Daya, Waktu Kerja dan Waktu Istirahat, serta Pemutusan Hubungan Kerja',
                'rule_version' => '2026.01',
                'effective_date' => '2021-02-02',
                'is_active' => true,
            ]
        );

        $regulationUu6 = Regulation::updateOrCreate(
            ['number' => '6', 'year' => '2023'],
            [
                'name' => 'UU No. 6 Tahun 2023 (Cipta Kerja)',
                'article' => 'Pasal 81 angka 44 (Perubahan Pasal 156 UU 13/2003)',
                'description' => 'Undang-Undang tentang Penetapan Peraturan Pemerintah Pengganti Undang-Undang Nomor 2 Tahun 2022 tentang Cipta Kerja Menjadi Undang-Undang',
                'rule_version' => '2026.01',
                'effective_date' => '2023-03-21',
                'is_active' => true,
            ]
        );

        // ===========================================
        // 23 ALASAN PHK RESMI SESUAI PP 35/2021 & UU 6/2023
        // ===========================================
        $reasonsData = [
            // 1. Pasal 41
            [
                'slug' => 'merger-peleburan-pemisahan',
                'name' => 'Penggabungan, Peleburan, atau Pemisahan Perusahaan',
                'legal_basis' => 'PP No. 35/2021 Pasal 41',
                'category' => 'merger_acquisition',
                'description' => 'Penggabungan, peleburan, atau pemisahan perusahaan di mana pekerja/buruh tidak bersedia melanjutkan hubungan kerja atau pengusaha tidak bersedia menerima pekerja/buruh.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 1.00,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 41: Uang Pesangon 1x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 2. Pasal 42 ayat (1)
            [
                'slug' => 'pengambilalihan-pengusaha-menolak',
                'name' => 'Pengambilalihan Perusahaan (Pengusaha Menolak Melanjutkan)',
                'legal_basis' => 'PP No. 35/2021 Pasal 42 ayat (1)',
                'category' => 'merger_acquisition',
                'description' => 'Pengambilalihan perusahaan di mana pengusaha baru tidak bersedia menerima pekerja/buruh.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 1.00,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 42 ayat (1): Uang Pesangon 1x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 3. Pasal 42 ayat (2)
            [
                'slug' => 'pengambilalihan-perubahan-syarat',
                'name' => 'Pengambilalihan Perusahaan + Perubahan Syarat Kerja (Pekerja Menolak)',
                'legal_basis' => 'PP No. 35/2021 Pasal 42 ayat (2)',
                'category' => 'merger_acquisition',
                'description' => 'Pengambilalihan perusahaan yang mengakibatkan terjadinya perubahan syarat kerja dan pekerja/buruh tidak bersedia melanjutkan hubungan kerja.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.50,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 42 ayat (2): Uang Pesangon 0.5x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 4. Pasal 43 ayat (1)
            [
                'slug' => 'efisiensi-kerugian',
                'name' => 'Efisiensi Karena Perusahaan Mengalami Kerugian',
                'legal_basis' => 'PP No. 35/2021 Pasal 43 ayat (1)',
                'category' => 'efficiency_loss',
                'description' => 'Efisiensi diikuti penutupan atau tidak diikuti penutupan perusahaan yang disebabkan perusahaan mengalami kerugian (terbukti dari audit).',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.50,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 43 ayat (1): Uang Pesangon 0.5x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 5. Pasal 43 ayat (2)
            [
                'slug' => 'efisiensi-mencegah-kerugian',
                'name' => 'Efisiensi Untuk Mencegah Terjadinya Kerugian',
                'legal_basis' => 'PP No. 35/2021 Pasal 43 ayat (2)',
                'category' => 'efficiency_prevention',
                'description' => 'Efisiensi dilakukan oleh perusahaan untuk mencegah potensi terjadinya kerugian.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 1.00,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 43 ayat (2): Uang Pesangon 1x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 6. Pasal 44 ayat (1)
            [
                'slug' => 'perusahaan-tutup-kerugian',
                'name' => 'Perusahaan Tutup Karena Mengalami Kerugian',
                'legal_basis' => 'PP No. 35/2021 Pasal 44 ayat (1)',
                'category' => 'closure_loss',
                'description' => 'Perusahaan tutup yang disebabkan karena perusahaan mengalami kerugian secara terus menerus selama 2 tahun atau tidak terus menerus selama 2 tahun.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.50,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 44 ayat (1): Uang Pesangon 0.5x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 7. Pasal 44 ayat (2)
            [
                'slug' => 'perusahaan-tutup-bukan-kerugian',
                'name' => 'Perusahaan Tutup Bukan Karena Kerugian',
                'legal_basis' => 'PP No. 35/2021 Pasal 44 ayat (2)',
                'category' => 'closure_no_loss',
                'description' => 'Perusahaan tutup yang disebabkan bukan karena kerugian finansial.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 1.00,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 44 ayat (2): Uang Pesangon 1x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 8. Pasal 45 ayat (1)
            [
                'slug' => 'force-majeure-tutup',
                'name' => 'Keadaan Memaksa (Force Majeure) Perusahaan Tutup',
                'legal_basis' => 'PP No. 35/2021 Pasal 45 ayat (1)',
                'category' => 'force_majeure_closure',
                'description' => 'Perusahaan tutup yang disebabkan keadaan memaksa (force majeure).',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.50,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 45 ayat (1): Uang Pesangon 0.5x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 9. Pasal 45 ayat (2)
            [
                'slug' => 'force-majeure-tanpa-tutup',
                'name' => 'Keadaan Memaksa (Force Majeure) Tanpa Perusahaan Tutup',
                'legal_basis' => 'PP No. 35/2021 Pasal 45 ayat (2)',
                'category' => 'force_majeure_no_closure',
                'description' => 'Keadaan memaksa (force majeure) yang tidak mengakibatkan perusahaan tutup.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.75,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 45 ayat (2): Uang Pesangon 0.75x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 10. Pasal 46 ayat (1)
            [
                'slug' => 'pkpu-kerugian',
                'name' => 'PKPU Karena Perusahaan Mengalami Kerugian',
                'legal_basis' => 'PP No. 35/2021 Pasal 46 ayat (1)',
                'category' => 'pkpu_loss',
                'description' => 'Perusahaan dalam keadaan penundaan kewajiban pembayaran utang (PKPU) yang disebabkan perusahaan mengalami kerugian.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.50,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 46 ayat (1): Uang Pesangon 0.5x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 11. Pasal 46 ayat (2)
            [
                'slug' => 'pkpu-bukan-kerugian',
                'name' => 'PKPU Bukan Karena Kerugian',
                'legal_basis' => 'PP No. 35/2021 Pasal 46 ayat (2)',
                'category' => 'pkpu_no_loss',
                'description' => 'Perusahaan dalam keadaan penundaan kewajiban pembayaran utang (PKPU) bukan karena perusahaan mengalami kerugian.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 1.00,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 46 ayat (2): Uang Pesangon 1x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 12. Pasal 47
            [
                'slug' => 'perusahaan-pailit',
                'name' => 'Perusahaan Pailit',
                'legal_basis' => 'PP No. 35/2021 Pasal 47',
                'category' => 'bankruptcy',
                'description' => 'Pemutusan Hubungan Kerja karena alasan perusahaan pailit berdasarkan putusan pengadilan niaga.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.50,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 47: Uang Pesangon 0.5x, UPMK 1x, UPH sesuai Pasal 40 ayat (4). Dibayarkan melalui kurator.',
            ],
            // 13. Pasal 48
            [
                'slug' => 'permohonan-pekerja-pelanggaran-pengusaha',
                'name' => 'Permohonan PHK Oleh Pekerja Akibat Pelanggaran Pengusaha',
                'legal_basis' => 'PP No. 35/2021 Pasal 48 jo. Pasal 36 huruf g',
                'category' => 'employer_violation',
                'description' => 'Pekerja mengajukan PHK karena pengusaha melakukan perbuatan pelanggaran hukum/perjanjian (Pasal 36 huruf g).',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 1.00,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 48: Uang Pesangon 1x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 14. Pasal 49
            [
                'slug' => 'permohonan-pekerja-ditolak-phi',
                'name' => 'Permohonan PHK Pekerja Ditolak Lembaga Hubungan Industrial',
                'legal_basis' => 'PP No. 35/2021 Pasal 49 jo. Pasal 36 huruf h',
                'category' => 'court_rejected_worker',
                'description' => 'Putusan lembaga PHI menyatakan pengusaha tidak melakukan perbuatan pelanggaran, dan pengusaha memutuskan melakukan PHK.',
                'uses_separation_money' => true,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.00,
                'upmk_multiplier' => 0.00,
                'separation_money_multiplier' => 1.00,
                'special_notes' => 'Pasal 49: UPH sesuai Pasal 40 ayat (4) + Uang Pisah sesuai PK/PP/PKB.',
            ],
            // 15. Pasal 50
            [
                'slug' => 'pengunduran-diri',
                'name' => 'Pengunduran Diri Atas Kemauan Sendiri (Resign)',
                'legal_basis' => 'PP No. 35/2021 Pasal 50 jo. Pasal 36 huruf i',
                'category' => 'resignation',
                'description' => 'Pekerja mengundurkan diri atas kemauan sendiri secara sah (pemberitahuan 30 hari, bebas ikatan dinas, tetap bekerja hingga tanggal efektif).',
                'uses_separation_money' => true,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.00,
                'upmk_multiplier' => 0.00,
                'separation_money_multiplier' => 1.00,
                'special_notes' => 'Pasal 50: UPH sesuai Pasal 40 ayat (4) + Uang Pisah yang besarannya diatur dalam PK/PP/PKB.',
            ],
            // 16. Pasal 51
            [
                'slug' => 'mangkir-5-hari',
                'name' => 'Mangkir 5 Hari Kerja Berturut-turut Tanpa Alasan Sah',
                'legal_basis' => 'PP No. 35/2021 Pasal 51 jo. Pasal 36 huruf j',
                'category' => 'absence',
                'description' => 'Pekerja mangkir selama 5 hari kerja atau lebih berturut-turut tanpa keterangan tertulis sah dan telah dipanggil 2 kali secara patut.',
                'uses_separation_money' => true,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.00,
                'upmk_multiplier' => 0.00,
                'separation_money_multiplier' => 1.00,
                'special_notes' => 'Pasal 51: UPH sesuai Pasal 40 ayat (4) + Uang Pisah yang besarannya diatur dalam PK/PP/PKB.',
            ],
            // 17. Pasal 52 ayat (1)
            [
                'slug' => 'pelanggaran-sp-1-2-3',
                'name' => 'Pelanggaran Ketentuan Kerja Setelah SP 1, 2, dan 3',
                'legal_basis' => 'PP No. 35/2021 Pasal 52 ayat (1) jo. Pasal 36 huruf k',
                'category' => 'sp_warning',
                'description' => 'Pekerja melakukan pelanggaran ketentuan dalam PK/PP/PKB dan sebelumnya telah diberikan surat peringatan pertama, kedua, dan ketiga secara berturut-turut.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.50,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 52 ayat (1): Uang Pesangon 0.5x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 18. Pasal 52 ayat (2)
            [
                'slug' => 'pelanggaran-mendesak',
                'name' => 'Pelanggaran Bersifat Mendesak / Berat',
                'legal_basis' => 'PP No. 35/2021 Pasal 52 ayat (2)',
                'category' => 'urgent_violation',
                'description' => 'Pekerja melakukan pelanggaran bersifat mendesak yang diatur dalam PK, PP, atau PKB (penipuan, pencurian, perbuatan asusila, narkoba, dll).',
                'uses_separation_money' => true,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.00,
                'upmk_multiplier' => 0.00,
                'separation_money_multiplier' => 1.00,
                'special_notes' => 'Pasal 52 ayat (2): UPH sesuai Pasal 40 ayat (4) + Uang Pisah yang besarannya diatur dalam PK/PP/PKB.',
            ],
            // 19. Pasal 54 ayat (1)
            [
                'slug' => 'pekerja-ditahan-ada-kerugian',
                'name' => 'Pekerja Ditahan Pihak Berwajib >6 Bulan (Menyebabkan Kerugian)',
                'legal_basis' => 'PP No. 35/2021 Pasal 54 ayat (1)',
                'category' => 'detained_loss',
                'description' => 'Pekerja tidak dapat bekerja selama 6 bulan akibat ditahan pihak berwajib karena tindak pidana yang menyebabkan kerugian perusahaan.',
                'uses_separation_money' => true,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.00,
                'upmk_multiplier' => 0.00,
                'separation_money_multiplier' => 1.00,
                'special_notes' => 'Pasal 54 ayat (1): UPH sesuai Pasal 40 ayat (4) + Uang Pisah yang besarannya diatur dalam PK/PP/PKB.',
            ],
            // 20. Pasal 54 ayat (2)
            [
                'slug' => 'pekerja-ditahan-tanpa-kerugian',
                'name' => 'Pekerja Ditahan Pihak Berwajib >6 Bulan (Tidak Menyebabkan Kerugian)',
                'legal_basis' => 'PP No. 35/2021 Pasal 54 ayat (2)',
                'category' => 'detained_no_loss',
                'description' => 'Pekerja tidak dapat bekerja selama 6 bulan akibat ditahan pihak berwajib karena tindak pidana yang tidak menyebabkan kerugian perusahaan.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 0.00,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 54 ayat (2): UPMK 1x dan UPH sesuai Pasal 40 ayat (4) (tanpa Uang Pesangon).',
            ],
            // 21. Pasal 55
            [
                'slug' => 'sakit-cacat',
                'name' => 'Sakit Berkepanjangan / Cacat Akibat Kecelakaan Kerja (>12 Bulan)',
                'legal_basis' => 'PP No. 35/2021 Pasal 55 jo. Pasal 36 huruf m',
                'category' => 'sickness_disability',
                'description' => 'Pekerja mengalami sakit berkepanjangan atau cacat akibat kecelakaan kerja dan tidak dapat bekerja setelah melampaui batas 12 bulan.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 2.00,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 55: Uang Pesangon 2x, UPMK 1x, UPH sesuai Pasal 40 ayat (4).',
            ],
            // 22. Pasal 56
            [
                'slug' => 'pensiun',
                'name' => 'Pekerja Memasuki Usia Pensiun',
                'legal_basis' => 'PP No. 35/2021 Pasal 56 jo. Pasal 36 huruf n',
                'category' => 'retirement',
                'description' => 'Pekerja memasuki usia pensiun sesuai dengan ketentuan perjanjian kerja, peraturan perusahaan, PKB, atau perundang-undangan.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 1.75,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 56: Uang Pesangon 1.75x, UPMK 1x, UPH sesuai Pasal 40 ayat (4). Diperhitungkan dengan program jaminan pensiun (Pasal 58).',
            ],
            // 23. Pasal 57
            [
                'slug' => 'meninggal-dunia',
                'name' => 'Pekerja Meninggal Dunia',
                'legal_basis' => 'PP No. 35/2021 Pasal 57 jo. Pasal 36 huruf o',
                'category' => 'death',
                'description' => 'Pekerja meninggal dunia; kompensasi diberikan secara penuh kepada ahli waris yang sah.',
                'uses_separation_money' => false,
                'uses_pension_fund' => true,
                'severance_multiplier' => 2.00,
                'upmk_multiplier' => 1.00,
                'separation_money_multiplier' => null,
                'special_notes' => 'Pasal 57: Uang Pesangon 2x, UPMK 1x, UPH sesuai Pasal 40 ayat (4) diberikan kepada ahli waris.',
            ],
        ];

        foreach ($reasonsData as $item) {
            $reason = TerminationReason::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'legal_basis' => $item['legal_basis'],
                    'category' => $item['category'],
                    'uses_separation_money' => $item['uses_separation_money'],
                    'uses_pension_fund' => $item['uses_pension_fund'],
                    'is_active' => true,
                ]
            );

            CalculationRule::updateOrCreate(
                [
                    'termination_reason_id' => $reason->id,
                    'regulation_id' => $regulationPp35->id,
                ],
                [
                    'severance_multiplier' => $item['severance_multiplier'],
                    'upmk_multiplier' => $item['upmk_multiplier'],
                    'uph_rule' => 'Sesuai ketentuan Pasal 40 ayat (4) PP No. 35 Tahun 2021',
                    'separation_money_multiplier' => $item['separation_money_multiplier'],
                    'pension_fund_deduction' => null,
                    'special_notes' => $item['special_notes'],
                    'rule_version' => '2026.01',
                    'effective_date' => '2021-02-02',
                    'is_active' => true,
                ]
            );
        }
    }
}