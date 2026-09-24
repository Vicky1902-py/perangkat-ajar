<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Menghasilkan Peta Situs XML (Sitemap XML) untuk Google Search Console.
     */
    public function sitemap(): Response
    {
        $today = now()->toDateString();

        $urls = [
            [
                'loc' => url('/'),
                'lastmod' => $today,
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => route('generator.index'),
                'lastmod' => $today,
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
            [
                'loc' => route('creator.profile'),
                'lastmod' => $today,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
            [
                'loc' => route('login'),
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ],
            [
                'loc' => route('register'),
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ],
            [
                'loc' => route('legal.about'),
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ],
            [
                'loc' => route('legal.privacy'),
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
            [
                'loc' => route('legal.terms'),
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
            [
                'loc' => route('legal.contact'),
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
            [
                'loc' => route('legal.disclaimer'),
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
        ];

        return response()->view('seo.sitemap', compact('urls'))
            ->header('Content-Type', 'text/xml; charset=utf-8');
    }

    /**
     * Menyajikan file robots.txt untuk crawler Googlebot dan perayap publik lainnya.
     */
    public function robots(): Response
    {
        $defaultRobots = "User-agent: *\n"
            . "Allow: /\n"
            . "Disallow: /dashboard\n"
            . "Disallow: /cms/\n"
            . "Disallow: /profile/\n"
            . "Disallow: /users/\n"
            . "Disallow: /backup/\n"
            . "Disallow: /export/\n\n"
            . "Sitemap: " . url('/sitemap.xml') . "\n";

        $content = app_setting('robots_txt_content', $defaultRobots);

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }

    /**
     * Menangani file verifikasi HTML Google Search Console secara dinamis (misal /google123456789.html).
     */
    public function googleHtmlVerification(string $code): Response
    {
        $fileName = 'google' . $code . '.html';
        $content = 'google-site-verification: ' . $fileName . "\n";

        return response($content, 200, [
            'Content-Type' => 'text/html; charset=utf-8',
        ]);
    }
}
