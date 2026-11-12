<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Services\CacheService;

class PublicController extends Controller
{
    public function welcome()
    {
        $data = Cache::remember('public_homepage_all_data', 300, function() {
            // Hanya ambil berita yang aktif (is_published = true / 1)
            $latestNews = \App\Models\User\NewsInformation::where('is_published', true)
                ->latest()
                ->take(12)
                ->get();

            // Ambil produk yang diaktifkan sebagai Unggulan oleh Admin (dibatasi 10 produk agar pas 2 baris x 5 kolom seperti Berita & Kegiatan)
            $featuredProducts = \App\Models\User\Product::with('umkmProfile')
                ->where('status', 'verified')
                ->where('is_featured', true)
                ->latest()
                ->take(10)
                ->get();

            // 1. Data Agregat Pokok (dikonsolidasikan dalam 1 query SQL ke umkm_profiles)
            $umkmAgg = DB::selectOne("
                SELECT
                    COUNT(*) FILTER (WHERE status != 'rejected') as total_umkm,
                    COUNT(*) FILTER (WHERE status = 'verified') as total_verified_umkm,
                    COUNT(DISTINCT district) FILTER (WHERE district IS NOT NULL AND district != '') as total_districts,
                    COUNT(*) FILTER (WHERE nib IS NOT NULL AND nib != '') as total_nib,
                    COUNT(*) FILTER (WHERE halal_cert IS NOT NULL AND halal_cert != '') as total_halal,
                    COUNT(*) FILTER (WHERE pirt IS NOT NULL AND pirt != '') as total_pirt,
                    COUNT(*) FILTER (WHERE gender = 'Laki-laki') as gender_male,
                    COUNT(*) FILTER (WHERE gender = 'Perempuan') as gender_female
                FROM umkm_profiles
            ");

            $totalUmkm = (int)($umkmAgg->total_umkm ?? 0);
            $totalVerifiedUmkm = (int)($umkmAgg->total_verified_umkm ?? 0);
            $totalDistricts = (int)($umkmAgg->total_districts ?? 0);
            $totalProducts = \App\Models\User\Product::where('status', 'verified')->count();
            $totalConsultations = \App\Models\User\Consultation::where('status', 'selesai')->count();

            // 2. Data Agregat Kategori Produk
            $categoryStats = \App\Models\User\Product::where('status', 'verified')
                ->select('category', DB::raw('count(*) as count'))
                ->groupBy('category')
                ->orderByDesc('count')
                ->get();

            // 3. Data Agregat Legalitas & Sertifikasi
            $legalitasStats = [
                'nib' => (int)($umkmAgg->total_nib ?? 0),
                'halal' => (int)($umkmAgg->total_halal ?? 0),
                'pirt' => (int)($umkmAgg->total_pirt ?? 0),
            ];

            // 4. Data Agregat Demografi Gender Pemilik UMKM
            $male = (int)($umkmAgg->gender_male ?? 0);
            $female = (int)($umkmAgg->gender_female ?? 0);
            $genderStats = [
                'male' => $male,
                'female' => $female,
                'total_specified' => $male + $female,
            ];

            // 5. Data Agregat Sebaran Wilayah per Kecamatan (Top 6)
            $districtStats = \App\Models\User\UmkmProfile::whereNotNull('district')
                ->where('district', '!=', '')
                ->select('district', DB::raw('count(*) as count'))
                ->groupBy('district')
                ->orderByDesc('count')
                ->take(6)
                ->get();

            // 6. Data Koordinat & Marker Persebaran HANYA Produk Unggulan Terpilih untuk Peta Interaktif
            $featuredProductsForMap = \App\Models\User\Product::with('umkmProfile')
                ->where('status', 'verified')
                ->where('is_featured', true)
                ->whereHas('umkmProfile', function($q) {
                    $q->where('status', 'verified');
                })
                ->latest()
                ->get();

            $seenUmkmCount = [];
            $umkmMapList = $featuredProductsForMap->map(function($product) use (&$seenUmkmCount) {
                $umkm = $product->umkmProfile;
                $coords = $umkm ? $umkm->coordinates : ['lat' => -7.8136, 'lng' => 110.9254, 'is_exact' => false, 'district' => 'Wonogiri'];

                $lat = $coords['lat'];
                $lng = $coords['lng'];

                $umkmId = $umkm ? $umkm->id : 0;
                if (!isset($seenUmkmCount[$umkmId])) {
                    $seenUmkmCount[$umkmId] = 0;
                } else {
                    $seenUmkmCount[$umkmId]++;
                    // Berikan offset radial halus jika ada beberapa produk unggulan dari UMKM yang sama agar titik tidak bertumpuk
                    $offsetAngle = $seenUmkmCount[$umkmId] * (2 * M_PI / 4);
                    $lat = round($lat + (0.0007 * sin($offsetAngle)), 6);
                    $lng = round($lng + (0.0007 * cos($offsetAngle) * 1.05), 6);
                }

                $productImg = $product->image_path 
                    ? asset('storage/' . $product->image_path) 
                    : ($umkm && $umkm->image_path ? asset('storage/' . $umkm->image_path) : asset('img/hero_wonogiri_3.jpg'));

                $cleanPhone = $umkm && !empty($umkm->phone) ? preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $umkm->phone)) : null;

                return [
                    'id' => $product->id,
                    'umkm_id' => $umkm ? $umkm->id : null,
                    'name' => $product->name,
                    'product_name' => $product->name,
                    'umkm_name' => $umkm ? $umkm->business_name : 'UMKM Wonogiri',
                    'owner' => $umkm ? ($umkm->owner_name ?? 'Pelaku UMKM') : 'Pelaku UMKM',
                    'district' => $umkm ? ($umkm->district ?: ($coords['district'] ?? 'Wonogiri')) : 'Wonogiri',
                    'village' => $umkm ? ($umkm->village ?? '') : '',
                    'address' => $umkm ? $umkm->full_address : 'Kabupaten Wonogiri, Jawa Tengah',
                    'phone' => $umkm ? ($umkm->phone ?? '') : '',
                    'category' => $product->category ?? 'Produk Unggulan',
                    'price' => 'Rp ' . number_format($product->price ?? 0, 0, ',', '.'),
                    'raw_price' => $product->price ?? 0,
                    'image' => $productImg,
                    'status' => $product->status,
                    'is_featured' => true,
                    'product_samples' => [$product->name],
                    'detail_url' => route('katalog.show', $product->id),
                    'store_url' => $umkm ? route('direktori.show', $umkm->id) : '#',
                    'directions_url' => $umkm ? $umkm->google_maps_directions_url : 'https://www.google.com/maps/search/?api=1&query=' . urlencode('Kabupaten Wonogiri'),
                    'whatsapp_url' => $cleanPhone ? 'https://wa.me/' . $cleanPhone . '?text=' . urlencode('Halo ' . ($umkm->business_name ?? 'UMKM') . ', saya tertarik dengan produk unggulan Anda: ' . $product->name) : null,
                    'lat' => $lat,
                    'lng' => $lng,
                    'is_exact' => $coords['is_exact'] ?? false,
                ];
            });

            return compact(
                'latestNews', 
                'featuredProducts', 
                'totalUmkm', 
                'totalVerifiedUmkm', 
                'totalProducts', 
                'totalConsultations',
                'totalDistricts',
                'categoryStats',
                'legalitasStats',
                'genderStats',
                'districtStats',
                'umkmMapList'
            );
        });

