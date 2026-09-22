<?php

namespace Database\Seeders;

use App\Models\ProfilLulusan;
use Illuminate\Database\Seeder;

class ProfilLulusanSeeder extends Seeder
{
    public function run(): void
    {
        // Berdasarkan Permendikdasmen No. 10 Tahun 2025 (8 Dimensi Profil Lulusan)
        $dimensiList = [
            [
                'dimensi' => 'Keimanan dan Ketakwaan terhadap Tuhan Yang Maha Esa',
                'deskripsi' => 'Individu yang memiliki keyakinan teguh, menghayati, serta mengamalkan nilai-nilai spiritual dan ajaran agama/kepercayaannya dalam kehidupan sehari-hari, serta menjaga hubungan baik dengan Tuhan, sesama manusia, dan lingkungan.',
                'urutan' => 1,
            ],
            [
                'dimensi' => 'Kewargaan',
                'deskripsi' => 'Individu yang bangga akan identitas dan budaya bangsa, menghargai keberagaman, menjaga persatuan, menaati aturan/norma sosial, serta memiliki kepedulian terhadap keberlanjutan lingkungan dan harmoni antarbangsa.',
                'urutan' => 2,
            ],
            [
                'dimensi' => 'Penalaran Kritis',
                'deskripsi' => 'Individu yang mampu berpikir secara logis, analitis, dan reflektif dalam memahami informasi, mengevaluasi, serta memecahkan masalah nyata menggunakan literasi dan numerasi.',
                'urutan' => 3,
            ],
            [
                'dimensi' => 'Kreativitas',
                'deskripsi' => 'Individu yang mampu berpikir inovatif, fleksibel, orisinal, serta produktif dalam mengolah ide untuk menciptakan solusi unik dan bermanfaat bagi lingkungan sekitar.',
                'urutan' => 4,
            ],
            [
                'dimensi' => 'Kolaborasi',
                'deskripsi' => 'Individu yang mampu bekerja sama secara efektif, peduli, dan berbagi peran dengan berbagai kalangan untuk mencapai tujuan bersama melalui semangat gotong royong.',
                'urutan' => 5,
            ],
            [
                'dimensi' => 'Kemandirian',
                'deskripsi' => 'Individu yang bertanggung jawab atas proses dan hasil belajarnya, mampu mengambil inisiatif, mengatasi hambatan, serta beradaptasi dalam pengembangan diri.',
                'urutan' => 6,
            ],
            [
                'dimensi' => 'Kesehatan',
                'deskripsi' => 'Individu yang memiliki kesejahteraan lahir dan batin (well-being), menjalankan pola hidup bersih dan sehat, serta menjaga keseimbangan antara kebugaran fisik dan kesehatan mental.',
                'urutan' => 7,
            ],
            [
                'dimensi' => 'Komunikasi',
                'deskripsi' => 'Individu yang memiliki kemampuan komunikasi intrapribadi (untuk refleksi diri) dan antarpribadi yang efektif dalam menyampaikan ide serta gagasan.',
                'urutan' => 8,
            ],
        ];

        foreach ($dimensiList as $item) {
            ProfilLulusan::updateOrCreate(['dimensi' => $item['dimensi']], $item);
        }
    }
}
