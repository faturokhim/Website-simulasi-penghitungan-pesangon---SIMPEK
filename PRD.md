Berikut saya susun ulang PRD versi final berdasarkan evaluasi terakhir. Saya juga menyesuaikan konsepnya agar User dapat melakukan simulasi, sedangkan Admin dapat melakukan penghitungan ulang, verifikasi, dan finalisasi hasil.

PRD — SIMPEK
Sistem Informasi Penghitungan Uang Pesangon dan Uang Penghargaan Masa Kerja

Versi: 1.0
Framework: Laravel 10
Frontend: Blade + Tailwind CSS + JavaScript
Backend: Laravel 10
Database: MySQL
Role: User dan Admin
Output: Web + PDF hasil penghitungan
Tahap pengembangan awal: Frontend terlebih dahulu

1. Ringkasan Produk

SIMPEK adalah website yang digunakan untuk membantu melakukan simulasi dan penghitungan hak pekerja akibat Pemutusan Hubungan Kerja (PHK), khususnya:

Uang Pesangon (UP)
Uang Penghargaan Masa Kerja (UPMK)
Uang Penggantian Hak (UPH), apabila relevan

Sistem memiliki dua role:

User

User dapat melakukan penghitungan secara mandiri berdasarkan data yang dimasukkan.

Admin

Admin dapat melakukan penghitungan sendiri dengan data yang lebih lengkap, memeriksa hasil penghitungan user, melakukan penghitungan ulang, memberikan catatan, melakukan verifikasi, dan menetapkan hasil final.

Dengan demikian, sistem tidak hanya berfungsi sebagai kalkulator, tetapi juga sebagai sarana verifikasi penghitungan.

2. Latar Belakang

Pengakhiran hubungan kerja dapat menimbulkan hak pekerja yang harus diperhitungkan sesuai ketentuan peraturan perundang-undangan. Penghitungan hak tersebut dapat melibatkan beberapa faktor, seperti masa kerja, komponen upah, alasan PHK, serta ketentuan mengenai besaran uang pesangon dan UPMK.

Dalam praktiknya, penghitungan secara manual dapat membutuhkan waktu dan berpotensi menimbulkan kesalahan, terutama apabila terdapat perbedaan data atau interpretasi terhadap ketentuan yang berlaku.

SIMPEK dirancang untuk membantu proses simulasi dan pemeriksaan penghitungan secara lebih terstruktur.

Sistem menggunakan peraturan yang berlaku sebagai dasar penghitungan dan dirancang agar aturan dapat diperbarui apabila terdapat perubahan regulasi.

3. Dasar Hukum

Sistem harus dirancang dengan memperhatikan peraturan ketenagakerjaan yang berlaku pada saat sistem digunakan.

Basis regulasi utama yang perlu diperhatikan dalam pengembangan antara lain:

Undang-Undang No. 13 Tahun 2003 tentang Ketenagakerjaan, sebagaimana telah mengalami perubahan.
Undang-Undang No. 6 Tahun 2023 tentang Penetapan Perppu Cipta Kerja menjadi Undang-Undang.
PP No. 35 Tahun 2021 tentang Perjanjian Kerja Waktu Tertentu, Alih Daya, Waktu Kerja dan Waktu Istirahat, serta Pemutusan Hubungan Kerja.
Putusan Mahkamah Konstitusi No. 168/PUU-XXI/2023, sepanjang ketentuannya relevan terhadap penghitungan dan pemaknaan norma ketenagakerjaan.

Catatan pengembangan: jangan menganggap satu rumus berlaku untuk seluruh PHK. Rule penghitungan harus ditentukan berdasarkan alasan PHK dan ketentuan hukum yang berlaku.

4. Tujuan Produk

SIMPEK memiliki tujuan:

Memudahkan masyarakat melakukan simulasi hak akibat PHK.
Membantu penghitungan UP dan UPMK.
Membantu penghitungan UPH apabila terdapat komponen yang relevan.
Mengurangi kesalahan penghitungan manual.
Menampilkan rincian proses penghitungan secara transparan.
Menyediakan dasar hukum yang digunakan.
Memberikan fasilitas penghitungan ulang oleh admin.
Memungkinkan admin memverifikasi hasil penghitungan user.
Menyimpan riwayat penghitungan.
Menghasilkan laporan penghitungan dalam bentuk PDF.
5. Target Pengguna
5.1 User

