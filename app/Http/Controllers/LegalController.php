<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Halaman Kebijakan Privasi (Privacy Policy) sesuai standar Google AdSense & UU PDP.
     */
    public function privacy()
    {
        return view('legal.privacy');
    }

    /**
     * Halaman Syarat & Ketentuan Layanan (Terms of Service).
     */
    public function terms()
    {
        return view('legal.terms');
    }

    /**
     * Halaman Tentang Kami (About Us).
     */
    public function about()
    {
        return view('legal.about');
    }

    /**
     * Halaman Kontak & Bantuan Dukungan (Contact Us).
     */
    public function contact()
    {
        return view('legal.contact');
    }

    /**
     * Halaman Pernyataan Penyangkalan Resmi (Disclaimer).
     */
    public function disclaimer()
    {
        return view('legal.disclaimer');
    }
}
