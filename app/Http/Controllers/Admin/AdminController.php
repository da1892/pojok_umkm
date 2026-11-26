<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\User\UmkmProfile;
use App\Models\User\Product;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Services\CacheService;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingUmkms = UmkmProfile::with('products')->where('status', 'pending')->latest()->get();
        $pendingProducts = Product::with('umkmProfile')->where('status', 'pending')->latest()->get();
        
        $counts = Cache::remember('admin_dashboard_counts', 300, function() {
            return DB::selectOne("
                SELECT
                    (SELECT count(*) FROM umkm_profiles WHERE status = 'verified') as total_umkm,
                    (SELECT count(*) FROM umkm_profiles WHERE created_at >= NOW() - INTERVAL '7 days') as new_umkm_this_week,
                    (SELECT count(*) FROM products WHERE status = 'verified') as total_products,
                    (SELECT count(*) FROM products WHERE status = 'verified' AND updated_at >= NOW() - INTERVAL '7 days') as new_products_this_week,
                    (SELECT count(*) FROM consultations WHERE status IN ('menunggu', 'diproses')) as new_consultations,
                    (SELECT count(*) FROM consultations WHERE status = 'selesai') as completed_consultations,
                    (SELECT count(*) FROM consultations) as total_all_consultations
            ");
        });
        $totalUmkm = (int)($counts->total_umkm ?? 0);
        $newUmkmThisWeek = (int)($counts->new_umkm_this_week ?? 0);
        $totalProducts = (int)($counts->total_products ?? 0);
        $newProductsThisWeek = (int)($counts->new_products_this_week ?? 0);
        $newConsultations = (int)($counts->new_consultations ?? 0);
        $completedConsultations = (int)($counts->completed_consultations ?? 0);
        $totalAllConsultations = (int)($counts->total_all_consultations ?? 0);
        $completionRate = $totalAllConsultations > 0 ? round(($completedConsultations / $totalAllConsultations) * 100) : 100;

        $stats = Cache::remember('admin_dashboard_stats', 3600, function() {
            // Data Distribusi per Wilayah (Kecamatan)
            $districtStats = UmkmProfile::select('district')
                ->selectRaw("count(CASE WHEN products.status = 'verified' THEN products.id END) as total_products")
                ->selectRaw("count(DISTINCT umkm_profiles.id) as total_umkms")
                ->leftJoin('products', 'products.umkm_profile_id', '=', 'umkm_profiles.id')
                ->whereNotNull('district')
                ->where('district', '!=', '')
                ->groupBy('district')
                ->orderByDesc('total_products')
                ->orderBy('district')
                ->get();

            // Kategori Produk Real
            $categoryStats = Product::where('status', 'verified')
                ->select('category')
                ->selectRaw('count(*) as count')
                ->groupBy('category')
                ->orderByDesc('count')
                ->get();

            // Seluruh produk terverifikasi beserta info daerah UMKM untuk filter interaktif per daerah
            $allVerifiedProducts = Product::with('umkmProfile')
                ->where('status', 'verified')
                ->latest()
                ->get()
                ->map(function($p) {
                    return [
                        'id' => $p->id,
                        'name' => $p->name,
                        'category' => $p->category,
                        'image' => $p->image_path ? asset('storage/' . $p->image_path) : asset('images/no-image.png'),
                        'district' => $p->umkmProfile->district ?? '',
                        'village' => $p->umkmProfile->village ?? '',
                        'business_name' => $p->umkmProfile->business_name ?? '-',
                        'edit_url' => route('admin.product.edit', $p->id),
                    ];
                });

            // Semua UMKM terdaftar beserta daerahnya
            $allUmkms = UmkmProfile::select('id', 'business_name', 'district', 'village', 'status')->get();

            // Daftar kategori standar untuk grafik & filter produk UMKM
            $standardCategories = [
                'Makanan & Minuman',
                'Batik/Fashion',
                'Kerajinan',
                'Olahan Hasil Pertanian',
                'Produk Kreatif',
            ];
            $extraCategories = Product::whereNotNull('category')
                ->where('category', '!=', '')
                ->distinct()
                ->pluck('category')
                ->toArray();
            $allCategoriesList = array_values(array_unique(array_merge($standardCategories, $extraCategories)));

            // -------------------------------------------------------------
            // Data Statistik & Analitik Pengunjung Website (Real-time & History)
            // -------------------------------------------------------------
            $vAgg = DB::selectOne("
                SELECT
                    COUNT(*) as total_views,
                    COUNT(DISTINCT session_id) as total_visitors,
                    COUNT(*) FILTER (WHERE visited_at::date = CURRENT_DATE) as today_views,
                    COUNT(DISTINCT session_id) FILTER (WHERE visited_at::date = CURRENT_DATE) as today_visitors,
                    COUNT(*) FILTER (WHERE visited_at >= DATE_TRUNC('month', CURRENT_DATE)) as month_views,
                    COUNT(DISTINCT session_id) FILTER (WHERE visited_at >= DATE_TRUNC('month', CURRENT_DATE)) as month_visitors
                FROM visitor_logs
            ");

            $visitorSummary = [
                'today_visitors' => (int)($vAgg->today_visitors ?? 0),
                'today_views' => (int)($vAgg->today_views ?? 0),
                'month_visitors' => (int)($vAgg->month_visitors ?? 0),
                'month_views' => (int)($vAgg->month_views ?? 0),
                'total_visitors' => (int)($vAgg->total_visitors ?? 0),
                'total_views' => (int)($vAgg->total_views ?? 0),
            ];

            // 14 Hari Terakhir untuk Grafik Tren Kunjungan Harian
            $chartStartDate = Carbon::now()->subDays(13)->startOfDay();
            $dailyData = VisitorLog::where('visited_at', '>=', $chartStartDate)
                ->selectRaw("DATE(visited_at) as visit_date, count(*) as views, count(DISTINCT session_id) as visitors")
                ->groupByRaw("DATE(visited_at)")
                ->orderByRaw("DATE(visited_at)")
                ->get()
                ->keyBy(function($item) {
                    return Carbon::parse($item->visit_date)->toDateString();
                });

            $visitorDailyChart = [
                'labels' => [],
                'views' => [],
                'visitors' => [],
            ];
            for ($i = 13; $i >= 0; $i--) {
                $dt = Carbon::now()->subDays($i);
                $key = $dt->toDateString();
                $visitorDailyChart['labels'][] = $dt->translatedFormat('d M');
                $visitorDailyChart['views'][] = isset($dailyData[$key]) ? (int) $dailyData[$key]->views : 0;
                $visitorDailyChart['visitors'][] = isset($dailyData[$key]) ? (int) $dailyData[$key]->visitors : 0;
            }

            // Distribusi Perangkat (Mobile vs Desktop vs Tablet)
            $visitorDeviceStats = VisitorLog::select('device', DB::raw('count(*) as count'))
                ->groupBy('device')
                ->orderByDesc('count')
                ->get();

            // Distribusi Browser
            $visitorBrowserStats = VisitorLog::select('browser', DB::raw('count(*) as count'))
                ->groupBy('browser')
                ->orderByDesc('count')
                ->get();

            // 6 Halaman Terpopuler
            $visitorTopPages = VisitorLog::select('page_name', 'url', DB::raw('count(*) as count'))
                ->groupBy('page_name', 'url')
                ->orderByDesc('count')
                ->take(6)
                ->get();

            // Grafik Konsultasi Masuk per Bulan (Tahun Berjalan)
            $monthlyConsultations = \App\Models\Consultation::whereYear('created_at', now()->year)
                ->selectRaw("EXTRACT(MONTH FROM created_at)::int as month, count(*) as count")
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();
            $monthlyConsultationsData = array_map(function($m) use ($monthlyConsultations) {
                return (int)($monthlyConsultations[$m] ?? 0);
            }, range(1, 12));

            return compact(
                'districtStats',
                'categoryStats',
                'allVerifiedProducts',
                'allUmkms',
                'allCategoriesList',
                'visitorSummary',
                'visitorDailyChart',
                'visitorDeviceStats',
                'visitorBrowserStats',
                'visitorTopPages',
                'monthlyConsultationsData'
            );
        });

        // Data 25 Kecamatan dan 294 Desa asli Wonogiri dari master Excel
        if (!file_exists(public_path('wonogiri_wilayah.json'))) {
            try {
                \App\Services\WilayahService::syncFromExcel();
            } catch (\Throwable $e) {
                // Silently fallback if excel not reachable
            }
        }
        $wilayahWonogiri = file_exists(public_path('wonogiri_wilayah.json'))
            ? json_decode(file_get_contents(public_path('wonogiri_wilayah.json')), true)
            : [];

        // 8 Log Kunjungan Terkini
        $recentVisitors = VisitorLog::latest('visited_at')->take(8)->get();

        return view('admin.dashboard', array_merge([
            'pendingUmkms' => $pendingUmkms, 
            'pendingProducts' => $pendingProducts, 
            'totalUmkm' => $totalUmkm, 
            'newUmkmThisWeek' => $newUmkmThisWeek,
            'totalProducts' => $totalProducts,
            'newProductsThisWeek' => $newProductsThisWeek,
            'newConsultations' => $newConsultations,
            'completedConsultations' => $completedConsultations,
            'totalAllConsultations' => $totalAllConsultations,
            'completionRate' => $completionRate,
            'wilayahWonogiri' => $wilayahWonogiri,
            'recentVisitors' => $recentVisitors,
        ], $stats));
    }

    public function products(Request $request)
    {
        $query = Product::with('umkmProfile')
            ->orderByDesc('is_featured')
            ->orderByDesc('updated_at');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('category', 'ilike', "%{$search}%")
                  ->orWhereHas('umkmProfile', function($qu) use ($search) {
                      $qu->where('business_name', 'ilike', "%{$search}%")
                        ->orWhere('district', 'ilike', "%{$search}%")
                        ->orWhere('village', 'ilike', "%{$search}%");
                  });
            });
        }

        if ($request->filled('district')) {
            $districtClean = trim(preg_replace('/^(Kec\.|Kecamatan)\s+/i', '', $request->district));
            $query->whereHas('umkmProfile', function($q) use ($districtClean) {
                $q->where('district', 'ilike', '%' . $districtClean . '%');
            });
        }

        if ($request->filled('village')) {
            $villageClean = trim(preg_replace('/^(Ds\.|Desa|Kel\.|Kelurahan)\s+/i', '', $request->village));
            $query->whereHas('umkmProfile', function($q) use ($villageClean) {
                $q->where('village', 'ilike', '%' . $villageClean . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured == '1' || $request->featured == 'true');
        }

        if ($request->filled('umkm_id')) {
            $query->where('umkm_profile_id', $request->umkm_id);
        }

        if ($request->filled('umkm_filter') && $request->umkm_filter === 'no_featured') {
            // Filter produk dari UMKM yang belum memiliki produk unggulan sama sekali
            $umkmWithFeaturedIds = Product::where('is_featured', true)->whereNotNull('umkm_profile_id')->pluck('umkm_profile_id');
            $query->whereNotIn('umkm_profile_id', $umkmWithFeaturedIds);
        }

        $products = $query->paginate(10)->withQueryString();

        // Peta ID UMKM ke daftar Nama Produk Unggulan aktifnya (Maksimal 2 Produk per UMKM)
        $featuredByUmkm = Product::where('is_featured', true)
            ->whereNotNull('umkm_profile_id')
            ->select('id', 'name', 'umkm_profile_id')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->groupBy('umkm_profile_id')
            ->map(function($prods) {
                return $prods->pluck('name')->toArray();
            })
            ->toArray();

        // Data sentra kecamatan beserta jumlah produknya untuk tombol filter cepat (cached)
        $districtsWithCounts = Cache::remember('admin_products_districts', 300, function() {
            return UmkmProfile::select('district')
                ->selectRaw("count(products.id) as total_products")
                ->leftJoin('products', 'products.umkm_profile_id', '=', 'umkm_profiles.id')
                ->whereNotNull('district')
                ->where('district', '!=', '')
                ->groupBy('district')
                ->orderByDesc('total_products')
                ->orderBy('district')
                ->get();
        });

        $allCategories = Cache::remember('admin_products_categories', 300, function() {
            return Product::select('category')->distinct()->whereNotNull('category')->pluck('category');
        });

        $wilayahWonogiri = file_exists(public_path('wonogiri_wilayah.json'))
            ? json_decode(file_get_contents(public_path('wonogiri_wilayah.json')), true)
            : [];
        $allKecamatanList = !empty($wilayahWonogiri) ? array_keys($wilayahWonogiri) : [];
        sort($allKecamatanList);

        $prodCounts = DB::selectOne("
            SELECT
                COUNT(*) as total,
                COUNT(*) FILTER (WHERE is_featured = true) as featured
            FROM products
        ");
        $totalAllProducts = (int)($prodCounts->total ?? 0);
        $totalFeaturedProducts = (int)($prodCounts->featured ?? 0);

        return view('admin.products.index', compact(
            'products', 
            'districtsWithCounts', 
            'allCategories', 
            'allKecamatanList',
            'totalAllProducts',
            'totalFeaturedProducts',
            'featuredByUmkm',
            'wilayahWonogiri'
        ));
    }

    public function createProduct(Request $request)
    {
        $allUmkms = UmkmProfile::select('id', 'business_name', 'owner_name', 'district', 'village', 'phone')
            ->orderBy('business_name', 'asc')
            ->get()
            ->map(function ($store) {
                $store->business_name = Str::title(trim($store->business_name));
                $store->owner_name = Str::title(trim($store->owner_name));
                return $store;
            });

        $selectedUmkmId = $request->query('umkm_id');
        
        $standardCategories = [
            'Makanan & Minuman',
            'Batik/Fashion',
            'Kerajinan',
            'Olahan Hasil Pertanian',
            'Produk Kreatif',
            'Lainnya',
        ];

        return view('admin.products.create', compact('allUmkms', 'selectedUmkmId', 'standardCategories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'umkm_profile_id' => 'required|exists:umkm_profiles,id',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'umkm_profile_id.required' => 'Pilih Toko UMKM pemilik produk ini.',
            'umkm_profile_id.exists' => 'Toko UMKM yang dipilih tidak valid.',
            'name.required' => 'Nama produk wajib diisi.',
            'category.required' => 'Kategori produk wajib dipilih.',
            'images.max' => 'Maksimal 5 foto produk dapat diunggah.',
            'images.*.image' => 'File foto harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'images.*.max' => 'Ukuran gambar maksimal 5MB.',
            'image.image' => 'File foto harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        $umkm = UmkmProfile::findOrFail($request->umkm_profile_id);

        $allImagesPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file->isValid() && count($allImagesPaths) < 5) {
                    $path = $file->store('products', 'public');
                    $allImagesPaths[] = $path;
                }
            }
        } elseif ($request->hasFile('image')) {
            $allImagesPaths[] = $request->file('image')->store('products', 'public');
        }

        $imagePath = !empty($allImagesPaths) ? $allImagesPaths[0] : null;

        $isFeatured = $request->has('is_featured');

        $productData = [
            'umkm_profile_id' => $umkm->id,
            'name' => trim($request->name),
            'category' => trim($request->category),
            'price' => null,
            'description' => $request->description ? trim($request->description) : trim($request->name),
            'image_path' => $imagePath,
            'status' => 'verified',
        ];

        if (Schema::hasColumn('products', 'images')) {
            $productData['images'] = !empty($allImagesPaths) ? $allImagesPaths : null;
        }
        if (Schema::hasColumn('products', 'is_featured')) {
            $productData['is_featured'] = $isFeatured;
        }

        $product = Product::create($productData);

        // Bersihkan cache produk
        Cache::forget('admin_products_districts');
        Cache::forget('admin_products_categories');
        Cache::forget('admin_dashboard_stats');
        Cache::forget('home_featured_products');

        if ($request->input('action') === 'save_and_add_another') {
            return redirect()->route('admin.products.create', ['umkm_id' => $umkm->id])
                ->with('success', "Produk '{$product->name}' berhasil ditambahkan untuk toko '{$umkm->business_name}'! Silakan masukkan produk berikutnya di bawah ini.");
        }

        return redirect()->route('admin.products')
            ->with('success', "Produk '{$product->name}' berhasil ditambahkan untuk toko '{$umkm->business_name}' dan langsung tayang di katalog publik!");
    }

    public function consultations()
    {
        $consultations = \App\Models\Consultation::with(['messages.user'])
            ->orderByRaw("CASE WHEN status = 'menunggu' THEN 0 ELSE 1 END ASC")
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('admin.consultations.index', compact('consultations'));
    }
    
    public function replyConsultation(Request $request, $id)
    {
        $consultation = \App\Models\Consultation::findOrFail($id);
        
        // Otomatisasi status berdasarkan tindakan yang dipilih
        $action = $request->input('action', 'balas');
        $targetStatus = match($action) {
            'selesai' => 'selesai',
            'buka_kembali' => 'diproses',
            default => 'diproses' // Menanggapi konsultasi: percakapan tetap berjalan dan berlanjut
        };

        if (!in_array($targetStatus, ['menunggu', 'diterima', 'diproses', 'selesai', 'ditolak'])) {
            $targetStatus = 'diproses';
        }

        $response = trim((string) $request->input('response'));

        // Jika tombol selesai atau buka kembali diklik dari tombol atas tanpa mengisi teks di textarea
        if (empty($response)) {
            if ($targetStatus === 'selesai') {
                $response = 'Konsultasi telah dinyatakan selesai oleh Admin Dinas Perdagangan & KUKM Kabupaten Wonogiri. Terima kasih telah memanfaatkan layanan konsultasi Pojok UMKM.';
            } elseif ($action === 'buka_kembali') {
                $response = 'Konsultasi dibuka kembali oleh Admin Dinas untuk tindak lanjut tambahan.';
            } else {
                return back()->withErrors(['response' => 'Wajib menuliskan tanggapan atau balasan untuk pengkonsultasi.'])->withInput();
            }
        }

        $request->merge([
            'status' => $targetStatus,
            'response' => $response,
        ]);

        $request->validate([
            'status' => 'required|in:menunggu,diterima,diproses,selesai,ditolak',
            'response' => 'required|string|max:3000',
        ], [
            'response.required' => 'Wajib menyertakan balasan atau tanggapan untuk pemohon.',
            'response.max' => 'Tanggapan / balasan maksimal 3000 karakter.'
        ]);
        
        // Simpan balasan admin ke dalam pesan percakapan (consultation_messages)
        \App\Models\ConsultationMessage::create([
            'consultation_id' => $consultation->id,
            'sender_type' => 'admin',
            'sender_name' => auth()->user()->name ?? 'Admin Dinas Perdagangan & KUKM',
            'user_id' => auth()->id(),
            'message' => $response,
            'attachment' => null,
        ]);

        $consultation->update([
            'status' => $targetStatus,
            'response' => $response,
            'admin_id' => auth()->id()
        ]);

        \App\Services\CacheService::clearPublicCache();
        
        // Kirim email notifikasi balasan resmi ke pengkonsultasi jika ada email
        $emailSent = false;
        if (!empty($consultation->email)) {
            try {
                \Illuminate\Support\Facades\Mail::to($consultation->email)
                    ->send(new \App\Mail\ConsultationReplyMail($consultation, $response));
                $emailSent = true;
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Gagal mengirim email balasan konsultasi #' . $consultation->ticket_id . ': ' . $e->getMessage());
            }
        }

        $statusLabels = [
            'diproses' => $action === 'buka_kembali' ? 'dibuka kembali (status: Sedang Diproses)' : 'diberikan tanggapan (konsultasi tetap berjalan & berlanjut)',
            'selesai' => 'diselesaikan (sesi ditutup, pengkonsultasi harus membuat pengajuan baru jika ingin berkonsultasi lagi)',
            'ditolak' => 'ditolak (status: Ditolak)',
            'diterima' => 'diterima',
            'menunggu' => 'diperbarui',
        ];
        $label = $statusLabels[$targetStatus] ?? 'diperbarui';

        $emailMsg = $emailSent ? " Notifikasi email jawaban telah dikirim ke {$consultation->email}." : "";
        return back()->with('success', "Tiket konsultasi #{$consultation->ticket_id} berhasil {$label}.{$emailMsg}");
    }

    public function verifications()
    {
        $pendingUmkms = UmkmProfile::with('products')->where('status', 'pending')->latest()->get();
        $pendingProducts = Product::with('umkmProfile')->where('status', 'pending')->latest()->get();
        return view('admin.verifications.index', compact('pendingUmkms', 'pendingProducts'));
    }

    public function reports(Request $request)
    {
        return $this->visitorStats($request);
    }

    public function visitorStats(Request $request)
    {
        $period = $request->get('period', '30_days');
        $now = Carbon::now();

        $query = VisitorLog::query();

        switch ($period) {
            case 'today':
                $query->whereDate('visited_at', Carbon::today());
                $periodLabel = 'Hari Ini (' . $now->translatedFormat('d F Y') . ')';
                $daysForChart = 1;
                break;
            case '7_days':
                $query->where('visited_at', '>=', Carbon::now()->subDays(6)->startOfDay());
                $periodLabel = '7 Hari Terakhir';
                $daysForChart = 7;
                break;
            case 'this_month':
                $query->where('visited_at', '>=', Carbon::now()->startOfMonth());
                $periodLabel = 'Bulan Ini (' . $now->translatedFormat('F Y') . ')';
                $daysForChart = max(1, $now->day);
                break;
            case 'all_time':
                $periodLabel = 'Sepanjang Waktu';
                $daysForChart = 30;
                break;
            case '30_days':
            default:
                $query->where('visited_at', '>=', Carbon::now()->subDays(29)->startOfDay());
                $periodLabel = '30 Hari Terakhir';
                $daysForChart = 30;
                break;
        }

        // Summary cards untuk periode yang dipilih
        $totalViews = (clone $query)->count();
        $uniqueVisitors = (clone $query)->distinct('session_id')->count('session_id');

        // Ringkasan Tetap (Hari Ini & Bulan Ini) dikonsolidasikan dalam 1 query SQL
        $fixedSummary = DB::selectOne("
            SELECT
                COUNT(*) FILTER (WHERE visited_at::date = CURRENT_DATE) as today_views,
                COUNT(DISTINCT session_id) FILTER (WHERE visited_at::date = CURRENT_DATE) as today_visitors,
                COUNT(*) FILTER (WHERE visited_at >= date_trunc('month', CURRENT_DATE)) as month_views,
                COUNT(DISTINCT session_id) FILTER (WHERE visited_at >= date_trunc('month', CURRENT_DATE)) as month_visitors
            FROM visitor_logs
        ");
        $todayViews = (int)($fixedSummary->today_views ?? 0);
        $todayVisitors = (int)($fixedSummary->today_visitors ?? 0);
        $monthViews = (int)($fixedSummary->month_views ?? 0);
        $monthVisitors = (int)($fixedSummary->month_visitors ?? 0);

        // Chart Data Kunjungan
        $chartStartDate = Carbon::now()->subDays($daysForChart - 1)->startOfDay();
        $dailyData = VisitorLog::where('visited_at', '>=', $chartStartDate)
            ->selectRaw("DATE(visited_at) as visit_date, count(*) as views, count(DISTINCT session_id) as visitors")
            ->groupByRaw("DATE(visited_at)")
            ->orderByRaw("DATE(visited_at)")
            ->get()
            ->keyBy(function($item) {
                return Carbon::parse($item->visit_date)->toDateString();
            });

        $chartLabels = [];
        $chartViews = [];
        $chartVisitors = [];
        for ($i = $daysForChart - 1; $i >= 0; $i--) {
            $dt = Carbon::now()->subDays($i);
            $key = $dt->toDateString();
            $chartLabels[] = $dt->translatedFormat('d M');
            $chartViews[] = isset($dailyData[$key]) ? (int) $dailyData[$key]->views : 0;
            $chartVisitors[] = isset($dailyData[$key]) ? (int) $dailyData[$key]->visitors : 0;
        }

        // Breakdown Perangkat (Device)
        $deviceStats = (clone $query)->select('device', DB::raw('count(*) as count'))
            ->groupBy('device')
            ->orderByDesc('count')
            ->get();

        // Breakdown Browser
        $browserStats = (clone $query)->select('browser', DB::raw('count(*) as count'))
            ->groupBy('browser')
            ->orderByDesc('count')
            ->get();

        // Breakdown Platform/OS
        $platformStats = (clone $query)->select('platform', DB::raw('count(*) as count'))
            ->groupBy('platform')
            ->orderByDesc('count')
            ->get();

        // Top Pages
        $topPages = (clone $query)->select('page_name', 'url', DB::raw('count(*) as count'))
            ->groupBy('page_name', 'url')
            ->orderByDesc('count')
            ->take(10)
            ->get();

        // Log Kunjungan dengan filter & pagination
        $logQuery = VisitorLog::latest('visited_at');
        if ($request->filled('q')) {
            $q = $request->q;
            $logQuery->where(function($b) use ($q) {
                $b->where('ip_address', 'like', "%{$q}%")
                  ->orWhere('page_name', 'like', "%{$q}%")
                  ->orWhere('url', 'like', "%{$q}%")
                  ->orWhere('browser', 'like', "%{$q}%")
                  ->orWhere('platform', 'like', "%{$q}%");
            });
        }
        if ($request->filled('device_filter')) {
            $logQuery->where('device', $request->device_filter);
        }
        $visitorLogs = $logQuery->paginate(15)->withQueryString();

        return view('admin.visitors.index', compact(
            'period',
            'periodLabel',
            'totalViews',
            'uniqueVisitors',
            'todayViews',
            'todayVisitors',
            'monthViews',
            'monthVisitors',
            'chartLabels',
            'chartViews',
            'chartVisitors',
            'deviceStats',
            'browserStats',
            'platformStats',
            'topPages',
            'visitorLogs'
        ));
    }

    public function settings()
    {
        return view('admin.settings.index');
    }

    public function showUmkm($id)
    {
        $umkm = UmkmProfile::with('products')->findOrFail($id);
        return view('admin.umkm.show', compact('umkm'));
    }

    public function verifyUmkm($id)
    {
        $umkm = UmkmProfile::findOrFail($id);
        $umkm->update([
            'status' => 'verified',
            'rejection_note' => null
        ]);
        if ($umkm->user && $umkm->user->role !== 'admin') {
            $umkm->user->update(['role' => 'umkm']);
        }
        return back()
            ->with('success', "Profil UMKM '{$umkm->business_name}' berhasil diverifikasi dan disetujui.")
            ->with('verified_item', [
                'type' => 'umkm',
                'title' => 'PROFIL TOKO UMKM',
                'name' => $umkm->business_name,
                'owner' => $umkm->owner_name,
                'action' => 'approved',
                'message' => 'Pendaftaran profil UMKM telah resmi disetujui & aktif di direktori sistem.'
            ]);
    }

    public function rejectUmkm(Request $request, $id)
    {
        $umkm = UmkmProfile::findOrFail($id);
        
        $request->validate([
            'rejection_note' => 'required|string|max:1000'
        ], [
            'rejection_note.required' => 'Wajib mengetikkan komentar atau alasan penolakan saat menolak pengajuan buka toko UMKM.',
            'rejection_note.max' => 'Alasan penolakan maksimal 1000 karakter.'
        ]);

        $umkm->update([
            'status' => 'rejected',
            'rejection_note' => $request->rejection_note
        ]);

        return back()
            ->with('success', "Profil UMKM '{$umkm->business_name}' telah ditolak dengan catatan alasan penolakan.")
            ->with('verified_item', [
                'type' => 'umkm',
                'title' => 'PROFIL TOKO UMKM',
                'name' => $umkm->business_name,
                'owner' => $umkm->owner_name,
                'action' => 'rejected',
                'note' => $request->rejection_note,
                'message' => 'Pengajuan profil UMKM telah ditolak dengan catatan perbaikan untuk pemilik usaha.'
            ]);
    }

    public function verifyProduct($id)
    {
        $product = Product::with('umkmProfile')->findOrFail($id);
        $product->update([
            'status' => 'verified',
            'rejection_note' => null
        ]);
        $umkmName = $product->umkmProfile ? $product->umkmProfile->business_name : 'UMKM';
        return back()
            ->with('success', "Produk '{$product->name}' (UMKM: {$umkmName}) berhasil diverifikasi dan disetujui.")
            ->with('verified_item', [
                'type' => 'product',
                'title' => 'PRODUK UMKM',
                'name' => $product->name,
                'umkm_name' => $umkmName,
                'category' => $product->category,
                'action' => 'approved',
                'message' => 'Produk berhasil diverifikasi dan langsung tayang pada katalog produk publik.'
            ]);
    }

    public function rejectProduct(Request $request, $id)
    {
        $product = Product::with('umkmProfile')->findOrFail($id);

        $request->validate([
            'rejection_note' => 'required|string|max:1000'
        ], [
            'rejection_note.required' => 'Wajib mengetikkan komentar atau alasan penolakan saat menolak produk.',
            'rejection_note.max' => 'Alasan penolakan maksimal 1000 karakter.'
        ]);

        $product->update([
            'status' => 'rejected',
            'rejection_note' => $request->rejection_note
        ]);

        $umkmName = $product->umkmProfile ? $product->umkmProfile->business_name : 'UMKM';
        return back()
            ->with('success', "Pengajuan produk '{$product->name}' (UMKM: {$umkmName}) telah ditolak dengan catatan alasan penolakan.")
            ->with('verified_item', [
                'type' => 'product',
                'title' => 'PRODUK UMKM',
                'name' => $product->name,
                'umkm_name' => $umkmName,
                'category' => $product->category,
                'action' => 'rejected',
                'note' => $request->rejection_note,
                'message' => 'Produk telah ditolak dan tidak akan ditampilkan pada katalog produk UMKM.'
            ]);
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
        ], [
            'images.max' => 'Maksimal 5 foto produk dapat diunggah.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'images.*.max' => 'Ukuran setiap gambar maksimal 5MB.'
        ]);

        $data = [
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'is_featured' => $request->boolean('is_featured'),
        ];

        $newImagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (count($newImagePaths) < 5) {
                    $newImagePaths[] = $file->store('products', 'public');
                }
            }
        } elseif ($request->hasFile('image')) {
            $newImagePaths[] = $request->file('image')->store('products', 'public');
        }

        if (!empty($newImagePaths)) {
            $data['images'] = $newImagePaths;
            $data['image_path'] = $newImagePaths[0];
        }

        if ($request->boolean('is_featured')) {
            if ($product->status !== 'verified') {
                $data['status'] = 'verified';
                $data['rejection_note'] = null;
            }
        }

        $product->update($data);
        if ($request->boolean('is_featured')) {
            $product->touch();
        }

        CacheService::clearPublicCache();

        return redirect()->route('admin.products')->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        CacheService::clearPublicCache();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function toggleFeaturedProduct(Request $request, $id)
    {
        $product = Product::with('umkmProfile')->findOrFail($id);
        $wasPending = false;

        if (!$product->is_featured) {
            $product->is_featured = true;

            // Jika status belum verified, otomatis setujui agar langsung tayang
            if ($product->status !== 'verified') {
                $product->status = 'verified';
                $product->rejection_note = null;
                $wasPending = true;
            }
        } else {
            // Membatalkan status unggulan
            $product->is_featured = false;
        }

        $product->save();
        $product->touch(); // Perbarui updated_at agar tercatat sebagai unggulan paling baru

        // Bersihkan cache publik agar peta dan beranda langsung terbarui seketika
        CacheService::clearPublicCache();

        if ($product->is_featured) {
            $statusText = $wasPending 
                ? 'disetujui & langsung dijadikan Produk Unggulan di Beranda & Peta' 
                : 'dijadikan Produk Unggulan dan tampil di Beranda & Peta';
        } else {
            $statusText = 'dihapus dari daftar Produk Unggulan';
        }

        $msg = "Produk \"{$product->name}\" berhasil {$statusText}.";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_featured' => (bool)$product->is_featured,
                'status' => $product->status,
                'message' => $msg
            ]);
        }

        return back()->with('success', $msg);
    }

    public function editUmkm($id)
    {
        $umkm = UmkmProfile::findOrFail($id);
        return view('admin.umkm.edit', compact('umkm'));
    }

    public function updateUmkm(Request $request, $id)
    {
        $umkm = UmkmProfile::findOrFail($id);
        
        $request->validate([
            'business_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'gender' => 'nullable|string|in:Laki-laki,Perempuan',
            'phone' => ['required', 'string', 'min:10', 'max:25'],
            'province' => 'nullable|string|max:100',
            'regency' => 'nullable|string|max:100',
            'district' => 'required|string',
            'village' => 'required|string',
            'postal_code' => ['nullable', 'string', 'size:5', 'regex:/^[0-9]+$/'],
            'address' => 'required|string',
            'description' => 'nullable|string',
            'nib' => ['nullable', 'string', 'regex:/^[0-9]{13}$/'],
            'pirt' => ['nullable', 'string', 'min:15', 'max:35'],
            'halal_cert' => ['nullable', 'string', 'min:10', 'max:35'],
            'status' => 'nullable|string|in:pending,verified,rejected'
        ], [
            'gender.in' => 'Pilihan jenis kelamin tidak valid.',
            'nib.regex' => 'Nomor Induk Berusaha (NIB) harus terdiri dari 13 digit angka standar OSS.',
            'pirt.min' => 'Nomor Sertifikasi PIRT minimal 15 karakter/digit standar BPOM/Dinkes.',
            'halal_cert.min' => 'Nomor Sertifikasi Halal minimal 10 karakter/digit standar BPJPH/MUI.',
            'postal_code.size' => 'Kode pos harus terdiri dari 5 digit angka.',
            'phone.min' => 'Nomor telepon/WhatsApp minimal 10 digit angka.',
        ]);

        $data = $request->only(
            'business_name', 'owner_name', 'gender', 'phone', 'province', 'regency',
            'district', 'village', 'postal_code', 'address',
            'description', 'nib', 'pirt', 'halal_cert'
        );

        if ($request->has('status')) {
            $data['status'] = $request->status;
        }

        $umkm->update($data);

        if ($request->input('redirect_to') === 'users') {
            return redirect()->route('admin.users.index')->with('success', "Data & detail profil UMKM '{$umkm->business_name}' berhasil diperbarui.");
        }

        return redirect()->route('admin.stores')->with('success', 'Data UMKM berhasil diperbarui.');
    }

    public function stores(Request $request)
    {
        $query = UmkmProfile::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('business_name', 'ilike', "%{$search}%")
                  ->orWhere('owner_name', 'ilike', "%{$search}%")
                  ->orWhere('gender', 'ilike', "%{$search}%")
                  ->orWhere('district', 'ilike', "%{$search}%")
                  ->orWhere('village', 'ilike', "%{$search}%")
                  ->orWhere('address', 'ilike', "%{$search}%")
                  ->orWhere('province', 'ilike', "%{$search}%")
                  ->orWhere('regency', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $umkms = $query->latest()->paginate(10)->withQueryString();
        return view('admin.stores.index', compact('umkms'));
    }

    public function destroyUmkm($id)
    {
        $umkm = UmkmProfile::findOrFail($id);
        $businessName = $umkm->business_name;
        $userId = $umkm->user_id;

        // Bersihkan foto toko dari storage
        if ($umkm->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($umkm->image_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($umkm->image_path);
        }

        // Bersihkan produk dan gambar produk
        foreach ($umkm->products as $product) {
            if ($product->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_path);
            }
            if (!empty($product->images) && is_array($product->images)) {
                foreach ($product->images as $img) {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($img)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($img);
                    }
                }
            }
            $product->delete();
        }

        $umkm->delete();
        
        return back()->with('success', "Akun UMKM '{$businessName}' beserta seluruh produknya telah berhasil dihapus.");
    }

    // ================= BERITA & KEGIATAN CRUD =================

    public function news(Request $request)
    {
        $query = \App\Models\User\NewsInformation::with('author');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $isPub = $request->status === 'published' ? 1 : 0;
            $query->where('is_published', $isPub);
        }

        $newsList = $query->latest()->paginate(10)->withQueryString();
        return view('admin.news.index', compact('newsList'));
    }

    public function createNews()
    {
        return view('admin.news.create');
    }

    public function storeNews(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_published' => 'nullable',
        ]);

        $uploadedPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $uploadedPaths[] = $file->store('news', 'public');
            }
        }

        $imagePath = count($uploadedPaths) > 0 ? $uploadedPaths[0] : null;

        \App\Models\User\NewsInformation::create([
            'title' => $request->title,
            'category' => $request->category,
            'excerpt' => $request->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($request->content), 120),
            'content' => $request->content,
            'image_path' => $imagePath,
            'images' => $uploadedPaths,
            'is_published' => $request->has('is_published'),
            'author_id' => auth()->id(),
        ]);

        return redirect()->route('admin.news')->with('success', 'Berita & Kegiatan berhasil ditambahkan.');
    }

    public function editNews($id)
    {
        $news = \App\Models\User\NewsInformation::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function updateNews(Request $request, $id)
    {
        $news = \App\Models\User\NewsInformation::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_published' => 'nullable',
        ]);

        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'excerpt' => $request->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($request->content), 120),
            'content' => $request->content,
            'is_published' => $request->has('is_published'),
        ];

        if ($request->hasFile('images')) {
            $uploadedPaths = [];
            foreach ($request->file('images') as $file) {
                $uploadedPaths[] = $file->store('news', 'public');
            }
            $data['images'] = $uploadedPaths;
            $data['image_path'] = $uploadedPaths[0] ?? null;
        }

        $news->update($data);

        return redirect()->route('admin.news')->with('success', 'Berita & Kegiatan berhasil diperbarui.');
    }

    public function toggleNews($id)
    {
        $news = \App\Models\User\NewsInformation::findOrFail($id);
        $news->is_published = !$news->is_published;
        $news->save();

        $statusText = $news->is_published ? 'diaktifkan (Ditampilkan)' : 'dinonaktifkan (Disembunyikan)';
        return back()->with('success', "Status berita '{$news->title}' berhasil {$statusText}.");
    }

    public function destroyNews($id)
    {
        $news = \App\Models\User\NewsInformation::findOrFail($id);
        $news->delete();

        return back()->with('success', 'Berita & Kegiatan berhasil dihapus.');
    }

    // ==========================================
    // MODUL KHUSUS: UMKM BINAAN DINAS (NON-DEVICE)
    // ==========================================

    private function ensureBinaanSchema()
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasColumn('umkm_profiles', 'is_managed_by_admin')) {
                \Illuminate\Support\Facades\DB::statement('ALTER TABLE umkm_profiles ADD COLUMN IF NOT EXISTS is_managed_by_admin BOOLEAN DEFAULT FALSE');
            }
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE umkm_profiles ALTER COLUMN user_id DROP NOT NULL');
        } catch (\Throwable $e) {
            // Abaikan jika tidak punya akses DDL
        }
    }

    public function binaanIndex(Request $request)
    {
        $this->ensureBinaanSchema();

        $hasCol = \Illuminate\Support\Facades\Schema::hasColumn('umkm_profiles', 'is_managed_by_admin');

        $query = UmkmProfile::with(['user', 'products'])
            ->where(function($q) use ($hasCol) {
                if ($hasCol) {
                    $q->where('is_managed_by_admin', true)
                      ->orWhereNull('user_id')
                      ->orWhereHas('user', fn($u) => $u->where('role', 'admin'));
                } else {
                    $q->whereNull('user_id')
                      ->orWhereHas('user', fn($u) => $u->where('role', 'admin'));
                }
            });

        $tab = $request->input('tab', 'all');
        if ($tab === 'offline') {
            $query->where(function($q) use ($hasCol) {
                if ($hasCol) {
                    $q->whereNull('user_id')->orWhere('is_managed_by_admin', true);
                } else {
                    $q->whereNull('user_id');
                }
            })->whereDoesntHave('user', function($u) {
                $u->where('role', 'umkm');
            });
        } elseif ($tab === 'online') {
            $query->whereHas('user', function($u) {
                $u->where('role', 'umkm');
            });
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('business_name', 'ilike', "%{$search}%")
                  ->orWhere('owner_name', 'ilike', "%{$search}%")
                  ->orWhere('district', 'ilike', "%{$search}%")
                  ->orWhere('village', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        $binaanUmkms = $query->latest()->paginate(10)->withQueryString();

        $totalBinaan = UmkmProfile::where(function($q) use ($hasCol) {
            if ($hasCol) {
                $q->where('is_managed_by_admin', true)
                  ->orWhereNull('user_id')
                  ->orWhereHas('user', fn($u) => $u->where('role', 'admin'));
            } else {
                $q->whereNull('user_id')
                  ->orWhereHas('user', fn($u) => $u->where('role', 'admin'));
            }
        })->count();

        $totalProdukBinaan = Product::whereHas('umkmProfile', function($q) use ($hasCol) {
            if ($hasCol) {
                $q->where('is_managed_by_admin', true)
                  ->orWhereNull('user_id')
                  ->orWhereHas('user', fn($u) => $u->where('role', 'admin'));
            } else {
                $q->whereNull('user_id')
                  ->orWhereHas('user', fn($u) => $u->where('role', 'admin'));
            }
        })->count();

        $totalSudahKlaim = UmkmProfile::whereHas('user', fn($u) => $u->where('role', 'umkm'))
            ->where(function($q) use ($hasCol) {
                if ($hasCol) {
                    $q->where('is_managed_by_admin', true)
                      ->orWhereNull('user_id');
                } else {
                    $q->whereNull('user_id');
                }
            })
            ->count();

        $totalBelumKlaim = max(0, $totalBinaan - $totalSudahKlaim);
        $districts = $this->wilayahWonogiri;

        return view('admin.binaan.index', compact(
            'binaanUmkms',
            'totalBinaan',
            'totalProdukBinaan',
            'totalBelumKlaim',
            'totalSudahKlaim',
            'tab',
            'districts'
        ));
    }

    public function binaanCreateUmkm()
    {
        $districts = $this->wilayahWonogiri;
        return view('admin.binaan.create_umkm', compact('districts'));
    }

    public function binaanStoreUmkm(Request $request)
    {
        $this->ensureBinaanSchema();

        $request->validate([
            'business_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:25',
            'district' => 'required|string',
            'village' => 'required|string',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'nib' => 'nullable|string|max:50',
            'pirt' => 'nullable|string|max:50',
            'halal_cert' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $cleanName = time() . '_' . Str::slug($request->business_name) . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('umkm_profiles', $cleanName, 'public');
        }

        $data = [
            'user_id' => null,
            'business_name' => $request->business_name,
            'owner_name' => $request->owner_name,
            'gender' => $request->gender ?? 'Laki-laki',
            'phone' => $request->phone ?: 'Dikelola Dinas KUKM',
            'province' => 'Jawa Tengah',
            'regency' => 'Kabupaten Wonogiri',
            'district' => $request->district,
            'village' => $request->village,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'description' => $request->description,
            'nib' => $request->nib,
            'pirt' => $request->pirt,
            'halal_cert' => $request->halal_cert,
            'map_link' => $request->map_link,
            'image_path' => $imagePath,
            'status' => 'verified',
        ];

        if (\Illuminate\Support\Facades\Schema::hasColumn('umkm_profiles', 'is_managed_by_admin')) {
            $data['is_managed_by_admin'] = true;
        }

        try {
            $umkm = UmkmProfile::create($data);
        } catch (\Throwable $e) {
            $data['user_id'] = auth()->id();
            $umkm = UmkmProfile::create($data);
        }

        return redirect()->route('admin.binaan.index')->with('success', "UMKM Binaan '{$umkm->business_name}' berhasil didaftarkan dan langsung berstatus Terverifikasi.");
    }

    public function binaanCreateProduct(Request $request)
    {
        $this->ensureBinaanSchema();

        $hasCol = \Illuminate\Support\Facades\Schema::hasColumn('umkm_profiles', 'is_managed_by_admin');
        $binaanUmkms = UmkmProfile::where(function($q) use ($hasCol) {
            if ($hasCol) {
                $q->where('is_managed_by_admin', true)
                  ->orWhereNull('user_id')
                  ->orWhereHas('user', fn($u) => $u->where('role', 'admin'));
            } else {
                $q->whereNull('user_id')
                  ->orWhereHas('user', fn($u) => $u->where('role', 'admin'));
            }
        })->orderBy('business_name', 'asc')->get();

        $selectedUmkmId = $request->query('umkm_id');

        return view('admin.binaan.create_product', compact('binaanUmkms', 'selectedUmkmId'));
    }

    public function binaanStoreProduct(Request $request)
    {
        $request->validate([
            'umkm_profile_id' => 'required|exists:umkm_profiles,id',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'all_images' => 'nullable|array|max:4',
            'all_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'umkm_profile_id.required' => 'Pilih UMKM Binaan pemilik produk ini.',
            'name.required' => 'Nama produk wajib diisi.',
            'image.required' => 'Foto utama produk wajib diunggah.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $cleanName = time() . '_' . Str::slug($request->name) . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('products', $cleanName, 'public');
        }

        $allImagesPaths = [];
        if ($imagePath) {
            $allImagesPaths[] = $imagePath;
        }

        if ($request->hasFile('all_images')) {
            foreach ($request->file('all_images') as $idx => $extraFile) {
                if ($extraFile->isValid()) {
                    $extraName = time() . '_' . $idx . '_' . Str::slug($request->name) . '.' . $extraFile->getClientOriginalExtension();
                    $extraPath = $extraFile->storeAs('products', $extraName, 'public');
                    $allImagesPaths[] = $extraPath;
                }
            }
        }

        $isFeatured = $request->boolean('is_featured');

        $product = Product::create([
            'umkm_profile_id' => $request->umkm_profile_id,
            'name' => $request->name,
            'category' => $request->category,
            'price' => null,
            'description' => $request->description,
            'image_path' => $imagePath,
            'all_images' => !empty($allImagesPaths) ? $allImagesPaths : null,
            'status' => 'verified',
            'is_featured' => $isFeatured,
        ]);

        return redirect()->route('admin.binaan.index')
            ->with('success', "Produk '{$product->name}' berhasil ditambahkan ke UMKM Binaan dan langsung tayang di katalog publik.")
            ->with('verified_item', [
                'type' => 'product',
                'name' => $product->name,
                'umkm_name' => $umkm->business_name,
                'action' => 'verified',
                'message' => 'Produk binaan berhasil ditambahkan dan langsung aktif di katalog produk publik.'
            ]);
    }

    public function binaanClaimUmkm(Request $request, $id)
    {
        $this->ensureBinaanSchema();

        $umkm = UmkmProfile::findOrFail($id);

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Wajib memasukkan alamat email pengguna terdaftar.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email ini belum terdaftar di sistem. Mohon pemilik mendaftar akun di web terlebih dahulu.',
        ]);

        $targetUser = \App\Models\User\User::where('email', $request->email)->firstOrFail();

        $existingUmkm = UmkmProfile::where('user_id', $targetUser->id)
            ->where('id', '!=', $umkm->id)
            ->first();

        if ($existingUmkm) {
            return back()->with('error', "Pengguna '{$targetUser->name}' ({$targetUser->email}) sudah memiliki toko '{$existingUmkm->business_name}'. Satu akun pengguna hanya dapat mengelola 1 UMKM.");
        }

        $umkm->user_id = $targetUser->id;
        if (\Illuminate\Support\Facades\Schema::hasColumn('umkm_profiles', 'is_managed_by_admin')) {
            $umkm->is_managed_by_admin = false;
        }
        $umkm->save();

        $targetUser->update(['role' => 'umkm']);

        return back()->with('success', "Sukses! Kepemilikan UMKM '{$umkm->business_name}' berhasil diserahterimakan ke akun {$targetUser->name} ({$targetUser->email}). Pemilik kini dapat login dan mengelola tokonya secara mandiri!");
    }

    // ========================================================
    // MODUL MANAJEMEN USER & UMKM (ADMIN DINAS PERDAGANGAN)
    // ========================================================

    private function getWilayahWonogiri(): array
    {
        $path = public_path('wonogiri_wilayah.json');
        return file_exists($path) ? json_decode(file_get_contents($path), true) : [];
    }

    public function usersIndex(Request $request)
    {
        // Hanya ada dua pilihan: 'umkm' (default) atau 'admin'
        $currentRole = $request->input('role') === 'admin' ? 'admin' : 'umkm';

        $query = User::latest();

        if ($currentRole === 'admin') {
            $query->where('role', 'admin');
        } else {
            // Tampilkan seluruh akun pelaku UMKM terdaftar (akun ber-role umkm atau yang memiliki toko UMKM)
            $query->where(function($q) {
                $q->where('role', 'umkm')->orWhereHas('umkmProfile');
            })->where('role', '!=', 'admin')->with(['umkmProfile.products']);
        }

        // Pencarian Nama, Email, atau Toko UMKM
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search, $currentRole) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
                if ($currentRole === 'umkm') {
                    $q->orWhereHas('umkmProfile', function($u) use ($search) {
                        $u->where('business_name', 'like', "%{$search}%")
                          ->orWhere('phone', 'like', "%{$search}%")
                          ->orWhere('district', 'like', "%{$search}%")
                          ->orWhere('village', 'like', "%{$search}%");
                    });
                }
            });
        }

        $users = $query->paginate(15)->withQueryString();

        $usersCounts = DB::selectOne("
            SELECT
                (SELECT count(*) FROM users WHERE (role = 'umkm' OR id IN (SELECT user_id FROM umkm_profiles WHERE user_id IS NOT NULL)) AND role != 'admin') as total_umkm,
                (SELECT count(*) FROM users WHERE role = 'admin') as total_admin,
                (SELECT count(*) FROM products) as total_products,
                (SELECT count(*) FROM umkm_profiles WHERE status = 'verified') as total_verified_umkms
        ");
        $totalUmkmUsers = (int)($usersCounts->total_umkm ?? 0);
        $totalAdminUsers = (int)($usersCounts->total_admin ?? 0);
        $totalProductsCount = (int)($usersCounts->total_products ?? 0);
        $totalVerifiedUmkms = (int)($usersCounts->total_verified_umkms ?? 0);

        $districts = $this->getWilayahWonogiri();

        return view('admin.users.index', compact(
            'users',
            'totalUmkmUsers',
            'totalAdminUsers',
            'totalProductsCount',
            'totalVerifiedUmkms',
            'currentRole',
            'districts'
        ));
    }

    public function storeAdminUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Nama administrator wajib diisi.',
            'email.required' => 'Email administrator wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        $admin = User::create([
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index', ['role' => 'admin'])
            ->with('success', "Akun Administrator '{$admin->name}' ({$admin->email}) berhasil dibuat dengan sandi: {$request->password}");
    }

    public function createUmkmUser()
    {
        $districts = $this->getWilayahWonogiri();
        return view('admin.users.create', compact('districts'));
    }

    public function storeUmkmUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'business_name' => 'required|string|max:255',
            'phone' => 'required|string|max:25',
            'district' => 'required|string',
            'village' => 'required|string',
            'address' => 'required|string',
            'gender' => 'nullable|string',
            'nib' => 'nullable|string|max:100',
            'pirt' => 'nullable|string|max:100',
            'halal_cert' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'name.required' => 'Nama pemilik usaha wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain.',
            'password.required' => 'Kata sandi akun wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'business_name.required' => 'Nama usaha / merek UMKM wajib diisi.',
            'phone.required' => 'Nomor WhatsApp / telepon wajib diisi.',
            'district.required' => 'Kecamatan di Wonogiri wajib dipilih.',
            'village.required' => 'Desa / kelurahan wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('umkm_profiles', 'public');
        }

        DB::beginTransaction();
        try {
            // 1. Buat Akun User Pelaku UMKM
            $user = User::create([
                'name' => Str::title(trim($request->name)),
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'role' => 'umkm',
                'email_verified_at' => now(),
            ]);

            // 2. Buat Profil Toko UMKM
            $umkmData = [
                'user_id' => $user->id,
                'business_name' => Str::title(trim($request->business_name)),
                'owner_name' => Str::title(trim($request->name)),
                'gender' => $request->gender ?: null,
                'phone' => trim($request->phone),
                'province' => 'Jawa Tengah',
                'regency' => 'Kabupaten Wonogiri',
                'district' => trim($request->district),
                'village' => trim($request->village),
                'address' => trim($request->address),
                'nib' => $request->nib ? trim($request->nib) : null,
                'pirt' => $request->pirt ? trim($request->pirt) : null,
                'halal_cert' => $request->halal_cert ? trim($request->halal_cert) : null,
                'description' => $request->description ? trim($request->description) : null,
                'image_path' => $imagePath,
                'status' => 'verified',
            ];

            if (Schema::hasColumn('umkm_profiles', 'is_managed_by_admin')) {
                $umkmData['is_managed_by_admin'] = true;
            }

            $umkm = UmkmProfile::create($umkmData);

            DB::commit();

            // Jika memilih "Simpan & Lanjut Tambah Produk"
            if ($request->input('action') === 'save_and_add_product') {
                return redirect()->route('admin.users.product.create', $umkm->id)
                    ->with('success', "Akun {$user->name} ({$user->email}) dan toko {$umkm->business_name} berhasil dibuat. Silakan tambahkan produk pertama di bawah ini.");
            }

            return redirect()->route('admin.users.index')
                ->with('success', "Akun UMKM '{$umkm->business_name}' berhasil dibuat untuk {$user->name} ({$user->email}) dengan kata sandi: {$request->password}");

        } catch (\Throwable $e) {
            DB::rollBack();
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            return back()->withInput()->with('error', 'Gagal membuat akun UMKM: ' . $e->getMessage());
        }
    }

    public function createProductForUmkm($umkm_id)
    {
        $umkm = UmkmProfile::with('user')->findOrFail($umkm_id);
        $standardCategories = [
            'Makanan & Minuman',
            'Batik/Fashion',
            'Kerajinan',
            'Olahan Hasil Pertanian',
            'Produk Kreatif',
            'Lainnya',
        ];

        return view('admin.users.create_product', compact('umkm', 'standardCategories'));
    }

    public function storeProductForUmkm(Request $request, $umkm_id)
    {
        $umkm = UmkmProfile::findOrFail($umkm_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'category.required' => 'Kategori produk wajib dipilih.',
            'images.max' => 'Maksimal 5 foto produk dapat diunggah.',
            'images.*.image' => 'File foto harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'images.*.max' => 'Ukuran setiap gambar maksimal 5MB.',
            'image.image' => 'File foto harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        $allImagesPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file->isValid() && count($allImagesPaths) < 5) {
                    $path = $file->store('products', 'public');
                    $allImagesPaths[] = $path;
                }
            }
        } elseif ($request->hasFile('image')) {
            $allImagesPaths[] = $request->file('image')->store('products', 'public');
        }

        $imagePath = !empty($allImagesPaths) ? $allImagesPaths[0] : null;

        $isFeatured = $request->has('is_featured');

        $productData = [
            'umkm_profile_id' => $umkm->id,
            'name' => trim($request->name),
            'category' => trim($request->category),
            'price' => null,
            'description' => $request->description ? trim($request->description) : trim($request->name),
            'image_path' => $imagePath,
            'status' => 'verified',
        ];

        if (Schema::hasColumn('products', 'images')) {
            $productData['images'] = !empty($allImagesPaths) ? $allImagesPaths : null;
        }
        if (Schema::hasColumn('products', 'is_featured')) {
            $productData['is_featured'] = $isFeatured;
        }

        $product = Product::create($productData);

        return redirect()->route('admin.users.index')
            ->with('success', "Produk '{$product->name}' berhasil ditambahkan untuk toko '{$umkm->business_name}' dan langsung tayang di katalog publik!")
            ->with('verified_item', [
                'type' => 'product',
                'name' => $product->name,
                'umkm_name' => $umkm->business_name,
                'action' => 'verified',
                'message' => 'Produk berhasil ditambahkan dan langsung aktif di katalog produk publik.'
            ]);
    }

    public function resetPasswordUser(Request $request, $user_id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
        ]);

        $user = User::findOrFail($user_id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', "Kata sandi untuk pengguna '{$user->name}' ({$user->email}) berhasil diperbarui menjadi: {$request->password}");
    }

    public function destroyUser($user_id)
    {
        if (auth()->id() == $user_id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user = User::with(['umkmProfile.products'])->findOrFail($user_id);
        $userName = $user->name;
        $userEmail = $user->email;

        // Bersihkan foto file profil & produk jika ada
        if ($user->umkmProfile) {
            if ($user->umkmProfile->image_path && Storage::disk('public')->exists($user->umkmProfile->image_path)) {
                Storage::disk('public')->delete($user->umkmProfile->image_path);
            }
            if ($user->umkmProfile->products) {
                foreach ($user->umkmProfile->products as $prod) {
                    if ($prod->image_path && Storage::disk('public')->exists($prod->image_path)) {
                        Storage::disk('public')->delete($prod->image_path);
                    }
                    if (!empty($prod->images)) {
                        foreach ((array)$prod->images as $img) {
                            if ($img && Storage::disk('public')->exists($img)) {
                                Storage::disk('public')->delete($img);
                            }
                        }
                    }
                }
            }
        }

        $user->delete();

        return back()->with('success', "Akun '{$userName}' ({$userEmail}) beserta data tokonya berhasil dihapus.");
    }

    public function downloadExcelTemplate(Request $request)
    {
        $format = strtolower((string)$request->query('format', 'xlsx'));
        $templatePath = public_path('templates/template_import_umkm_wonogiri.xlsx');

        if ($format === 'csv') {
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="template_import_umkm_wonogiri.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];

            $callback = function() {
                $handle = fopen('php://output', 'w');
                fwrite($handle, "\xEF\xBB\xBF");

                fputcsv($handle, [
                    'nama_pemilik', 'email', 'password', 'gender', 'nama_usaha', 'no_whatsapp',
                    'kecamatan', 'desa', 'alamat', 'kategori_produk', 'nama_produk', 'deskripsi_produk',
                    'nib', 'pirt', 'halal'
                ], ';', '"', "\\");

                fputcsv($handle, [
                    'Budi Santoso', 'budi.santoso@gmail.com', 'PojokUmkm2026!', 'L', 'Keripik Singkong Barokah',
                    '081234567890', 'Wonogiri', 'Giriwono', 'Jl. Ahmad Yani No. 12', 'Makanan & Minuman',
                    'Keripik Singkong Balado 250g', 'Keripik singkong renyah dengan bumbu balado khas Wonogiri.',
                    '1234567890123', 'P-IRT 2063312010123-26', 'ID3311000123456'
                ], ';', '"', "\\");

                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);
        }

        // Default & Rekomendasi: File Excel .xlsx asli dengan layout rapi dan kolom terpisah
        if (!file_exists($templatePath) || filesize($templatePath) < 6000) {
            $this->generateXlsxTemplateFile($templatePath);
        }

        return response()->download($templatePath, 'template_import_umkm_wonogiri.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function generateXlsxTemplateFile(string $outputPath): void
    {
        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $zip = new \ZipArchive();
        if ($zip->open($outputPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return;
        }

        $sharedStrings = [];
        $stringIndexMap = [];

        $getStringIndex = function(string $str) use (&$sharedStrings, &$stringIndexMap): int {
            if (!isset($stringIndexMap[$str])) {
                $idx = count($sharedStrings);
                $sharedStrings[] = $str;
                $stringIndexMap[$str] = $idx;
            }
            return $stringIndexMap[$str];
        };

        $zip->addFromString("[Content_Types].xml", '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
  <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
  <Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>
  <Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>
</Types>');

        $zip->addFromString("_rels/.rels", '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>');

        $zip->addFromString("xl/_rels/workbook.xml.rels", '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
  <Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>
</Relationships>');

        $zip->addFromString("xl/workbook.xml", '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <workbookPr/>
  <bookViews><workbookView activeTab="0"/></bookViews>
  <sheets>
    <sheet name="Template Import UMKM" sheetId="1" r:id="rId2"/>
  </sheets>
  <calcPr calcId="125725" fullCalcOnLoad="true"/>
</workbook>');

        $zip->addFromString("xl/styles.xml", '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <fonts count="3">
    <font><sz val="11"/><color theme="1"/><name val="Calibri"/><family val="2"/></font>
    <font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/><family val="2"/></font>
    <font><sz val="11"/><color rgb="FF0F172A"/><name val="Calibri"/><family val="2"/></font>
  </fonts>
  <fills count="4">
    <fill><patternFill patternType="none"/></fill>
    <fill><patternFill patternType="gray125"/></fill>
    <fill><patternFill patternType="solid"><fgColor rgb="FF800000"/></patternFill></fill>
    <fill><patternFill patternType="solid"><fgColor rgb="FFF8FAFC"/></patternFill></fill>
  </fills>
  <borders count="2">
    <border><left/><right/><top/><bottom/></border>
    <border>
      <left style="thin"><color rgb="FFCBD5E1"/></left>
      <right style="thin"><color rgb="FFCBD5E1"/></right>
      <top style="thin"><color rgb="FFCBD5E1"/></top>
      <bottom style="thin"><color rgb="FFCBD5E1"/></bottom>
    </border>
  </borders>
  <cellStyleXfs count="1">
    <xf numFmtId="0" fontId="0" fillId="0" borderId="0"/>
  </cellStyleXfs>
  <cellXfs count="4">
    <xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>
    <xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1">
      <alignment horizontal="center" vertical="center" wrapText="1"/>
    </xf>
    <xf numFmtId="0" fontId="2" fillId="0" borderId="1" xfId="0" applyFont="1" applyBorder="1" applyAlignment="1">
      <alignment vertical="center"/>
    </xf>
    <xf numFmtId="0" fontId="2" fillId="3" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1">
      <alignment vertical="center"/>
    </xf>
  </cellXfs>
</styleSheet>');

        $headers = [
            ['col' => 'nama_pemilik', 'width' => 22],
            ['col' => 'email', 'width' => 28],
            ['col' => 'password', 'width' => 18],
            ['col' => 'gender', 'width' => 10],
            ['col' => 'nama_usaha', 'width' => 28],
            ['col' => 'no_whatsapp', 'width' => 18],
            ['col' => 'kecamatan', 'width' => 18],
            ['col' => 'desa', 'width' => 18],
            ['col' => 'alamat', 'width' => 32],
            ['col' => 'kategori_produk', 'width' => 24],
            ['col' => 'nama_produk', 'width' => 28],
            ['col' => 'deskripsi_produk', 'width' => 36],
            ['col' => 'nib', 'width' => 18],
            ['col' => 'pirt', 'width' => 24],
            ['col' => 'halal', 'width' => 20],
        ];

        $sampleRows = [
            [
                'Budi Santoso', 'budi.santoso@gmail.com', 'PojokUmkm2026!', 'L', 'Mete Wonogiri Lestari',
                '081234567801', 'Wonogiri', 'Giriwono', 'Jl. Ahmad Yani No. 12, Giriwono', 'Makanan & Minuman',
                'Kacang Mete Oven Asli Wonogiri 500g', 'Kacang mete kualitas super oven renyah tanpa minyak khas Wonogiri.',
                '1234567890101', 'P-IRT 2063312010101-26', 'ID3311000101001'
            ],
            [
                'Siti Rahayu', 'siti.rahayu@gmail.com', 'PojokUmkm2026!', 'P', 'Batik Tulis Wonogiren Dlepih',
                '089876543202', 'Tirtomoyo', 'Dlepih', 'Dusun Dlepih RT 02 RW 03', 'Batik/Fashion',
                'Selendang Batik Tulis Motif Remukan', 'Selendang batik tulis motif remukan khas Wonogiren pewarna alami.',
                '1234567890102', '', 'ID3311000101002'
            ],
            [
                'Slamet Widodo', 'slamet.widodo@gmail.com', 'PojokUmkm2026!', 'L', 'Madu Hutan Baturetno Alami',
                '085612345603', 'Baturetno', 'Belikurip', 'Jl. Raya Baturetno KM 3', 'Olahan Hasil Pertanian',
                'Madu Hutan Murni Nektar Randu 500ml', 'Madu murni segar langsung dari peternak hutan lebah Baturetno.',
                '1234567890103', 'P-IRT 2063312010103-26', 'ID3311000101003'
            ],
            [
                'Sri Wahyuni', 'sri.wahyuni@gmail.com', 'PojokUmkm2026!', 'P', 'Tiwul Instan Manis Giriwoyo',
                '087712345604', 'Giriwoyo', 'Platarejo', 'Dusun Platarejo RT 01 RW 02', 'Makanan & Minuman',
                'Tiwul Instan Rasa Pandan Gula Jawa', 'Makanan tradisional tiwul instan berbahan singkong pilihan khas Giriwoyo.',
                '1234567890104', 'P-IRT 2063312010104-26', 'ID3311000101004'
            ],
            [
                'Joko Prasetyo', 'joko.prasetyo@gmail.com', 'PojokUmkm2026!', 'L', 'Kerajinan Wayang Kulit Kepuhsari',
                '081398765405', 'Manyaran', 'Kepuhsari', 'Kampung Wayang Kepuhsari RT 03', 'Kerajinan',
                'Wayang Kulit Tokoh Pandawa 50cm', 'Wayang kulit tatah sungging halus dari kulit kerbau asli khas Manyaran.',
                '1234567890105', '', ''
            ],
            [
                'Rina Marlina', 'rina.marlina@gmail.com', 'PojokUmkm2026!', 'P', 'Geti Wijen Karang Slogohimo',
                '085798765406', 'Slogohimo', 'Sedayu', 'Jl. Sedayu - Slogohimo No. 25', 'Makanan & Minuman',
                'Geti Wijen Gula Jawa Asli 300g', 'Camilan renyah manis perpaduan wijen lokal dan gula kelapa alami.',
                '1234567890106', 'P-IRT 2063312010106-26', 'ID3311000101006'
            ],
            [
                'Agus Hartono', 'agus.hartono@gmail.com', 'PojokUmkm2026!', 'L', 'Kerupuk Rambak Sapi Selogiri',
                '081298765407', 'Selogiri', 'Kaliancar', 'Jl. Raya Selogiri - Solo KM 5', 'Makanan & Minuman',
                'Kerupuk Rambak Kulit Sapi Gurih 200g', 'Kerupuk rambak kulit sapi murni renyah gurih tanpa pengawet buatan.',
                '1234567890107', 'P-IRT 2063312010107-26', 'ID3311000101007'
            ],
            [
                'Endang Susanti', 'endang.susanti@gmail.com', 'PojokUmkm2026!', 'P', 'Emping Melinjo Super Purwantoro',
                '087898765408', 'Purwantoro', 'Bangsri', 'Dusun Bangsri RT 04 RW 01', 'Olahan Hasil Pertanian',
                'Emping Melinjo Tipis Renyah 500g', 'Emping melinjo kualitas ekspor renyah gurih tanpa rasa pahit berlebih.',
                '1234567890108', 'P-IRT 2063312010108-26', 'ID3311000101008'
            ],
            [
                'Bambang Sutrisno', 'bambang.sutrisno@gmail.com', 'PojokUmkm2026!', 'L', 'Kopi Robusta Brenggolo',
                '085298765409', 'Jatiroto', 'Brenggolo', 'Perbukitan Brenggolo RT 02', 'Olahan Hasil Pertanian',
                'Kopi Robusta Brenggolo Fine Robusta 250g', 'Kopi petik merah dari lereng pegunungan Brenggolo aroma rempah khas.',
                '1234567890109', 'P-IRT 2063312010109-26', 'ID3311000101009'
            ],
            [
                'Tri Handayani', 'tri.handayani@gmail.com', 'PojokUmkm2026!', 'P', 'Abon Sapi Wonogiri Sedap',
                '081598765410', 'Selogiri', 'Pare', 'Jl. Raya Pare No. 8, Selogiri', 'Makanan & Minuman',
                'Abon Daging Sapi Murni Spesial 250g', 'Abon daging sapi segar dengan serat lembut dan racikan bumbu rempah tradisi.',
                '1234567890110', 'P-IRT 2063312010110-26', 'ID3311000101010'
            ],
            [
                'Hendro Wibowo', 'hendro.wibowo@gmail.com', 'PojokUmkm2026!', 'L', 'Minyak Kelapa Murni Eromoko',
                '082198765411', 'Eromoko', 'Baleharjo', 'Dusun Baleharjo RT 01 RW 03', 'Produk Kreatif',
                'Virgin Coconut Oil (VCO) Cold Pressed 250ml', 'Minyak kelapa murni proses dingin kaya asam laurat untuk kesehatan.',
                '1234567890111', 'P-IRT 2063312010111-26', 'ID3311000101011'
            ],
            [
                'Dewi Anggraeni', 'dewi.anggraeni@gmail.com', 'PojokUmkm2026!', 'P', 'Sambal Pecel Mete Wonogiri',
                '081798765412', 'Wonogiri', 'Wonokarto', 'Jl. Ki Mangunsarkoro No. 19', 'Makanan & Minuman',
                'Bumbu Sambal Pecel Kacang Mede 300g', 'Bumbu pecel istimewa dengan campuran kacang mete gurih dan cabai segar.',
                '1234567890112', 'P-IRT 2063312010112-26', 'ID3311000101012'
            ],
            [
                'Danang Kusuma', 'danang.kusuma@gmail.com', 'PojokUmkm2026!', 'L', 'Anyaman Bambu Lestari Wuryantoro',
                '085898765413', 'Wuryantoro', 'Gumiwang Lor', 'Dusun Gumiwang Lor RT 02', 'Kerajinan',
                'Besek Bambu & Tas Anyaman Hantaran', 'Kerajinan anyaman bambu halus ramah lingkungan untuk wadah oleh-oleh.',
                '1234567890113', '', ''
            ],
            [
                'Nurul Hidayah', 'nurul.hidayah@gmail.com', 'PojokUmkm2026!', 'P', 'Keripik Pisang Tanduk Jatipurno',
                '082298765414', 'Jatipurno', 'Kopen', 'Jl. Raya Jatipurno KM 2', 'Makanan & Minuman',
                'Keripik Pisang Tanduk Gurih Renyah 200g', 'Olahan pisang tanduk lereng Lawu selatan renyah manis gurih alami.',
                '1234567890114', 'P-IRT 2063312010114-26', 'ID3311000101014'
            ],
            [
                'Eko Setiawan', 'eko.setiawan@gmail.com', 'PojokUmkm2026!', 'L', 'Sambal Ikan Wader Gajah Mungkur',
                '081998765415', 'Wuryantoro', 'Pulutan Kulon', 'Kawasan Waduk Gajah Mungkur RT 03', 'Makanan & Minuman',
                'Sambal Ikan Wader Krispi Kemasan Botol 150g', 'Sambal pedas gurih dengan topping ikan wader air tawar segar waduk.',
                '1234567890115', 'P-IRT 2063312010115-26', 'ID3311000101015'
            ],
            [
                'Yuliana Sari', 'yuliana.sari@gmail.com', 'PojokUmkm2026!', 'P', 'Teh Herbal Daun Kelor Pracimantoro',
                '085398765416', 'Pracimantoro', 'Gebangharjo', 'Dusun Gebangharjo RT 01', 'Olahan Hasil Pertanian',
                'Teh Celup Daun Kelor Organik 20 Kantung', 'Minuman herbal kaya antioksidan dari budidaya kelor pegunungan karst.',
                '1234567890116', 'P-IRT 2063312010116-26', 'ID3311000101016'
            ],
            [
                'Arif Rahman', 'arif.rahman@gmail.com', 'PojokUmkm2026!', 'L', 'Jahe Merah Instan Bulukerto',
                '081898765417', 'Bulukerto', 'Nadi', 'Lereng Gunung Gajah RT 02', 'Olahan Hasil Pertanian',
                'Serbuk Jahe Merah Gula Aren 250g', 'Minuman penghangat tubuh dari jahe merah segar dan gula aren murni.',
                '1234567890117', 'P-IRT 2063312010117-26', 'ID3311000101017'
            ],
            [
                'Ratna Kumala', 'ratna.kumala@gmail.com', 'PojokUmkm2026!', 'P', 'Keripik Jamur Tiram Crispy',
                '087698765418', 'Slogohimo', 'Pandan', 'Dusun Pandan RT 03 RW 01', 'Makanan & Minuman',
                'Keripik Jamur Tiram Rasa Bawang 150g', 'Jamur tiram segar dibalut tepung berbumbu gurih renyah tahan lama.',
                '1234567890118', 'P-IRT 2063312010118-26', 'ID3311000101018'
            ],
            [
                'Sugeng Riyadi', 'sugeng.riyadi@gmail.com', 'PojokUmkm2026!', 'L', 'Kerajinan Kayu Jati Paranggupito',
                '082398765419', 'Paranggupito', 'Gunturharjo', 'Kawasan Pesisir Gunturharjo RT 01', 'Kerajinan',
                'Piring & Cangkir Kayu Jati Food Grade', 'Perlengkapan makan unik bernilai seni tinggi dari limbah kayu jati solid.',
                '1234567890119', '', ''
            ],
            [
                'Mega Puspitasari', 'mega.puspitasari@gmail.com', 'PojokUmkm2026!', 'P', 'Kemeja Ecoprint Daun Jati Wonogiri',
                '085998765420', 'Ngadirojo', 'Ngadirojo Kidul', 'Jl. Raya Wonogiri - Ponorogo KM 8', 'Batik/Fashion',
                'Kemeja Pria Ecoprint Motif Daun Jati & Lanang', 'Pakaian motif ecoprint teknik kukus memanfaatkan tanin daun jati asli.',
                '1234567890120', '', 'ID3311000101020'
            ]
        ];

        $numCols = count($headers);
        $lastColLetter = '';
        $tempCol = $numCols;
        while ($tempCol > 0) {
            $rem = ($tempCol - 1) % 26;
            $lastColLetter = chr(65 + $rem) . $lastColLetter;
            $tempCol = intdiv($tempCol - 1, 26);
        }
        $totalRows = count($sampleRows) + 1;
        $dimension = "A1:{$lastColLetter}{$totalRows}";

        $colsXml = '<cols>';
        foreach ($headers as $idx => $h) {
            $cNum = $idx + 1;
            $colsXml .= '<col min="' . $cNum . '" max="' . $cNum . '" width="' . $h['width'] . '" customWidth="1"/>';
        }
        $colsXml .= '</cols>';

        $sheetDataXml = '<sheetData>';
        $sheetDataXml .= '<row r="1" ht="28" customHeight="1">';
        foreach ($headers as $idx => $h) {
            $colLetter = chr(65 + $idx);
            $sIdx = $getStringIndex($h['col']);
            $sheetDataXml .= '<c r="' . $colLetter . '1" t="s" s="1"><v>' . $sIdx . '</v></c>';
        }
        $sheetDataXml .= '</row>';

        foreach ($sampleRows as $rIdx => $rowValues) {
            $rowNum = $rIdx + 2;
            $styleId = ($rowNum % 2 == 0) ? 2 : 3;
            $sheetDataXml .= '<row r="' . $rowNum . '" ht="22" customHeight="1">';
            foreach ($rowValues as $cIdx => $val) {
                $colLetter = chr(65 + $cIdx);
                $cellRef = $colLetter . $rowNum;
                $valStr = (string)$val;
                if ($valStr !== '') {
                    $sIdx = $getStringIndex($valStr);
                    $sheetDataXml .= '<c r="' . $cellRef . '" t="s" s="' . $styleId . '"><v>' . $sIdx . '</v></c>';
                } else {
                    $sheetDataXml .= '<c r="' . $cellRef . '" s="' . $styleId . '"/>';
                }
            }
            $sheetDataXml .= '</row>';
        }
        $sheetDataXml .= '</sheetData>';

        $sheetXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <dimension ref="' . $dimension . '"/>
  <sheetViews>
    <sheetView tabSelected="1" workbookViewId="0">
      <pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/>
    </sheetView>
  </sheetViews>
  <sheetFormatPr defaultRowHeight="15"/>
  ' . $colsXml . '
  ' . $sheetDataXml . '
</worksheet>';

        $zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);

        $totalStringCount = count($sharedStrings);
        $sstXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="' . $totalStringCount . '" uniqueCount="' . $totalStringCount . '">';
        foreach ($sharedStrings as $str) {
            $sstXml .= '<si><t>' . htmlspecialchars($str, ENT_XML1, 'UTF-8') . '</t></si>';
        }
        $sstXml .= '</sst>';
        $zip->addFromString('xl/sharedStrings.xml', $sstXml);

        $zip->close();
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:5120',
        ], [
            'file.required' => 'Pilih file Excel (.xlsx) atau CSV yang akan diimpor.',
            'file.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, ['xlsx', 'csv', 'txt'])) {
            return back()->with('error', 'Format file tidak didukung. Mohon gunakan format file .xlsx atau .csv');
        }

        $rows = $this->parseUploadedSpreadsheet($file->getRealPath(), $extension);

        if (empty($rows) || count($rows) < 2) {
            return back()->with('error', 'File tidak berisi baris data atau kosong. Pastikan file memiliki baris header dan minimal 1 baris data.');
        }

        // Ambil baris pertama sebagai Header
        $rawHeaders = array_shift($rows);
        $headerMap = [];
        foreach ($rawHeaders as $idx => $headerText) {
            $clean = strtolower(trim($headerText));
            $clean = str_replace([' ', '-', '.'], '_', $clean);
            $clean = preg_replace('/[^a-z0-9_]/', '', $clean);
            $headerMap[$clean] = $idx;
        }

        $getCol = function($row, array $possibleNames) use ($headerMap) {
            foreach ($possibleNames as $name) {
                if (isset($headerMap[$name]) && isset($row[$headerMap[$name]])) {
                    $val = trim($row[$headerMap[$name]]);
                    if ($val !== '') return $val;
                }
            }
            return null;
        };

        $importedCount = 0;
        $skippedCount = 0;
        $messages = [];

        DB::beginTransaction();
        try {
            foreach ($rows as $rowIndex => $row) {
                // Lewati baris kosong
                if (empty(array_filter($row, fn($c) => trim($c) !== ''))) {
                    continue;
                }

                $namaUsaha = $getCol($row, ['nama_usaha', 'nama_toko', 'business_name', 'usaha', 'toko']);
                if (empty($namaUsaha)) {
                    $skippedCount++;
                    continue;
                }

                $namaPemilik = $getCol($row, ['nama_pemilik', 'owner_name', 'nama', 'pemilik']) ?: $namaUsaha;
                $email = $getCol($row, ['email', 'surel', 'e_mail']);
                $password = $getCol($row, ['password', 'sandi', 'kata_sandi']) ?: 'PojokUmkm2026!';
                $gender = $getCol($row, ['gender', 'jenis_kelamin', 'jk']);
                $phone = $getCol($row, ['no_whatsapp', 'whatsapp', 'phone', 'no_hp', 'telepon', 'nohp']) ?: '081234567890';
                $district = $getCol($row, ['kecamatan', 'district', 'kec']) ?: 'Wonogiri';
                $village = $getCol($row, ['desa', 'village', 'kelurahan']) ?: '';
                $address = $getCol($row, ['alamat', 'address', 'lokasi']) ?: 'Wonogiri, Jawa Tengah';
                $nib = $getCol($row, ['nib', 'nomor_induk_berusaha']);
                $pirt = $getCol($row, ['pirt', 'p_irt']);
                $halal = $getCol($row, ['halal', 'sertifikat_halal', 'halal_cert']);

                // Data Produk Opsional
                $kategoriProduk = $getCol($row, ['kategori_produk', 'kategori', 'category']) ?: 'Makanan & Minuman';
                $namaProduk = $getCol($row, ['nama_produk', 'product_name', 'produk']);
                $deskripsiProduk = $getCol($row, ['deskripsi_produk', 'deskripsi', 'description']);

                // Normalisasi Gender
                if ($gender) {
                    $genderLower = strtolower($gender);
                    if (str_starts_with($genderLower, 'l') || str_contains($genderLower, 'laki')) {
                        $gender = 'L';
                    } elseif (str_starts_with($genderLower, 'p') || str_contains($genderLower, 'perempuan') || str_contains($genderLower, 'wanita')) {
                        $gender = 'P';
                    } else {
                        $gender = null;
                    }
                }

                // Normalisasi Email
                if (empty($email)) {
                    $baseSlug = Str::slug($namaUsaha, '');
                    if (empty($baseSlug)) $baseSlug = 'umkm' . ($rowIndex + 1);
                    $email = $baseSlug . '@pojokumkm.id';
                    $suffix = 1;
                    while (User::where('email', $email)->exists()) {
                        $email = $baseSlug . $suffix . '@pojokumkm.id';
                        $suffix++;
                    }
                } else {
                    $email = strtolower(trim($email));
                    if (User::where('email', $email)->exists()) {
                        $skippedCount++;
                        $messages[] = "Baris " . ($rowIndex + 2) . ": Email '{$email}' sudah terdaftar, dilewati.";
                        continue;
                    }
                }

                // 1. Buat User
                $user = User::create([
                    'name' => $namaPemilik,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => 'umkm',
                    'email_verified_at' => now(),
                ]);

                // 2. Buat Profil UMKM
                $umkmData = [
                    'user_id' => $user->id,
                    'business_name' => $namaUsaha,
                    'owner_name' => $namaPemilik,
                    'gender' => $gender,
                    'phone' => $phone,
                    'province' => 'Jawa Tengah',
                    'regency' => 'Kabupaten Wonogiri',
                    'district' => $district,
                    'village' => $village,
                    'address' => $address,
                    'nib' => $nib,
                    'pirt' => $pirt,
                    'halal_cert' => $halal,
                    'status' => 'verified',
                ];

                if (Schema::hasColumn('umkm_profiles', 'is_managed_by_admin')) {
                    $umkmData['is_managed_by_admin'] = true;
                }

                $umkm = UmkmProfile::create($umkmData);

                // 3. Buat Produk jika ada
                if (!empty($namaProduk)) {
                    $productData = [
                        'umkm_profile_id' => $umkm->id,
                        'name' => $namaProduk,
                        'category' => $kategoriProduk,
                        'price' => null,
                        'description' => $deskripsiProduk ?: $namaProduk,
                        'status' => 'verified',
                    ];
                    if (Schema::hasColumn('products', 'is_featured')) {
                        $productData['is_featured'] = false;
                    }
                    Product::create($productData);
                }

                $importedCount++;
            }

            DB::commit();

            $successMsg = "Berhasil mengimpor {$importedCount} akun UMKM baru!";
            if ($skippedCount > 0) {
                $successMsg .= " ({$skippedCount} baris dilewati karena email sudah ada / kosong).";
            }

            return redirect()->route('admin.users.index')->with('success', $successMsg);

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses data import: ' . $e->getMessage());
        }
    }

    private function parseUploadedSpreadsheet(string $filePath, string $extension): array
    {
        $extension = strtolower($extension);
        $rows = [];

        if ($extension === 'csv' || $extension === 'txt') {
            $handle = fopen($filePath, 'r');
            if ($handle !== false) {
                $firstLine = fgets($handle);
                $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';
                rewind($handle);

                $bom = fread($handle, 3);
                if ($bom !== "\xEF\xBB\xBF") {
                    rewind($handle);
                }

                while (($data = fgetcsv($handle, 0, $delimiter, '"', "\\")) !== false) {
                    if (!empty(array_filter($data, fn($v) => trim($v) !== ''))) {
                        $rows[] = array_map('trim', $data);
                    }
                }
                fclose($handle);
            }
        } elseif ($extension === 'xlsx') {
            $zip = new \ZipArchive();
            if ($zip->open($filePath) === true) {
                $sharedStrings = [];
                $sharedStringsXml = $zip->getFromName('xl/sharedStrings.xml');
                if ($sharedStringsXml !== false) {
                    $xml = simplexml_load_string($sharedStringsXml);
                    if ($xml && isset($xml->si)) {
                        foreach ($xml->si as $si) {
                            if (isset($si->t)) {
                                $sharedStrings[] = (string)$si->t;
                            } elseif (isset($si->r)) {
                                $text = '';
                                foreach ($si->r as $r) {
                                    $text .= (string)$r->t;
                                }
                                $sharedStrings[] = $text;
                            } else {
                                $sharedStrings[] = '';
                            }
                        }
                    }
                }

                $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
                if ($sheetXml !== false) {
                    $xml = simplexml_load_string($sheetXml);
                    if ($xml && isset($xml->sheetData->row)) {
                        foreach ($xml->sheetData->row as $row) {
                            $rowData = [];
                            foreach ($row->c as $cell) {
                                $attr = $cell->attributes();
                                $cellRef = (string)$attr['r'];
                                preg_match('/^([A-Z]+)(\d+)$/i', $cellRef, $matches);
                                $colLetters = $matches[1] ?? 'A';

                                $colIdx = 0;
                                for ($i = 0; $i < strlen($colLetters); $i++) {
                                    $colIdx = $colIdx * 26 + (ord(strtoupper($colLetters[$i])) - 64);
                                }
                                $colIdx -= 1;

                                $type = (string)($attr['t'] ?? '');
                                $val = '';
                                if ($type === 's') {
                                    $ssIdx = (int)$cell->v;
                                    $val = $sharedStrings[$ssIdx] ?? '';
                                } elseif ($type === 'inlineStr' && isset($cell->is->t)) {
                                    $val = (string)$cell->is->t;
                                } else {
                                    $val = (string)($cell->v ?? '');
                                }

                                $rowData[$colIdx] = trim($val);
                            }

                            if (!empty($rowData)) {
                                $maxCol = max(array_keys($rowData));
                                $fullRow = [];
                                for ($c = 0; $c <= $maxCol; $c++) {
                                    $fullRow[$c] = $rowData[$c] ?? '';
                                }
                                if (!empty(array_filter($fullRow, fn($v) => trim($v) !== ''))) {
                                    $rows[] = $fullRow;
                                }
                            }
                        }
                    }
                }
                $zip->close();
            }
        }

        return $rows;
    }
}