Target:

Pekerja
Masyarakat
Pengguna yang ingin mengetahui estimasi hak PHK

Kebutuhan:

"Saya ingin menghitung sendiri berapa estimasi hak yang saya terima."

5.2 Admin

Target:

Petugas/pengelola sistem
Petugas yang melakukan pemeriksaan atau penghitungan
Pengelola data aturan

Kebutuhan:

"Saya ingin memeriksa penghitungan user dan melakukan penghitungan ulang secara lebih teliti."

6. Role dan Hak Akses
Fitur	User	Admin
Register	✅	❌
Login	✅	✅
Dashboard	✅	✅
Penghitungan baru	✅	✅
Penghitungan UP	✅	✅
Penghitungan UPMK	✅	✅
Penghitungan UPH	✅	✅
Melihat detail rumus	✅	✅
Download PDF	✅	✅
Riwayat sendiri	✅	-
Melihat semua penghitungan	❌	✅
Memeriksa penghitungan user	❌	✅
Penghitungan ulang	❌	✅
Membandingkan hasil	❌	✅
Catatan admin	❌	✅
Verifikasi	❌	✅
Finalisasi	❌	✅
Kelola user	❌	✅
Kelola aturan	❌	✅
Kelola alasan PHK	❌	✅
Kelola peraturan	❌	✅
7. Konsep Penghitungan

Sistem menggunakan alur:

Data Pekerja
      ↓
Masa Kerja
      ↓
Komponen Upah
      ↓
Alasan PHK
      ↓
Aturan yang Berlaku
      ↓
Uang Pesangon
      ↓
UPMK
      ↓
UPH
      ↓
Total

Penghitungan tidak boleh hanya menggunakan:

Masa Kerja × Gaji

karena ketentuan hak PHK dapat berbeda berdasarkan alasan PHK dan ketentuan yang berlaku.

8. Prinsip Rule Engine

Sistem harus menggunakan konsep:

Alasan PHK
      ↓
Calculation Rule
      ↓
Multiplier
      ↓
Komponen Hak
      ↓
Hasil

Contoh konsep:

reason_id
       ↓
rule_id
       ↓
severance_multiplier
       ↓
upmk_multiplier
       ↓
uph_rule

Rule tersebut disimpan di database agar dapat diperbarui tanpa mengubah seluruh kode aplikasi.

9. User Flow
Landing Page
     ↓
Register / Login
     ↓
Dashboard
     ↓
Mulai Penghitungan
     ↓
Data Pekerja
     ↓
Data Upah
     ↓
Alasan PHK
     ↓
Data Tambahan
     ↓
Review
     ↓
Hitung
     ↓
Hasil
     ↓
Simpan
     ↓
Download PDF
10. Admin Flow
Login
 ↓
Dashboard Admin
 ↓
 ┌──────────────────────────────┐
 │                              │
Penghitungan Baru       Penghitungan User
 │                              │
 ↓                              ↓
Input Data                Pilih Penghitungan
 │                              │
 ↓                              ↓
Hitung                     Periksa Data
 │                              │
 ↓                              ↓
Hasil Admin                Hitung Ulang
                                │
                                ↓
                           Bandingkan
                                │
                                ↓
                           Catatan Admin
                                │
                                ↓
                            Verifikasi
                                │
                                ↓
                            Finalisasi
                                │
                                ↓
                             PDF
11. Struktur Menu User
Dashboard

Hitung Pesangon

Riwayat Penghitungan

Peraturan

Profil

Logout
12. Struktur Menu Admin
Dashboard

Penghitungan
 ├── Penghitungan Baru
 ├── Penghitungan User
 └── Verifikasi Penghitungan

Data User

Aturan Penghitungan
 ├── Aturan Pesangon
 ├── Aturan UPMK
 ├── Aturan UPH
 └── Alasan PHK

Peraturan

Laporan

Pengaturan

Logout
13. Landing Page

Landing page harus sederhana dan profesional.

Hero
SIMPEK

Sistem Informasi Penghitungan
Pesangon dan Penghargaan Masa Kerja

Hitung dan pahami estimasi hak akibat PHK
dengan proses yang mudah dan transparan.

[ Mulai Menghitung ]
Fitur
┌───────────────┐
│ 🧮            │
│ Penghitungan  │
│ Otomatis      │
└───────────────┘

┌───────────────┐
│ 📋            │
│ Rincian Hasil │
└───────────────┘

