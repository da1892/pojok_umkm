<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TrackVisitorMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya catat request GET yang sukses (200 OK)
        if ($request->method() !== 'GET' || $response->getStatusCode() !== 200) {
            return $response;
        }

        // Abaikan AJAX / JSON / asset statis
        if ($request->ajax() || $request->wantsJson()) {
            return $response;
        }

        $path = trim($request->path(), '/');

        // Daftar path yang diabaikan (area admin, asset, sistem)
        $ignoredPrefixes = [
            'admin',
            'api',
            'storage',
            'img',
            'images',
            'build',
            'css',
            'js',
            'livewire',
            'up',
            '_debugbar',
            'telescope',
            'horizon',
        ];

        foreach ($ignoredPrefixes as $prefix) {
            if ($path === $prefix || Str::startsWith($path, $prefix . '/')) {
                return $response;
            }
        }

        // Abaikan file statis
        if (preg_match('/\.(ico|png|jpg|jpeg|svg|css|js|map|woff|woff2|ttf|txt|xml)$/i', $path)) {
            return $response;
        }

        try {
            $this->recordVisit($request);
        } catch (\Throwable $e) {
            // Jangan biarkan error tracking mengganggu respon aplikasi
            \Illuminate\Support\Facades\Log::warning('TrackVisitorMiddleware Error: ' . $e->getMessage());
        }

        return $response;
    }

    /**
     * Catat kunjungan ke database
     */
    protected function recordVisit(Request $request): void
    {
        $sessionId = $request->session()->getId();
        $fullUrl = $request->fullUrl();

        // Debounce: Abaikan jika sesi yang sama mengakses URL yang sama persis dalam 15 detik terakhir
        $recentVisit = VisitorLog::where('session_id', $sessionId)
            ->where('url', $fullUrl)
            ->where('visited_at', '>=', Carbon::now()->subSeconds(15))
            ->exists();

        if ($recentVisit) {
            return;
        }

        $userAgent = $request->header('User-Agent', '');
        $device = $this->detectDevice($userAgent);
        $platform = $this->detectPlatform($userAgent);
        $browser = $this->detectBrowser($userAgent);
        $pageName = $this->detectPageName($request);

        VisitorLog::create([
            'ip_address' => $request->ip(),
            'session_id' => $sessionId,
            'url' => Str::limit($fullUrl, 500, ''),
            'route_name' => $request->route() ? $request->route()->getName() : null,
            'page_name' => $pageName,
            'device' => $device,
            'platform' => $platform,
            'browser' => $browser,
            'user_agent' => Str::limit($userAgent, 1000, ''),
            'referer' => Str::limit($request->header('referer'), 500, ''),
            'visited_at' => Carbon::now(),
        ]);
    }

    protected function detectDevice(string $ua): string
    {
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) {
            return 'Tablet';
        }
        if (preg_match('/(mobile|android|iphone|ipod|blackberry|opera mini|iemobile|wpdesktop)/i', $ua)) {
            return 'Mobile';
        }
        return 'Desktop';
    }

    protected function detectPlatform(string $ua): string
    {
        if (preg_match('/windows nt/i', $ua)) return 'Windows';
        if (preg_match('/android/i', $ua)) return 'Android';
        if (preg_match('/(iphone|ipad|ipod)/i', $ua)) return 'iOS';
        if (preg_match('/(macintosh|mac os x)/i', $ua)) return 'macOS';
        if (preg_match('/linux/i', $ua)) return 'Linux';
        return 'Other';
    }

    protected function detectBrowser(string $ua): string
    {
        if (preg_match('/Edg(e)?\//i', $ua)) return 'Edge';
        if (preg_match('/Chrome\//i', $ua) && !preg_match('/Edg/i', $ua)) return 'Chrome';
        if (preg_match('/Safari\//i', $ua) && !preg_match('/Chrome/i', $ua)) return 'Safari';
        if (preg_match('/Firefox\//i', $ua)) return 'Firefox';
        if (preg_match('/OPR\//i', $ua) || preg_match('/Opera/i', $ua)) return 'Opera';
        return 'Other';
    }

    protected function detectPageName(Request $request): string
    {
        $routeName = $request->route() ? $request->route()->getName() : '';
        $path = trim($request->path(), '/');

        if ($routeName === 'home' || $path === '') return 'Beranda Publik';
        if (Str::startsWith($routeName, 'katalog.show') || Str::startsWith($path, 'katalog/')) return 'Detail Produk';
        if (Str::startsWith($routeName, 'katalog') || $path === 'katalog') return 'Katalog Produk';
        if (Str::startsWith($routeName, 'direktori.show') || Str::startsWith($path, 'direktori/')) return 'Detail Profil UMKM';
        if (Str::startsWith($routeName, 'direktori') || $path === 'direktori') return 'Direktori UMKM';
        if (Str::startsWith($routeName, 'informasi.show') || Str::startsWith($path, 'informasi/')) return 'Detail Berita';
        if (Str::startsWith($routeName, 'informasi') || $path === 'informasi') return 'Berita & Agenda';
        if (Str::startsWith($routeName, 'panduan') || $path === 'panduan') return 'Info & Panduan';
        if (Str::startsWith($routeName, 'konsultasi') || $path === 'konsultasi') return 'Konsultasi Usaha';
        if (Str::startsWith($routeName, 'login') || $path === 'login') return 'Halaman Login';
        if (Str::startsWith($routeName, 'register') || $path === 'register') return 'Pendaftaran UMKM';

        return '/' . $path;
    }
}