        return view('user.welcome', $data);
    }

    public function panduan(Request $request)
    {
        return view('user.panduan');
    }

    public function informasi(Request $request)
    {
        $query = \App\Models\User\NewsInformation::where('is_published', true);

        // Filter direct tanggal (misal dari input kalender YYYY-MM-DD)
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Filter pencarian cerdas kata kunci + tanggal
        if ($request->filled('q')) {
            $parsed = $this->parseDateAndKeywords($request->q);

            // Jika ada deteksi tanggal (misal '31 Oktober 2026', '31 Oktober', 'Oktober 2026', '31', dll)
            if ($parsed['date']) {
                $d = $parsed['date'];
                if ($d['type'] === 'full') {
                    $query->whereDay('created_at', $d['day'])
                          ->whereMonth('created_at', $d['month'])
                          ->whereYear('created_at', $d['year']);
                } elseif ($d['type'] === 'day_month') {
                    $query->whereDay('created_at', $d['day'])
                          ->whereMonth('created_at', $d['month']);
                } elseif ($d['type'] === 'month_year') {
                    $query->whereMonth('created_at', $d['month'])
                          ->whereYear('created_at', $d['year']);
                } elseif ($d['type'] === 'month') {
                    $query->whereMonth('created_at', $d['month']);
                } elseif ($d['type'] === 'year') {
                    $query->whereYear('created_at', $d['year']);
                } elseif ($d['type'] === 'day') {
                    $dayVal = $d['day'];
                    $query->where(function($b) use ($dayVal) {
                        $b->whereDay('created_at', $dayVal)
                          ->orWhere('title', 'ilike', "%{$dayVal}%")
                          ->orWhere('content', 'ilike', "%{$dayVal}%");
                    });
                }
            }

            // Jika ada sisa kata kunci teks (atau kata kunci umum)
            if (!empty($parsed['text'])) {
                $txt = $parsed['text'];
                $query->where(function($b) use ($txt) {
                    $b->where('title', 'ilike', "%{$txt}%")
                      ->orWhere('excerpt', 'ilike', "%{$txt}%")
                      ->orWhere('content', 'ilike', "%{$txt}%")
                      ->orWhere('category', 'ilike', "%{$txt}%");
                });
            }
        }

        if ($request->filled('kategori')) {
            $query->where('category', $request->kategori);
        }

        $newsList = $query->latest()->paginate(9)->withQueryString();

        return view('user.informasi', compact('newsList'));
    }

    /**
     * Parsing teks pencarian untuk mendeteksi tanggal (Indonesia, Inggris, angka) serta kata kunci teks.
     */
    private function parseDateAndKeywords($raw)
    {
        $months = [
            'januari' => 1, 'jan' => 1, 'january' => 1,
            'februari' => 2, 'feb' => 2, 'pebruari' => 2, 'february' => 2,
            'maret' => 3, 'mar' => 3, 'march' => 3,
            'april' => 4, 'apr' => 4,
            'mei' => 5, 'may' => 5,
            'juni' => 6, 'jun' => 6, 'june' => 6,
            'juli' => 7, 'jul' => 7, 'july' => 7,
            'agustus' => 8, 'agu' => 8, 'agt' => 8, 'aug' => 8, 'august' => 8,
            'september' => 9, 'sep' => 9, 'sept' => 9,
            'oktober' => 10, 'okt' => 10, 'oct' => 10, 'october' => 10,
            'november' => 11, 'nov' => 11, 'nopember' => 11,
            'desember' => 12, 'des' => 12, 'dec' => 12, 'december' => 12,
        ];

        $trimmed = trim($raw);
        $lower = strtolower($trimmed);
        $dateCondition = null;
        $remainingText = $trimmed;

        // 1. DD Month YYYY (cth: "31 Oktober 2026" atau "31 Okt 2026")
        if (preg_match('/\b(\d{1,2})\s+([a-z]+)\s+(\d{4})\b/i', $lower, $m, PREG_OFFSET_CAPTURE)) {
            $mName = strtolower($m[2][0]);
            if (isset($months[$mName])) {
                $dateCondition = [
                    'type' => 'full',
                    'day' => (int)$m[1][0],
                    'month' => $months[$mName],
                    'year' => (int)$m[3][0],
                    'label' => (int)$m[1][0] . ' ' . ucfirst($mName) . ' ' . (int)$m[3][0]
                ];
                $remainingText = trim(substr_replace($remainingText, '', $m[0][1], strlen($m[0][0])));
            }
        }
        // 2. YYYY-MM-DD
        elseif (preg_match('/\b(\d{4})[-\/](\d{1,2})[-\/](\d{1,2})\b/', $lower, $m, PREG_OFFSET_CAPTURE)) {
            $dateCondition = [
                'type' => 'full',
                'year' => (int)$m[1][0],
                'month' => (int)$m[2][0],
                'day' => (int)$m[3][0],
                'label' => (int)$m[3][0] . '-' . (int)$m[2][0] . '-' . (int)$m[1][0]
            ];
            $remainingText = trim(substr_replace($remainingText, '', $m[0][1], strlen($m[0][0])));
        }
        // 3. DD-MM-YYYY atau DD/MM/YYYY
        elseif (preg_match('/\b(\d{1,2})[-\/](\d{1,2})[-\/](\d{4})\b/', $lower, $m, PREG_OFFSET_CAPTURE)) {
            $dateCondition = [
                'type' => 'full',
                'day' => (int)$m[1][0],
                'month' => (int)$m[2][0],
                'year' => (int)$m[3][0],
                'label' => (int)$m[1][0] . '-' . (int)$m[2][0] . '-' . (int)$m[3][0]
            ];
            $remainingText = trim(substr_replace($remainingText, '', $m[0][1], strlen($m[0][0])));
        }
        // 4. DD Month (cth: "31 Oktober" atau "31 okt")
        elseif (preg_match('/\b(\d{1,2})\s+([a-z]+)\b/i', $lower, $m, PREG_OFFSET_CAPTURE)) {
            $mName = strtolower($m[2][0]);
            if (isset($months[$mName])) {
                $dateCondition = [
                    'type' => 'day_month',
                    'day' => (int)$m[1][0],
                    'month' => $months[$mName],
                    'label' => (int)$m[1][0] . ' ' . ucfirst($mName)
                ];
                $remainingText = trim(substr_replace($remainingText, '', $m[0][1], strlen($m[0][0])));
            }
        }
        // 5. DD-MM atau DD/MM (cth: "31/10" atau "31-10")
        elseif (preg_match('/^\s*(\d{1,2})[-\/](\d{1,2})\s*$/', $lower, $m)) {
            $dVal = (int)$m[1];
            $mVal = (int)$m[2];
            if ($dVal >= 1 && $dVal <= 31 && $mVal >= 1 && $mVal <= 12) {
                $dateCondition = [
                    'type' => 'day_month',
                    'day' => $dVal,
                    'month' => $mVal,
                    'label' => $dVal . '/' . $mVal
                ];
                $remainingText = '';
            }
        }
        // 6. Month YYYY (cth: "Oktober 2026")
        elseif (preg_match('/\b([a-z]+)\s+(\d{4})\b/i', $lower, $m, PREG_OFFSET_CAPTURE)) {
            $mName = strtolower($m[1][0]);
            if (isset($months[$mName])) {
                $dateCondition = [
                    'type' => 'month_year',
                    'month' => $months[$mName],
                    'year' => (int)$m[2][0],
                    'label' => ucfirst($mName) . ' ' . (int)$m[2][0]
                ];
                $remainingText = trim(substr_replace($remainingText, '', $m[0][1], strlen($m[0][0])));
            }
        }
        // 7. Nama bulan saja (cth: "Oktober" atau "okt")
        elseif (isset($months[$lower])) {
            $dateCondition = [
                'type' => 'month',
                'month' => $months[$lower],
                'label' => ucfirst($lower)
            ];
            $remainingText = '';
        }
        // 8. Tahun 4 digit saja (cth: "2026")
        elseif (preg_match('/^\s*(20\d{2})\s*$/', $lower, $m)) {
            $dateCondition = [
                'type' => 'year',
                'year' => (int)$m[1],
                'label' => 'Tahun ' . $m[1]
            ];
            $remainingText = '';
        }
        // 9. Tanggal hari saja 1-31 (cth: "31" atau "12")
        elseif (preg_match('/^\s*(\d{1,2})\s*$/', $lower, $m)) {
            $dayNum = (int)$m[1];
            if ($dayNum >= 1 && $dayNum <= 31) {
                $dateCondition = [
                    'type' => 'day',
                    'day' => $dayNum,
                    'label' => 'Tanggal ' . $dayNum
                ];
                $remainingText = '';
            }
        }

        $remainingText = trim(preg_replace('/[,\-\/]+/', ' ', $remainingText));

        return [
            'date' => $dateCondition,
            'text' => $remainingText,
        ];
    }

    public function showNews($id)
    {
        $news = \App\Models\User\NewsInformation::where('is_published', true)->findOrFail($id);

        // Navigasi Berita Sebelumnya & Selanjutnya
        $prevNews = \App\Models\User\NewsInformation::where('is_published', true)
            ->where('id', '<', $id)
            ->orderBy('id', 'desc')
            ->first();

        $nextNews = \App\Models\User\NewsInformation::where('is_published', true)
            ->where('id', '>', $id)
            ->orderBy('id', 'asc')
            ->first();

        // Berita Terkait (utamakan kategori yang sama)
        $otherNews = \App\Models\User\NewsInformation::where('is_published', true)
            ->where('id', '!=', $id)
            ->when($news->category, function($q) use ($news) {
                $q->orderByRaw("CASE WHEN category = ? THEN 0 ELSE 1 END", [$news->category]);
            })
            ->latest()
            ->take(4)
            ->get();

        // Berita Terbaru untuk Sidebar
        $recentNews = \App\Models\User\NewsInformation::where('is_published', true)
            ->where('id', '!=', $id)
            ->latest()
            ->take(4)
            ->get();

        return view('user.news_detail', compact('news', 'otherNews', 'prevNews', 'nextNews', 'recentNews'));
    }

    public function katalog(Request $request)
    {
        $query = \App\Models\User\Product::with('umkmProfile')->where('status', 'verified');
        
        if ($request->filled('q')) {
            $search = strtolower(trim($request->q));
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereHas('umkmProfile', function($q2) use ($search) {
                      $q2->whereRaw('LOWER(business_name) LIKE ?', ['%' . $search . '%'])
                         ->orWhereRaw('LOWER(address) LIKE ?', ['%' . $search . '%']);
                  });
            });
        }
        
        if ($request->filled('kategori')) {
            $cat = strtolower(trim($request->kategori));
            if ($cat === 'makanan' || str_contains($cat, 'makan')) {
                $query->whereRaw('LOWER(category) LIKE ?', ['%makan%']);
            } elseif ($cat === 'kerajinan' || str_contains($cat, 'rajin')) {
                $query->whereRaw('LOWER(category) LIKE ?', ['%rajin%']);
            } elseif ($cat === 'batik' || str_contains($cat, 'batik') || str_contains($cat, 'fashion')) {
                $query->where(function($cq) {
                    $cq->whereRaw('LOWER(category) LIKE ?', ['%batik%'])
                       ->orWhereRaw('LOWER(category) LIKE ?', ['%fashion%']);
                });
            } elseif ($cat === 'pertanian' || str_contains($cat, 'pertan')) {
                $query->whereRaw('LOWER(category) LIKE ?', ['%pertan%']);
            } elseif ($cat === 'kreatif' || str_contains($cat, 'kreatif')) {
                $query->whereRaw('LOWER(category) LIKE ?', ['%kreatif%']);
            } else {
                $query->whereRaw('LOWER(category) LIKE ?', ['%' . $cat . '%']);
            }
        }

        if ($request->filled('kecamatan')) {
            $dist = strtolower(trim($request->kecamatan));
            $query->whereHas('umkmProfile', function($q) use ($dist) {
                $q->where(function($subQ) use ($dist) {
                    $subQ->whereRaw('LOWER(district) LIKE ?', ['%' . $dist . '%'])
                         ->orWhereRaw('LOWER(address) LIKE ?', ['%' . $dist . '%']);
                });
            });
        }
        
        $products = $query->latest()->paginate(15)->withQueryString();

        $wilayahJsonPath = public_path('wonogiri_wilayah.json');
        $kecamatanList = file_exists($wilayahJsonPath)
            ? array_keys(json_decode(file_get_contents($wilayahJsonPath), true))
            : [
                'Baturetno', 'Batuwarno', 'Bulukerto', 'Eromoko', 'Girimarto', 
                'Giritontro', 'Giriwoyo', 'Jatipurno', 'Jatiroto', 'Jatisrono', 
                'Karangtengah', 'Kismantoro', 'Manyaran', 'Ngadirojo', 'Nguntoronadi', 
                'Paranggupito', 'Pracimantoro', 'Puhpelem', 'Purwantoro', 'Selogiri', 
                'Sidoharjo', 'Slogohimo', 'Tirtomoyo', 'Wonogiri', 'Wuryantoro'
            ];
        sort($kecamatanList);
        
        return view('user.katalog', compact('products', 'kecamatanList'));
    }

    public function direktori(Request $request)
    {
        $query = \App\Models\User\UmkmProfile::with(['user', 'products' => function($q) {
            $q->where('status', 'verified');
        }])->where('status', 'verified');
        
        if ($request->filled('q')) {
            $search = strtolower(trim($request->q));
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(business_name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(owner_name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(address) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(village) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(district) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $search . '%'])
                  ->orWhereHas('products', function($pq) use ($search) {
                      $pq->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                  });
            });
        }
        
        if ($request->filled('kategori')) {
            $kategori = strtolower(trim($request->kategori));
            $query->whereHas('products', function($pq) use ($kategori) {
                $pq->where('status', 'verified');
                if ($kategori === 'makanan' || str_contains($kategori, 'makan')) {
                    $pq->whereRaw('LOWER(category) LIKE ?', ['%makan%']);
                } elseif ($kategori === 'kerajinan' || str_contains($kategori, 'rajin')) {
                    $pq->whereRaw('LOWER(category) LIKE ?', ['%rajin%']);
                } elseif ($kategori === 'batik' || str_contains($kategori, 'batik') || str_contains($kategori, 'fashion')) {
                    $pq->where(function($cq) {
                        $cq->whereRaw('LOWER(category) LIKE ?', ['%batik%'])
                           ->orWhereRaw('LOWER(category) LIKE ?', ['%fashion%']);
                    });
                } elseif ($kategori === 'pertanian' || str_contains($kategori, 'pertan')) {
                    $pq->whereRaw('LOWER(category) LIKE ?', ['%pertan%']);
                } elseif ($kategori === 'kreatif' || str_contains($kategori, 'kreatif')) {
                    $pq->whereRaw('LOWER(category) LIKE ?', ['%kreatif%']);
                } else {
                    $pq->whereRaw('LOWER(category) LIKE ?', ['%' . $kategori . '%']);
                }
            });
        }

        if ($request->filled('kecamatan')) {
            $kecamatan = strtolower(trim($request->kecamatan));
            $query->where(function($q) use ($kecamatan) {
                $q->whereRaw('LOWER(district) LIKE ?', ['%' . $kecamatan . '%'])
                  ->orWhereRaw('LOWER(address) LIKE ?', ['%' . $kecamatan . '%']);
            });
        }
        
        $umkms = $query->latest()->paginate(12)->withQueryString();

        $umkmMapList = Cache::remember('umkm_map_list_verified', 600, function() {
            return \App\Models\User\UmkmProfile::with('products')
                ->where('status', 'verified')
                ->get()
                ->map->toMapPayload();
        });
        
        return view('user.direktori', compact('umkms', 'umkmMapList'));
    }

    public function getMapUmkmData(Request $request)
    {
        if (!$request->filled('kecamatan') && !$request->filled('q')) {
            $list = Cache::remember('umkm_map_list_verified', 600, function() {
                return \App\Models\User\UmkmProfile::with('products')
                    ->where('status', 'verified')
                    ->get()
                    ->map->toMapPayload();
            });
            return response()->json($list);
        }

        $query = \App\Models\User\UmkmProfile::with('products')->where('status', 'verified');
        
        if ($request->filled('kecamatan')) {
            $kec = strtolower(trim($request->kecamatan));
            $query->where(function($q) use ($kec) {
                $q->whereRaw('LOWER(district) LIKE ?', ['%' . $kec . '%'])
                  ->orWhereRaw('LOWER(address) LIKE ?', ['%' . $kec . '%']);
            });
        }

        if ($request->filled('q')) {
            $search = strtolower(trim($request->q));
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(business_name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(address) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(district) LIKE ?', ['%' . $search . '%']);
            });
        }

        $list = $query->get()->map->toMapPayload();
        return response()->json($list);
    }

    public function showProduct($id)
    {
        $product = \App\Models\User\Product::with('umkmProfile')->findOrFail($id);
        return view('user.product_detail', compact('product'));
    }

    public function showUmkm($id)
    {
        $umkm = \App\Models\User\UmkmProfile::with('products')->findOrFail($id);
        return view('user.umkm_detail', compact('umkm'));
    }

    public function konsultasi()
    {
        return view('user.konsultasi');
    }

    public function storeKonsultasi(Request $request)
    {
        if ($request->file('attachment') && ! $request->file('attachment')->isValid()) {
            \Illuminate\Support\Facades\Log::warning('Upload attachment error: ' . $request->file('attachment')->getError() . ' - ' . $request->file('attachment')->getErrorMessage());
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (!str_contains($value, '@')) {
                        $fail('Alamat email tidak valid. Harap sertakan simbol "@".');
                    } else {
                        $domain = explode('@', $value)[1] ?? '';
                        if (empty($domain)) {
                            $fail('Alamat email tidak lengkap. Harap masukkan nama domain (contoh: gmail.com).');
                        } elseif (!str_contains($domain, '.')) {
                            $fail('Alamat email tidak valid. Harap sertakan ekstensi domain (contoh: .com atau .co.id).');
                        }
                    }
                }
            ],
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments' => 'nullable|array|max:3',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,webp,pdf,doc,docx|max:5120',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf,doc,docx|max:5120',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'phone.required' => 'Nomor telepon atau WhatsApp wajib diisi.',
            'subject.required' => 'Topik konsultasi wajib dipilih.',
            'message.required' => 'Pesan atau detail konsultasi wajib diisi.',
            'attachments.max' => 'Maksimal 3 file lampiran yang dapat diunggah.',
            'attachments.*.mimes' => 'Format file lampiran harus berupa JPG, PNG, WEBP, PDF, atau DOC.',
            'attachments.*.max' => 'Ukuran masing-masing file lampiran tidak boleh lebih dari 5MB.',
            'attachment.mimes' => 'Format file lampiran harus berupa JPG, PNG, WEBP, PDF, atau DOC.',
            'attachment.max' => 'Ukuran file lampiran tidak boleh lebih dari 5MB.',
        ]);

        // Menggunakan UUID (Universally Unique Identifier) bawaan Laravel
        $ticket_id = (string) \Illuminate\Support\Str::uuid();

        $attachmentItems = [];
        $filesToProcess = [];

        if ($request->hasFile('attachments')) {
            $filesToProcess = $request->file('attachments');
        } elseif ($request->hasFile('attachment')) {
            $filesToProcess = [$request->file('attachment')];
        }

        foreach ($filesToProcess as $file) {
            if ($file && $file->isValid()) {
                $cleanName = time() . '_' . \Illuminate\Support\Str::random(5) . '_' . \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('consultations', $cleanName, 'public');

                $dataUri = null;
                try {
                    $mime = $file->getMimeType();
                    $base64 = base64_encode(file_get_contents($file->getRealPath()));
                    $dataUri = 'data:' . $mime . ';base64,' . $base64;
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning('Gagal encode base64 lampiran: ' . $e->getMessage());
                }

                $attachmentItems[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'data' => $dataUri,
                ];
            }
        }

        $storedAttachment = !empty($attachmentItems) ? json_encode($attachmentItems) : null;

        $consultation = \App\Models\Consultation::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'ticket_id' => $ticket_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'attachment' => $storedAttachment,
            'status' => 'menunggu',
        ]);

        // Simpan pesan awal ke percakapan consultation_messages
        \App\Models\ConsultationMessage::create([
            'consultation_id' => $consultation->id,
            'sender_type' => 'user',
            'sender_name' => $consultation->name,
            'user_id' => $consultation->user_id,
            'message' => $consultation->message,
            'attachment' => $storedAttachment,
        ]);

        // Mengirimkan email konfirmasi HTML resmi berisi UUID ke pengguna
        try {
            \Illuminate\Support\Facades\Mail::to($consultation->email)
                ->send(new \App\Mail\ConsultationTicketMail($consultation));
        } catch (\Exception $e) {
            // Jika gagal kirim email, beri tahu pengguna alasannya dan arahkan ke halaman cek tiket dengan ID di URL
            return redirect()->route('konsultasi.cek', ['ticket_id' => $ticket_id])
                ->with('error', 'Konsultasi Anda tersimpan, tetapi sistem gagal mengirimkan email ke alamat Anda. (Error: ' . $e->getMessage() . ')')
                ->with('ticket_id', $ticket_id)
                ->with('auto_copy', true);
        }

        // Arahkan langsung ke halaman cek konsultasi dengan ID di URL dan trigger auto-copy
        return redirect()->route('konsultasi.cek', ['ticket_id' => $ticket_id])
            ->with('success', 'Pengajuan konsultasi Anda berhasil dikirim! ID Tiket telah otomatis disalin ke clipboard.')
            ->with('ticket_id', $ticket_id)
            ->with('auto_copy', true);
    }

    public function cekKonsultasi(Request $request, $ticket_id = null)
    {
        // Jika parameter dikirim via query string (?ticket_id=...), redirect ke format URL bersih (/konsultasi/cek/{ticket_id})
        if ($request->filled('ticket_id') && empty($ticket_id)) {
            return redirect()->route('konsultasi.cek', ['ticket_id' => trim($request->ticket_id)]);
        }

        $ticketId = $ticket_id ?: $request->query('ticket_id');
        $consultations = collect();

        if (!empty($ticketId)) {
            $consultations = \App\Models\Consultation::with('messages')
                                ->where('ticket_id', $ticketId)
                                ->orderBy('created_at', 'desc')
                                ->get();
            
            if ($consultations->isEmpty()) {
                return redirect()->route('konsultasi.cek')
                    ->with('error', 'Riwayat konsultasi untuk ID Tiket "' . $ticketId . '" tidak ditemukan.');
            }
        }

        return view('user.konsultasi_cek', compact('consultations', 'ticketId'));
    }

    public function replyKonsultasiUser(Request $request, $ticket_id)
    {
        $consultation = \App\Models\Consultation::where('ticket_id', $ticket_id)->firstOrFail();

        // Validasi aturan: Jika status konsultasi sudah selesai, tolak balasan dan arahkan buat konsultasi baru
        if (strtolower((string)$consultation->status) === 'selesai') {
            return redirect()->route('konsultasi.cek', ['ticket_id' => $ticket_id])
                ->with('warning', 'Konsultasi ini telah dinyatakan selesai oleh Admin Dinas. Anda tidak dapat mengirim pesan balasan lagi pada tiket ini. Silakan buat pengajuan konsultasi baru jika memerlukan bantuan lanjutan.');
        }

        if (strtolower((string)$consultation->status) === 'ditolak') {
            return redirect()->route('konsultasi.cek', ['ticket_id' => $ticket_id])
                ->with('warning', 'Pengajuan konsultasi ini telah ditolak oleh Admin. Silakan buat pengajuan konsultasi baru.');
        }

        // Validasi aturan: Pengkonsultasi HANYA bisa menjawab jika pertanyaan pengkonsultasi sudah dijawab oleh admin
        if (!$consultation->canUserReply()) {
            return redirect()->route('konsultasi.cek', ['ticket_id' => $ticket_id])
                ->with('warning', 'Anda belum dapat membalas karena pertanyaan Anda sedang menunggu tanggapan resmi dari Admin Dinas.');
        }

        $request->validate([
            'message' => 'required|string|max:3000',
            'attachments' => 'nullable|array|max:3',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,webp,pdf,doc,docx|max:5120',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf,doc,docx|max:5120',
        ], [
            'message.required' => 'Pesan atau tanggapan balasan wajib diisi.',
            'message.max' => 'Pesan balasan maksimal 3000 karakter.',
            'attachments.max' => 'Maksimal 3 file lampiran yang dapat diunggah.',
            'attachments.*.mimes' => 'Format file lampiran harus berupa JPG, PNG, WEBP, PDF, atau DOC.',
            'attachments.*.max' => 'Ukuran masing-masing file lampiran tidak boleh lebih dari 5MB.',
            'attachment.mimes' => 'Format file lampiran harus berupa JPG, PNG, WEBP, PDF, atau DOC.',
            'attachment.max' => 'Ukuran file lampiran tidak boleh lebih dari 5MB.',
        ]);

        $attachmentItems = [];
        $filesToProcess = [];

        if ($request->hasFile('attachments')) {
            $filesToProcess = $request->file('attachments');
        } elseif ($request->hasFile('attachment')) {
            $filesToProcess = [$request->file('attachment')];
        }

        foreach ($filesToProcess as $file) {
            if ($file && $file->isValid()) {
                $cleanName = time() . '_' . \Illuminate\Support\Str::random(5) . '_' . \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('consultations', $cleanName, 'public');

                $dataUri = null;
                try {
                    $mime = $file->getMimeType();
                    $base64 = base64_encode(file_get_contents($file->getRealPath()));
                    $dataUri = 'data:' . $mime . ';base64,' . $base64;
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning('Gagal encode base64 lampiran balasan: ' . $e->getMessage());
                }

                $attachmentItems[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'data' => $dataUri,
                ];
            }
        }

        $storedAttachment = !empty($attachmentItems) ? json_encode($attachmentItems) : null;

        \App\Models\ConsultationMessage::create([
            'consultation_id' => $consultation->id,
            'sender_type' => 'user',
            'sender_name' => $consultation->name,
            'user_id' => auth()->check() ? auth()->id() : $consultation->user_id,
            'message' => $request->message,
            'attachment' => $storedAttachment,
        ]);

        // Perbarui status konsultasi secara otomatis ke 'menunggu' (Menunggu Balasan)
        // sehingga admin langsung melihat indikator bahwa tiket ini menunggu tanggapan admin berikutnya
        $consultation->update([
            'status' => 'menunggu',
            'updated_at' => now(),
        ]);

        return redirect()->route('konsultasi.cek', ['ticket_id' => $ticket_id])
            ->with('success', 'Balasan Anda berhasil terkirim ke Admin Dinas Perdagangan & KUKM Wonogiri. Mohon menunggu tanggapan selanjutnya.');
    }
}