┌───────────────┐
│ 📄            │
│ Download PDF  │
└───────────────┘

┌───────────────┐
│ ⚖️            │
│ Dasar Hukum   │
└───────────────┘
14. Dashboard User

Dashboard menampilkan:

Selamat datang!

┌──────────────┐
│ Total        │
│ Penghitungan │
│     12       │
└──────────────┘

┌──────────────┐
│ Penghitungan │
│ Terakhir     │
│ Rp...        │
└──────────────┘

[ + Hitung Pesangon ]

Kemudian:

Penghitungan Terakhir
Nama           : Budi Santoso
Tanggal        : 15 September 2026
Status         : Simulasi
Total          : Rp...
15. Form Penghitungan User

Form dibuat menggunakan stepper agar tidak terlalu panjang.

Step 1 — Data Pekerja
Nama Pekerja
[________________]

Tanggal Mulai Kerja
[__/__/____]

Tanggal PHK
[__/__/____]

Sistem otomatis menampilkan:

Masa Kerja

10 Tahun
8 Bulan
14 Hari
16. Step 2 — Data Upah
Upah Pokok
Rp [____________]

Tunjangan Tetap
Rp [____________]

Tunjangan Tidak Tetap
Rp [____________]

Sistem menampilkan informasi dasar upah yang digunakan dalam simulasi berdasarkan klasifikasi komponen upah yang relevan.

17. Step 3 — Alasan PHK
Alasan PHK

[ Pilih Alasan PHK ▼ ]

Setelah user memilih alasan:

Dasar Perhitungan

Alasan PHK:
....................

Ketentuan:
....................

User tidak perlu mengubah faktor pengali secara manual.

18. Step 4 — Data Tambahan

Jika diperlukan:

Sisa Cuti
[____]

Hak lainnya
Rp [________]

Biaya pulang
Rp [________]
19. Step 5 — Review

Sebelum menghitung:

REVIEW DATA

Nama:
Budi Santoso

Masa Kerja:
10 Tahun 8 Bulan

Dasar Upah:
Rp5.500.000

Alasan PHK:
....................

[ Kembali ]

[ Hitung ]
20. Hasil User

Tampilkan:

HASIL SIMULASI

Rp XX.XXX.XXX
Estimasi Total Hak

Rincian:

Komponen	Nilai
Uang Pesangon	Rp...
UPMK	Rp...
UPH	Rp...
Total	Rp...

Button:

[ Lihat Rincian ]

[ Simpan ]

[ Download PDF ]
21. Detail Penghitungan User

User dapat melihat:

Masa Kerja
10 Tahun 8 Bulan

Dasar Upah
Rp5.500.000

Uang Pesangon
Rp...

UPMK
Rp...

UPH
Rp...

TOTAL
Rp...

Kemudian:

Dasar Peraturan

PP No. 35 Tahun 2021
Pasal terkait
22. Dashboard Admin

Dashboard admin:

Selamat Datang, Admin

┌─────────────┐
│ Total User  │
│     125     │
└─────────────┘

┌─────────────┐
│ Simulasi    │
│     458     │
└─────────────┘

┌─────────────┐
│ Menunggu    │
│ Verifikasi  │
│      15     │
└─────────────┘

┌─────────────┐
│ Terverifikasi│
│     89      │
└─────────────┘
23. Penghitungan Baru Admin

Admin mempunyai form yang lebih lengkap.

DATA PEKERJA

Nama
Nomor identitas
Jabatan
Tanggal mulai kerja
Tanggal PHK

Kemudian:

MASA KERJA

10 Tahun
8 Bulan
14 Hari

[ Detail ]
24. Penghitungan Upah Admin

Admin dapat melihat komponen secara terperinci:

Upah Pokok
Rp5.000.000

Tunjangan Tetap
Rp500.000

Tunjangan Tidak Tetap
Rp750.000

──────────────────

Dasar Upah
Rp5.500.000

Admin dapat memeriksa komponen tersebut sebelum melakukan penghitungan.

25. Penghitungan Admin Berdasarkan Rule

Setelah alasan PHK dipilih:

ALASAN PHK
....................

DASAR HUKUM
....................

ATURAN PESANGON
....................

ATURAN UPMK
....................

ATURAN UPH
....................

Admin dapat melihat aturan yang digunakan.

26. Review Admin

Sebelum final:

