# DOKUMEN RINGKASAN LENGKAP PROYEK & RIWAYAT PERCAKAPAN
**Aplikasi:** Generator Perangkat Ajar & Modul Kurikulum Deep Learning  
**Domain Produksi:** [guru.vxai.online](https://guru.vxai.online)  
**Pengembang / Author:** Vicky Koroh  
**Tanggal Update Terakhir:** 27 September 2026  
**Status Git:** Branch `main` (Up-to-date di GitHub `https://github.com/Vicky1902-py/perangkat-ajar.git`)

---

> **CATATAN UNTUK MEMULAI SESI BARU:**  
> Jika Anda membuka chat/sesi baru dengan AI, cukup upload file ini dan katakan:  
> *"Halo, lanjutkan pengembangan aplikasi perangkat ajar ini berdasarkan dokumen ringkasan yang saya upload."*  
> AI akan langsung memahami seluruh arsitektur, histori perubahan, struktur database, integrasi NVIDIA NIM API, dan status terakhir aplikasi tanpa harus mengulang dari awal.

---

## 1. IKHTISAR SISTEM & ARSITEKTUR

Aplikasi ini adalah platform pembuat (generator) perangkat pembelajaran otomatis untuk guru berbasis regulasi kurikulum terbaru Indonesia:
1. **Regulasi Kurikulum:**
   - **BSKAP No. 046/H/KR/2025** (Capaian Pembelajaran PAUD, Dikdas, dan Dikmen).
   - **Permendikdasmen No. 13/2025** (Standar Kompetensi & Kurikulum Nasional).
   - **Permendikdasmen No. 10/2025** (8 Dimensi Profil Lulusan / Karakter).
   - **Konsep Deep Learning:** *Mindful Learning*, *Meaningful Learning*, dan *Joyful Learning*.
   - **Sintaks Pedagogis:** Model **PEDATTI** (*Pelajari, Dalami, Terapkan, Evaluasi, Refleksikan*).

2. **Pendekatan Sistem Pakar Hybrid (Rule-Based + NVIDIA NIM AI Cloud):**
   - **Single Source of Truth:** Seluruh Capaian Pembelajaran (CP), elemen, dan materi esensial bersumber dari database lokal (`capaian_pembelajarans`, `kurikulum_materis`, `template_pedattis`).
   - **Anti-Halusinasi Bounded Context:** NVIDIA NIM API (Model: `z-ai/glm-5.3-flash` & `deepseek-ai/deepseek-v4.1-flash`) difungsikan sebagai pengaya narasi pedagogis. AI dilarang keras mengarang CP/elemen di luar konteks database.
   - **Zero Downtime Fallback:** Apabila koneksi internet terputus atau API timeout, sistem otomatis beralih ke *Curriculum Knowledge Base* lokal tanpa ada error bagi guru.
   - Kecepatan generate 7 perangkat dijamin instan (< 1 detik).

3. **Tech Stack:**
   - **Backend:** Laravel 11.x, PHP 8.2+
   - **Database:** MySQL / MariaDB
   - **AI Microservices:** NVIDIA NIM Cloud API (Free Endpoints: `z-ai/glm-5.3-flash` & `deepseek-ai/deepseek-v4.1-flash`)
   - **Frontend:** Blade Templating, Bootstrap 5, Tailwind CSS, Alpine.js, Bootstrap Icons
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
  - Pengecekan `git grep -i "peserta didik"` bernilai **0 (nol match)** di luar skrip migrasi.
  - Database: Migrasi otomatis `2026_09_26_000001_replace_peserta_didik_with_murid_in_db.php`.

---

### C. Integrasi NVIDIA NIM AI Microservices (Free Endpoint)
- **Service:** [`App\Services\NvidiaAiService`](file:///C:/xampp/htdocs/perangkat-ajar/app/Services/NvidiaAiService.php)
- **Model Aktif:** `z-ai/glm-5.3-flash` (Free Endpoint cepat & stabil)
- **Fitur Baru Konsultasi Pakar AI (`/pakar-ai`):**
  - Panel konsultasi kurikulum untuk guru dengan rekomendasi pedagogis Deep Learning 3M, alur PEDATTI, dan strategi diferensiasi murid.
  - Dilengkapi verifikasi anti-halusinasi otomatis (grounded ke CP di database).
- **Pengaturan & Uji Koneksi di Superadmin (`/cms/settings`):**
  - Tab khusus "NVIDIA NIM AI" dengan tombol live AJAX "Uji Koneksi API NVIDIA Sekarang" yang mengonfirmasi status API key dan katalog model secara realtime.

---

### D. Mode Maintenance Khusus Superadmin
- Pengaturan berada di menu Superadmin (`/superadmin/pengaturan` atau `/cms/settings`) via tabel `app_settings` (`key = maintenance_mode`).
- Saat aktif:
  - Pengunjung umum, tamu, atau guru biasa akan diarahkan ke laman pemeliharaan eksklusif:  
    *"SISTEM DALAM PENGEMBANGAN BY. VICKY KOROH"* dengan tampilan UI modern, animasi pulse, dan indikator status.
  - Hanya akun dengan role **Superadmin** yang dapat mengakses dashboard dan seluruh fitur aplikasi untuk keperluan pengujian dan pemeliharaan.

---

### E. Fitur Superadmin Hapus Semua Perangkat & Notifikasi Pengguna
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
│   │   │   ├── PakarAiController.php      # Konsultasi kurikulum via NVIDIA NIM
│   │   │   ├── SuperAdminController.php   # Manajemen pengguna, settings, bulk delete
│   │   │   ├── SettingController.php      # Pengaturan, branding, adsense, test-nvidia
│   │   │   └── ExportController.php       # Ekspor PDF/Excel modul & LKPD
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
│       ├── SoalExpertService.php          # Engine pembuatan paket soal HOTS & rubrik
│       └── NvidiaAiService.php            # Engine integrasi NVIDIA NIM (Anti-Halusinasi)
├── config/
│   └── services.php                       # Konfigurasi credentials NVIDIA NIM
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
    ├── pakar-ai/                          # UI Konsultasi Sistem Pakar AI (NVIDIA NIM)
    ├── modul-ajar/                        # Tampilan Modul Ajar Deep Learning
    ├── lkpd/                              # Tampilan Lembar Kerja Murid (LKPD)
    ├── cms/settings/                      # Pengaturan Superadmin (Tab NVIDIA NIM)
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

# 3. Masukkan konfigurasi NVIDIA API Key di file .env server hosting jika belum ada:
# Buka file .env dan tambahkan:
# NVIDIA_API_KEY=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
# NVIDIA_API_URL=https://integrate.api.nvidia.com/v1
# NVIDIA_MODEL=z-ai/glm-5.3-flash
# NVIDIA_FALLBACK_MODEL=deepseek-ai/deepseek-v4.1-flash
# NVIDIA_TIMEOUT=30

# 4. Jalankan migrasi database otomatis
php artisan migrate --force

# 5. Bersihkan cache konfigurasi, rute, dan template Blade
php artisan optimize:clear
```

---

## 5. REKOMENDASI TAHAPAN PENGEMBANGAN BERIKUTNYA
1. Eksplorasi fitur ekspor hasil konsultasi Pakar AI langsung ke catatan pedagogis guru.
2. Penambahan visual infografis sintaks PEDATTI pada lembar PDF modul ajar.
3. Sinkronisasi materi muatan lokal daerah ke database kurikulum.

---
*Dokumen ini dibuat otomatis sebagai checkpoint resmi proyek Guru VxAI.*
