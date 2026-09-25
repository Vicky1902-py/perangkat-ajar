<?php

namespace Database\Seeders;

use App\Models\TemplatePedatti;
use Illuminate\Database\Seeder;

class TemplatePedattiSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            // 1. Pendahuluan
            [
                'tahap' => 'pendahuluan',
                'template_kegiatan' => '1. Guru membuka pembelajaran dengan salam hangat dan doa bersama (Olah Hati - Berkesadaran/Mindful).
2. Guru memeriksa kehadiran dan kenyamanan ruang belajar kelas/lab komputer (Kebugaran & Kesiapan Mental).
3. Guru memberikan stimulus/hook kontekstual berupa studi kasus industri nyata atau video singkat permasalahan faktual (Olah Pikir - Bermakna/Meaningful).
4. Guru mengajukan pertanyaan pemantik untuk menggali kompetensi awal murid.
5. Guru menyampaikan tujuan pembelajaran, skenario aktivitas alur PEDATTI, serta manfaat langsung materi bagi kesiapan dunia kerja SMK (Menggembirakan/Joyful).',
                'prinsip_deep_learning' => 'Mindful & Meaningful',
                'olah' => 'Olah Hati & Olah Pikir',
                'durasi_default_menit' => 15,
                'contoh_pertanyaan' => 'Pernahkah kalian menemui masalah sistem ini di kehidupan nyata? Menurut kalian, apa dampak jika kesalahan ini tidak ditangani?',
            ],
            // 2. Dalami
            [
                'tahap' => 'dalami',
                'template_kegiatan' => '1. Murid secara aktif membaca stimulus materi dan panduan konsep pada bahan ajar digital (Olah Pikir).
2. Guru memfasilitasi eksplorasi konsep esensial melalui demonstrasi interaktif / studi komparasi kasus terstruktur.
3. Murid berkolaborasi dalam kelompok kecil heterogen mendiskusikan prinsip kerja, arsitektur, atau formulasi pemecahan masalah (Olah Rasa & Kolaborasi).
4. Guru melakukan observasi formatif berkelanjutan untuk mengidentifikasi tingkat pemahaman dan memberikan scaffolding bagi kelompok yang membutuhkan diferensiasi.',
                'prinsip_deep_learning' => 'Mindful & Meaningful',
                'olah' => 'Olah Pikir & Olah Rasa',
                'durasi_default_menit' => 35,
                'contoh_pertanyaan' => 'Mengapa pendekatan ini lebih efektif dibanding metode sebelumnya? Apa saja parameter kunci yang menentukan keberhasilan sistem ini?',
            ],
            // 3. Terapkan
            [
                'tahap' => 'terapkan',
                'template_kegiatan' => '1. Murid menerima Lembar Kerja Murid (LKPD) berbasis proyek atau skenario problem-solving industri (Olah Raga/Kinestetik Praktik).
2. Setiap kelompok merancang, menulis kode, mempraktikkan konfigurasi, atau menyusun solusi sesuai kriteria spesifikasi teknis (Olah Pikir & Kemandirian).
3. Murid melakukan self-test dan debugging secara mandiri untuk menguji validitas hasil kerja mereka.
4. Guru mendampingi proses kerja praktikum, memberikan umpan balik langsung (feedback loops), dan mengamati ketercapaian dimensi profil lulusan.',
                'prinsip_deep_learning' => 'Meaningful & Joyful',
                'olah' => 'Olah Pikir & Olah Raga',
                'durasi_default_menit' => 45,
                'contoh_pertanyaan' => 'Bagaimana kalian membuktikan bahwa solusi yang kalian bangun sudah sesuai standar keamanan dan efisiensi industri?',
            ],
            // 4. Tularkan
            [
                'tahap' => 'tularkan',
                'template_kegiatan' => '1. Setiap perwakilan kelompok mempresentasikan hasil proyek / solusi LKPD di depan kelas atau melalui teknik gallery walk (Olah Rasa & Komunikasi Efektif).
2. Kelompok lain memberikan apresiasi, tanggapan kritis yang konstruktif, dan pertanyaan tindak lanjut (Kolaborasi & Penalaran Kritis).
3. Murid menyintesis perbedaan variasi solusi antarkelompok untuk memperkaya wawasan bersama (Olah Hati - Saling Menghargai Karya).
4. Guru mengklarifikasi miskonsepsi dan memberikan penguatan konsep secara komprehensif.',
                'prinsip_deep_learning' => 'Joyful & Meaningful',
                'olah' => 'Olah Rasa & Olah Hati',
                'durasi_default_menit' => 25,
                'contoh_pertanyaan' => 'Apa temuan paling mengejutkan yang kalian pelajari dari kelompok lain? Apa yang bisa diadaptasi untuk menyempurnakan karyamu?',
            ],
            // 5. Inovasi
            [
                'tahap' => 'inovasi',
                'template_kegiatan' => '1. Murid ditantang merumuskan modifikasi inovatif atau studi pengembangan fitur baru di luar spesifikasi dasar (Olah Pikir - Kreativitas).
2. Murid bersama guru melakukan refleksi mendalam (3 pertanyaan reflektif: Apa yang saya pahami? Apa tantangan tersulit? Bagaimana penerapannya di masa depan?).
3. Guru memberikan pengantar asesmen sumatif / tantangan pengayaan mandiri dan penugasan portofolio industri.
4. Pembelajaran ditutup dengan apresiasi atas komitmen belajar, penegasan nilai-nilai karakter Profil Lulusan, dan doa penutup (Olah Hati).',
                'prinsip_deep_learning' => 'Mindful, Meaningful, & Joyful',
                'olah' => 'Olah Pikir & Olah Hati',
                'durasi_default_menit' => 15,
                'contoh_pertanyaan' => 'Jika kalian memiliki waktu dan sumber daya tambahan, inovasi fitur apa yang ingin kalian ciptakan untuk menyelesaikan masalah sosial di lingkungan sekitar?',
            ],
        ];

        foreach ($templates as $t) {
            TemplatePedatti::updateOrCreate(
                ['tahap' => $t['tahap']],
                $t
            );
        }
    }
}