REVIEW PENGHITUNGAN

✓ Data pekerja
✓ Masa kerja
✓ Komponen upah
✓ Alasan PHK
✓ Dasar hukum
✓ Rule penghitungan

[ Edit ]

[ Hitung ]
27. Hasil Penghitungan Admin

Admin memperoleh hasil lebih lengkap:

HASIL PENGHITUNGAN ADMIN

A. UANG PESANGON

Dasar Upah
Rp5.500.000

Masa Kerja
10 Tahun 8 Bulan

Faktor Pengali
X

Hasil
Rp...


B. UPMK

Masa Kerja
10 Tahun 8 Bulan

Faktor Pengali
X

Hasil
Rp...


C. UPH

Cuti
Rp...

Hak lainnya
Rp...

Total
Rp...


────────────────────

TOTAL HAK

Rp XX.XXX.XXX
28. Verifikasi Penghitungan User

Admin dapat membuka:

Penghitungan User

Budi Santoso

Hasil User
Rp75.000.000

Status
Menunggu Verifikasi

[ Periksa ]
29. Perbandingan Hasil

Ini fitur penting dalam sistem.

PERBANDINGAN

                 USER          ADMIN

Pesangon       Rp...          Rp...
UPMK           Rp...          Rp...
UPH            Rp...          Rp...

TOTAL          Rp75 jt        Rp82 jt

──────────────────────────────

SELISIH                       Rp7 jt
30. Catatan Admin

Admin dapat menambahkan:

Catatan Verifikasi

[____________________________________]
[____________________________________]
[____________________________________]

[ Simpan Catatan ]

Contoh alasan:

Masa kerja pada simulasi user belum
disesuaikan dengan tanggal PHK.
31. Status Penghitungan

Gunakan status:

SIMULASI
MENUNGGU VERIFIKASI
DIPERIKSA
DIVERIFIKASI
FINAL

Contoh:

Budi Santoso

Rp75.000.000

🟡 Menunggu Verifikasi

Setelah admin melakukan verifikasi:

🟢 Terverifikasi
32. Finalisasi

Admin dapat memilih:

[ Finalisasi Penghitungan ]

Setelah final:

Status:
FINAL

Hasil:
Rp82.500.000

Hasil final tidak boleh diubah sembarangan.

Jika ingin koreksi:

Buat Revisi

sehingga riwayat perubahan tetap dapat dilacak.

33. Audit Trail

Untuk admin, sistem sebaiknya mencatat:

Siapa yang melakukan perubahan
Kapan dilakukan
Data apa yang diubah
Nilai sebelum
Nilai sesudah

Contoh:

15/09/2026 10:25

Admin mengubah:
Dasar Upah

Sebelum:
Rp5.000.000

Sesudah:
Rp5.500.000

Ini akan membuat sistem lebih profesional.

34. Riwayat User

User hanya dapat melihat penghitungan miliknya.

Tanggal | Total | Status | Aksi

15/09/26 | Rp75 jt | Simulasi | Detail
14/09/26 | Rp60 jt | Final | Detail
35. Riwayat Admin

Admin dapat melihat seluruh penghitungan.

Filter:

Nama
Tanggal
Status
User
Alasan PHK

Aksi:

Detail
Verifikasi
Penghitungan Ulang
Download
36. Download PDF

PDF User:

SIMPEK

HASIL SIMULASI

Data Pekerja
Data Upah
Masa Kerja
Alasan PHK

UP
UPMK
UPH
TOTAL

Dasar Peraturan

Catatan

PDF Admin:

SIMPEK

HASIL PENGHITUNGAN & VERIFIKASI

Data User
Data Pekerja
Data Upah

HASIL USER
Rp...

HASIL ADMIN
Rp...

SELISIH
Rp...

CATATAN ADMIN

DASAR HUKUM

STATUS:
FINAL
37. Disclaimer

Pada halaman hasil dan PDF:

Catatan: Hasil penghitungan merupakan simulasi berdasarkan data yang dimasukkan dan ketentuan yang diterapkan oleh sistem. Hasil tersebut bukan merupakan penetapan hak secara hukum. Nilai aktual dapat dipengaruhi oleh kondisi hubungan kerja, perjanjian kerja, peraturan perusahaan, perjanjian kerja bersama, alasan PHK, serta ketentuan peraturan perundang-undangan yang berlaku.

38. Struktur Database

