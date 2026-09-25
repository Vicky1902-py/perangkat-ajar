# DOKUMEN RINGKASAN LENGKAP PROYEK & RIWAYAT PERCAKAPAN
**Aplikasi:** Generator Perangkat Ajar & Modul Kurikulum Deep Learning  
**Domain Produksi:** [guru.vxai.online](https://guru.vxai.online)  
**Pengembang / Author:** Vicky Koroh  
**Tanggal Update Terakhir:** 26 September 2026  
**Status Git:** Branch `main` (Up-to-date di GitHub `https://github.com/Vicky1902-py/perangkat-ajar.git`)

---

> **CATATAN UNTUK MEMULAI SESI BARU:**  
> Jika Anda membuka chat/sesi baru dengan AI, cukup upload file ini dan katakan:  
> *"Halo, lanjutkan pengembangan aplikasi perangkat ajar ini berdasarkan dokumen ringkasan yang saya upload."*  
> AI akan langsung memahami seluruh arsitektur, histori perubahan, struktur database, dan status terakhir aplikasi tanpa harus mengulang dari awal.

---

## 1. IKHTISAR SISTEM & ARSITEKTUR

Aplikasi ini adalah platform pembuat (generator) perangkat pembelajaran otomatis untuk guru berbasis regulasi kurikulum terbaru Indonesia:
1. **Regulasi Kurikulum:**
   - **BSKAP No. 046/H/KR/2025** (Capaian Pembelajaran PAUD, Dikdas, dan Dikmen).
   - **Permendikdasmen No. 13/2025** (Standar Kompetensi & Kurikulum Nasional).
   - **Permendikdasmen No. 10/2025** (8 Dimensi Profil Lulusan / Karakter).
   - **Konsep Deep Learning:** *Mindful Learning*, *Meaningful Learning*, dan *Joyful Learning*.
   - **Sintaks Pedagogis:** Model **PEDATTI** (*Pelajari, Dalami, Terapkan, Evaluasi, Refleksikan*).

2. **Pendekatan Tanpa Ketergantungan API Key (Zero API Cost):**
   - Sistem beralih total dari ketergantungan API eksternal pihak ketiga (seperti Gemini/OpenAI API) ke **Sistem Pakar Berbasis Basis Data Kurikulum Mandiri (`Curriculum Knowledge Base & Rule-based Expert System`)**.
   - Seluruh silabus CP, elemen, materi pokok, rangkuman, indikator, stimulus otentik, dan bank soal disimpan langsung di database (`kurikulum_materis`, `capaian_pembelajarans`, `template_pedattis`).
   - Kecepatan generate instan, stabil, bebas kuota, dan hemat biaya server 100%.

3. **Tech Stack:**
   - **Backend:** Laravel 11.x, PHP 8.2+
   - **Database:** MySQL / MariaDB
   - **Frontend:** Blade Templating, Tailwind CSS, Alpine.js, FontAwesome
   - **Export:** DomPDF (Export PDF rapi A4), PhpSpreadsheet (Excel)
   - **Hosting:** cPanel Apache/LiteSpeed (`guru.vxai.online`)

---

## 2. STATUS FITUR UTAMA YANG TELAH SELESAI

### A. Ke-7 Perangkat Ajar Hasil Generate (Telah Terstandarisasi 100%)
1. **Tujuan Pembelajaran (TP):**
   - Menggunakan KKO Taksonomi Bloom Revisi (menganalisis, mengevaluasi, merancang, memecahkan masalah).
   - Terikat langsung ke materi esensial elemen CP riil.
   - Menyertakan 8 Dimensi Profil Lulusan (Penalaran Kritis, Kreativitas, Kolaborasi, Kemandirian, dll.).
2. **Alur Tujuan Pembelajaran (ATP):**
   - Sintaks pembelajaran PEDATTI kontekstual per rumpun bidang studi (*Matematika, Bahasa, Sains, Informatika/AI, Sosial, Seni/Olahraga, Vokasi/SMK*).
   - Alokasi Jam Pelajaran (JP) dihitung secara proporsional dan dinamis.
3. **Modul Ajar (Deep Learning):**
   - Struktur lengkap: Identitas, Pemahaman Bermakna, Pertanyaan Pemantik, Sarana Prasarana, Asesmen Diagnostik, Formatif, Sumatif, dan Refleksi Guru.
   - Sintaks kegiatan PEDATTI menerapkan prinsip *Mindful, Meaningful, & Joyful* dengan variasi olah pikir, olah hati, olah rasa, dan olah raga.
4. **Lembar Kerja Murid (LKPD):**
   - Format: **Lembar Kerja Murid (LKPD) Deep Learning**.
   - Dilengkapi Stimulus Otentik kasus nyata, Alat & Bahan spesifik mata pelajaran, Petunjuk Belajar, dan Rubrik Penilaian.
   - 3 Tahapan Kerja: Memahami Konsep Esensial, Eksplorasi & Aplikasi Solutif, serta Refleksi Pemahaman.
5. **Program Tahunan (Prota):**
   - Distribusi materi per semester (Ganjil & Genap) dengan alokasi JP yang terhubung otomatis dari data ATP (`$tpJpMap`).
6. **Program Semester (Promes):**
   - Pemetaan minggu dan bulan efektif semester berjalan (Juli–Desember) yang sinkron dengan Prota.
7. **Instrumen Asesmen & Smart Soal:**
   - Standarisasi asesmen: Mapel Umum berdasar BSKAP No. 046/H/KR/2025; Mapel Kejuruan berdasar SKKNI & Dunia Usaha/Dunia Industri (DUDI).
   - Dilengkapi Kriteria Ketercapaian Tujuan Pembelajaran (KKTP) deskriptif skala 0–100 dan butir soal HOTS (Pilihan Ganda & Uraian) beserta rubrik penskoran.

---

### B. Standarisasi Istilah Wajib: "Peserta Didik" ➔ "Murid"
- **Aturan Ketat:** Seluruh terminologi `"peserta didik"` diubah menjadi `"murid"` (dengan mempertahankan kapitalisasi: `Murid`, `murid`, `MURID`).
- **Cakupan:**
  - Kode program: 27+ file (Controllers, Services, Views, Seeders, Routes, Test cases).
  - Pengecekan `git grep -i "peserta didik"` bernilai **0 (nol match)**.
  - Database lokal: 660+ baris data ter-update.
  - Telah dibuat migrasi otomatis: `2026_09_26_000001_replace_peserta_didik_with_murid_in_db.php`.

---

### C. Mode Maintenance Khusus Superadmin
- Pengaturan berada di menu Superadmin (`/superadmin/pengaturan`) via tabel `app_settings` (`key = maintenance_mode`).
- Saat aktif:
  - Pengunjung umum, tamu, atau guru biasa akan diarahkan ke laman pemeliharaan eksklusif:  
    *"SISTEM DALAM PENGEMBANGAN BY. VICKY KOROH"* dengan tampilan UI modern, animasi pulse, dan indikator status.
  - Hanya akun dengan role **Superadmin** yang dapat mengakses dashboard dan seluruh fitur aplikasi untuk keperluan pengujian dan pemeliharaan.

---

### D. Fitur Superadmin Hapus Semua Perangkat & Notifikasi Pengguna
- Superadmin memiliki tombol pembersihan/reset seluruh perangkat ajar jika terdapat pembaruan regulasi CP/ATP.
- Saat perangkat dihapus oleh Superadmin, pengguna mendapatkan notifikasi resmi di aplikasi:  
  *“Perangkat dihapus karena ada ketidaksesuaian dengan cp dan atp, mohon generate ulang, by. vicky koroh”*.

---

## 3. FILE-FILE PENTING & STRUKTUR KODE

```
perangkat-ajar/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── GeneratorController.php    # Handler request generate perangkat
│   │   │   ├── SuperAdminController.php   # Manajemen pengguna, settings, hapus perangkat
│   │   │   └── ExportController.php        # Ekspor PDF/Excel modul & LKPD
│   │   └── Middleware/
│   │       └── CheckMaintenanceMode.php   # Proteksi akses maintenance mode
│   ├── Models/
│   │   ├── CapaianPembelajaran.php
│   │   ├── KurikulumMateri.php            # Bank materi dan sub-materi CP
│   │   ├── TemplatePedatti.php            # Template sintaks PEDATTI
│   │   ├── ModulAjar.php & ModulAjarKegiatan.php
│   │   ├── Lkpd.php & LkpdKegiatan.php
│   │   └── AppSetting.php
│   └── Services/
│       ├── GeneratorService.php           # Core engine pembuatan 7 perangkat
│       ├── CurriculumKnowledgeBase.php    # Basis data silabus kurikulum per rumpun mapel
│       └── SoalExpertService.php          # Engine pembuatan paket soal HOTS & rubrik
├── database/
│   ├── migrations/
│   │   ├── 2026_09_23_000002_create_app_settings_table.php
│   │   ├── 2026_09_25_160622_create_kurikulum_materis_table.php
│   │   └── 2026_09_26_000001_replace_peserta_didik_with_murid_in_db.php
│   └── seeders/
│       ├── AllCapaianPembelajaranSmkSeeder.php
│       ├── KurikulumMateriSeeder.php
│       └── TemplatePedattiSeeder.php
└── resources/views/
    ├── maintenance.blade.php              # Tampilan maintenance mode "By. Vicky Koroh"
    ├── generator/                         # UI generator 7 perangkat
    ├── modul-ajar/                        # Tampilan Modul Ajar Deep Learning
    ├── lkpd/                              # Tampilan Lembar Kerja Murid (LKPD)
    └── exports/pdf/                       # Template cetak PDF A4
```

---

## 4. CARA DEPLOY DAN UPDATE KE HOSTING (`guru.vxai.online`)

Jika Anda ingin memperbarui hosting produksi melalui SSH cPanel, jalankan perintah berikut secara berurutan:

```bash
# 1. Pindah ke folder proyek di server hosting
cd ~/public_html
# (atau jika folder bernama subdomain: cd ~/guru.vxai.online)

# 2. Tarik update terbaru dari repository GitHub
git pull origin main

# 3. Jalankan migrasi database (otomatis memperbarui istilah 'peserta didik' ke 'murid')
php artisan migrate --force

# 4. Bersihkan cache konfigurasi dan template Blade
php artisan optimize:clear
```

Jika ingin menjalankan seeder materi baru di server hosting:
```bash
php artisan db:seed --class=KurikulumMateriSeeder --force
```

---

## 5. REKOMENDASI TAHAPAN PENGEMBANGAN BERIKUTNYA
Saat melanjutkan sesi kerja nanti, beberapa hal yang dapat dieksplorasi lebih jauh antara lain:
1. Penambahan materi untuk mata pelajaran muatan lokal atau mata pelajaran kejuruan spesifik lainnya.
2. Penambahan visual grafis/diagram alur otomatis pada modul ajar PDF.
3. Fitur kolaborasi antar-guru dalam satu rumpun MGMP sekolah.

---
*Dokumen ini dibuat otomatis sebagai checkpoint resmi proyek Guru VxAI.*
