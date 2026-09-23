<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreatorProfileController extends Controller
{
    /**
     * Tampilkan landing page profil pembuat aplikasi (Publik).
     */
    public function index()
    {
        $creator = [
            'name' => app_setting('landing_creator_name', 'Vicky Koroh'),
            'headline' => app_setting('creator_headline', 'Software Engineer & Educational Technology Architect'),
            'role' => app_setting('landing_creator_role', 'Super Administrator & Lead Architect'),
            'avatar' => app_setting('creator_avatar', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80'),
            'bio' => app_setting('creator_bio', 'Vicky Koroh adalah pengembang teknologi pendidikan dan arsitek perangkat lunak yang berdedikasi menciptakan inovasi kecerdasan digital untuk memberdayakan para pendidik kejuruan (SMK) di seluruh nusantara. Dengan visi menghadirkan pengalaman belajar yang bermakna (Deep Learning), sistem ini dirancang untuk memangkas beban administratif guru sehingga proses pembelajaran dapat berjalan lebih efektif, inspiratif, dan berorientasi pada masa depan generasi muda Indonesia.'),
            'education' => app_setting('creator_education', 'Pakar Rekayasa Perangkat Lunak & Teknologi Pembelajaran Vokasi Modern'),
            'skills' => array_map('trim', explode(',', app_setting('creator_skills', 'AI System Engineering, Deep Learning Pedagogy, Cloud Infrastructure, Laravel Architecture, Kurikulum Merdeka SMK, Clean Code & Security'))),
            'desc' => app_setting('landing_creator_desc', 'Karya inovasi teknologi pendidikan kejuruan yang didesain dan dikembangkan secara khusus untuk mendukung guru SMK di seluruh Indonesia.'),
            'copyright_year' => app_setting('landing_copyright_year', '2026'),
            'whatsapp' => app_setting('creator_whatsapp', '081234567890'),
            'email' => app_setting('creator_email', 'vicky@vxai.online'),
            'github' => app_setting('creator_github', 'https://github.com/Vicky1902-py'),
            'linkedin' => app_setting('creator_linkedin', 'https://linkedin.com/in/vicky-koroh'),
            'instagram' => app_setting('creator_instagram', 'https://instagram.com/vicky_koroh'),
            'website' => app_setting('creator_website', 'https://guru.vxai.online'),
        ];

        return view('creator.index', compact('creator'));
    }
}