Meskipun tahap pertama frontend, database harus dirancang dari awal.

users
│
├── calculations
│
├── verification
│
└── audit_logs
users
id
name
email
password
role
status
created_at
updated_at
calculations
id
user_id
employee_name
start_date
termination_date

basic_salary
fixed_allowance
non_fixed_allowance
wage_basis

termination_reason_id

user_severance_amount
user_upmk_amount
user_uph_amount
user_total_amount

admin_severance_amount
admin_upmk_amount
admin_uph_amount
admin_total_amount

admin_note

status
verified_by
verified_at

created_at
updated_at
calculation_rules
id
termination_reason_id
severance_multiplier
upmk_multiplier
uph_rule
regulation_id
version
effective_date
status
regulations
id
name
number
year
article
description
document
effective_date
status
audit_logs
id
user_id
calculation_id
action
old_value
new_value
created_at
39. Versioning Peraturan

Sistem harus mempunyai:

Nama Peraturan
Nomor
Tahun
Pasal
Versi Rule
Tanggal Berlaku
Status

Contoh:

PP No. 35 Tahun 2021

Rule Version:
2026.01

Status:
Aktif

Ketika terdapat perubahan aturan:

Rule 2026.01
       ↓
Rule 2027.01

Penghitungan lama tetap menggunakan rule yang digunakan ketika penghitungan tersebut dibuat.

40. Arsitektur Laravel

Untuk tahap awal:

Laravel 10
│
├── Blade
├── Tailwind CSS
├── JavaScript
│
├── Authentication
│
├── Middleware
│
├── Controller
│
├── Service
│
├── Model
│
└── Database

Struktur frontend:

resources/views/

layouts/
├── app.blade.php
├── navbar.blade.php
└── sidebar.blade.php

components/
├── button.blade.php
├── input.blade.php
├── card.blade.php
├── modal.blade.php
├── alert.blade.php
└── table.blade.php

auth/
├── login.blade.php
└── register.blade.php

user/
├── dashboard.blade.php
├── calculator.blade.php
├── result.blade.php
├── history.blade.php
└── profile.blade.php

admin/
├── dashboard.blade.php
├── calculator.blade.php
├── calculations.blade.php
├── verification.blade.php
├── users.blade.php
├── rules.blade.php
├── reasons.blade.php
├── regulations.blade.php
└── reports.blade.php
41. Calculation Service

Jangan menaruh rumus utama di Blade atau JavaScript.

Gunakan:

app/Services/

CalculationService.php
WorkPeriodService.php
WageService.php
PdfService.php
RuleService.php

Alurnya:

Controller
    ↓
CalculationService
    ↓
RuleService
    ↓
Database
    ↓
Calculation
    ↓
Result

Dengan demikian User dan Admin menggunakan mesin penghitungan yang konsisten, tetapi Admin memiliki proses pemeriksaan yang lebih detail.

42. Frontend Technology

Untuk tahap pertama:

Laravel 10

Sebagai framework utama.

Blade

Untuk halaman frontend.

Tailwind CSS

Untuk desain modern dan responsive.

JavaScript

Untuk:

Stepper
Validasi form
Modal
Preview
Format rupiah
Perhitungan sementara pada UI
Interaksi dashboard

Namun hasil final tetap harus dihitung dan divalidasi di backend Laravel.

43. Desain Visual

Style:

Modern — Clean — Professional — Government/Corporate

Gunakan:

Card dengan rounded corner
Sidebar modern
Navbar sederhana
Form yang jelas
Badge status
Modal konfirmasi
Alert
Stepper
Table responsive
Mobile responsive
Ikon sederhana

Hindari:

Terlalu banyak warna
Animasi berlebihan
Dashboard terlalu ramai
Form panjang tanpa stepper
44. Responsive
Desktop
Sidebar
   │
   └── Content
Mobile
☰ SIMPEK

Content

Tabel admin harus bisa di-scroll horizontal pada layar kecil.

45. Fase Pengembangan
Fase 1 — Frontend

Fokus pada:

Landing page
Login
Register
Dashboard User
Calculator User
Result User
History User
Dashboard Admin
Calculator Admin
Verifikasi
Comparison
Rule management
User management
Responsive UI

Data masih dummy.

Fase 2 — Authentication

Implementasi:

Laravel Breeze
       ↓
Login
Register
Logout
       ↓
Role
       ↓
Admin / User
Fase 3 — Database

Implementasi:

users
calculations
calculation_rules
termination_reasons
regulations
audit_logs
Fase 4 — Calculation Engine

Implementasi:

CalculationService
       ↓
WorkPeriodService
       ↓
WageService
       ↓
RuleService
Fase 5 — Admin Verification

Implementasi:

User Result
     ↓
Admin Review
     ↓
Admin Calculation
     ↓
Comparison
     ↓
Admin Note
     ↓
Verification
     ↓
Final
Fase 6 — PDF

Implementasi:

Result
 ↓
PDF Template
 ↓
DomPDF
 ↓
Download
46. Acceptance Criteria
User
 User dapat register.
 User dapat login.
 User dapat melakukan penghitungan.
 User dapat memasukkan data pekerja.
 Sistem menghitung masa kerja.
 User dapat memasukkan komponen upah.
 User dapat memilih alasan PHK.
 Sistem menampilkan hasil UP.
 Sistem menampilkan UPMK.
 Sistem menampilkan UPH jika relevan.
 Sistem menampilkan total.
 User dapat melihat rincian.
 User dapat menyimpan hasil.
 User dapat melihat riwayat.
 User dapat download PDF.
Admin
 Admin dapat login.
 Admin memiliki dashboard.
 Admin dapat membuat penghitungan baru.
 Admin dapat melakukan penghitungan UP.
 Admin dapat melakukan penghitungan UPMK.
 Admin dapat melakukan penghitungan UPH.
 Admin dapat melihat penghitungan user.
 Admin dapat melakukan penghitungan ulang.
 Admin dapat membandingkan hasil.
 Admin dapat memberikan catatan.
 Admin dapat melakukan verifikasi.
 Admin dapat melakukan finalisasi.
 Admin dapat download PDF.
 Admin dapat mengelola user.
 Admin dapat mengelola aturan.
 Admin dapat mengelola alasan PHK.
 Admin dapat mengelola data peraturan.
 Sistem menyimpan audit trail.
47. Prinsip Penting Sistem

Ada 5 prinsip utama yang harus dijaga selama implementasi:

1. Jangan hard-code semua rumus di frontend
❌ JavaScript → langsung menentukan hasil final

✅ Laravel → Calculation Service → Rule Database
2. User dan Admin menggunakan mesin penghitungan yang sama

Tetapi Admin memiliki:

Data lebih lengkap
+
Review
+
Penghitungan ulang
+
Verifikasi
+
Finalisasi
3. Hasil user tidak langsung dianggap final

Status awal:

SIMULASI

Jika diperiksa admin:

DIVERIFIKASI

Jika sudah ditetapkan:

FINAL
4. Setiap hasil menyimpan versi aturan
Calculation
+
Rule Version
+
Regulation
+
Calculation Date
5. Sistem harus dapat mengikuti perubahan regulasi

Jangan membuat sistem dengan asumsi:

"PP 35/2021 akan selalu menjadi satu-satunya sumber aturan."

Sistem harus memungkinkan admin/pengelola memperbarui rule dan dasar hukum ketika terjadi perubahan peraturan.

Kesimpulan PRD

Konsep final SIMPEK adalah:

                     SIMPEK
                       │
              ┌────────┴────────┐
              │                 │
            USER              ADMIN
              │                 │
       Simulasi Mandiri    Penghitungan Detail
              │                 │
              ↓                 ↓
        Hasil Simulasi     Hasil Penghitungan
              │                 │
              └────────┬────────┘
                       ↓
                 VERIFIKASI
                       ↓
                  PERBANDINGAN
                       ↓
                  CATATAN ADMIN
                       ↓
                   FINALISASI
                       ↓
                   PDF REPORT

Jadi, admin bukan hanya "pengelola website". Admin juga berfungsi sebagai pihak yang dapat melakukan penghitungan ulang dan verifikasi terhadap simulasi user. Ini merupakan perubahan utama dari PRD sebelumnya dan menurut saya membuat rancangan sistem jauh lebih kuat untuk kebutuhan proyek Anda.

Untuk tahap coding, jangan langsung membuat semua halaman sekaligus. Urutan paling aman adalah Laravel 10 → Tailwind → Layout → Login/Register UI → Dashboard User → Calculator User → Result → Dashboard Admin → Calculator Admin → Verifikasi, baru setelah frontend selesai kita masuk ke database dan mesin rumus.