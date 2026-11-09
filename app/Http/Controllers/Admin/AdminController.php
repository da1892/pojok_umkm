<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\UmkmProfile;
use App\Models\User\Product;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingUmkms = UmkmProfile::with('products')->where('status', 'pending')->latest()->get();
        $pendingProducts = Product::with('umkmProfile')->where('status', 'pending')->latest()->get();
        
        $totalUmkm = UmkmProfile::where('status', 'verified')->count();
        $totalProducts = Product::where('status', 'verified')->count();
        
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
                    'price' => $p->price > 0 ? 'Rp ' . number_format($p->price, 0, ',', '.') : 'Hubungi UMKM',
                    'image' => $p->image_path ? asset('storage/' . $p->image_path) : asset('images/no-image.png'),
                    'district' => $p->umkmProfile->district ?? '',
                    'village' => $p->umkmProfile->village ?? '',
                    'business_name' => $p->umkmProfile->business_name ?? '-',
                    'edit_url' => route('admin.product.edit', $p->id),
                ];
            });

        // Semua UMKM terdaftar beserta daerahnya
        $allUmkms = UmkmProfile::select('id', 'business_name', 'district', 'village', 'status')->get();

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
        $today = Carbon::today();
        $thisMonthStart = Carbon::now()->startOfMonth();

        $visitorSummary = [
            'today_visitors' => VisitorLog::whereDate('visited_at', $today)->distinct('session_id')->count('session_id'),
            'today_views' => VisitorLog::whereDate('visited_at', $today)->count(),
            'month_visitors' => VisitorLog::where('visited_at', '>=', $thisMonthStart)->distinct('session_id')->count('session_id'),
            'month_views' => VisitorLog::where('visited_at', '>=', $thisMonthStart)->count(),
            'total_visitors' => VisitorLog::distinct('session_id')->count('session_id'),
            'total_views' => VisitorLog::count(),
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

        // 8 Log Kunjungan Terkini
        $recentVisitors = VisitorLog::latest('visited_at')->take(8)->get();

        return view('admin.dashboard', compact(
            'pendingUmkms', 
            'pendingProducts', 
            'totalUmkm', 
            'totalProducts',
            'districtStats',
            'categoryStats',
            'allVerifiedProducts',
            'allUmkms',
            'wilayahWonogiri',
            'allCategoriesList',
            'visitorSummary',
            'visitorDailyChart',
            'visitorDeviceStats',
            'visitorBrowserStats',
            'visitorTopPages',
            'recentVisitors'
        ));
    }

    public function products(Request $request)
    {
        $query = Product::with('umkmProfile')->latest();

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

        // Peta ID UMKM ke Nama Produk Unggulan aktifnya (untuk indikator 1 UMKM 1 Unggulan)
        $featuredByUmkm = Product::where('is_featured', true)
            ->whereNotNull('umkm_profile_id')
            ->pluck('name', 'umkm_profile_id')
            ->toArray();

        // Data sentra kecamatan beserta jumlah produknya untuk tombol filter cepat
        $districtsWithCounts = UmkmProfile::select('district')
            ->selectRaw("count(products.id) as total_products")
            ->leftJoin('products', 'products.umkm_profile_id', '=', 'umkm_profiles.id')
            ->whereNotNull('district')
            ->where('district', '!=', '')
            ->groupBy('district')
            ->orderByDesc('total_products')
            ->orderBy('district')
            ->get();

        $allCategories = Product::select('category')->distinct()->whereNotNull('category')->pluck('category');

        $wilayahWonogiri = file_exists(public_path('wonogiri_wilayah.json'))
            ? json_decode(file_get_contents(public_path('wonogiri_wilayah.json')), true)
            : [];
        $allKecamatanList = !empty($wilayahWonogiri) ? array_keys($wilayahWonogiri) : [];
        sort($allKecamatanList);

        $totalAllProducts = Product::count();
        $totalFeaturedProducts = Product::where('is_featured', true)->count();

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

    public function consultations()
    {
        $consultations = \App\Models\Consultation::with('messages')
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

        // Ringkasan Tetap (Hari Ini & Bulan Ini)
        $todayViews = VisitorLog::whereDate('visited_at', Carbon::today())->count();
        $todayVisitors = VisitorLog::whereDate('visited_at', Carbon::today())->distinct('session_id')->count('session_id');
        $monthViews = VisitorLog::where('visited_at', '>=', Carbon::now()->startOfMonth())->count();
        $monthVisitors = VisitorLog::where('visited_at', '>=', Carbon::now()->startOfMonth())->distinct('session_id')->count('session_id');

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
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240'
        ], [
            'images.max' => 'Maksimal 5 foto produk dapat diunggah.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'images.*.max' => 'Ukuran setiap gambar maksimal 10MB.'
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

        if ($request->boolean('is_featured') && $product->status !== 'verified') {
            $data['status'] = 'verified';
            $data['rejection_note'] = null;
        }

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function toggleFeaturedProduct(Request $request, $id)
    {
        $product = Product::with('umkmProfile')->findOrFail($id);
        $product->is_featured = !$product->is_featured;

        // Jika dijadikan Produk Unggulan tetapi statusnya belum verified, otomatis setujui produk agar langsung tayang di Beranda
        $wasPending = false;
        $replacedProduct = null;

        if ($product->is_featured) {
            if ($product->status !== 'verified') {
                $product->status = 'verified';
                $product->rejection_note = null;
                $wasPending = true;
            }

            // ATURAN 1 UMKM = 1 PRODUK UNGGULAN:
            // Jika UMKM ini sudah memiliki produk unggulan lain yang aktif, otomatis gantikan produk unggulan lama
            if ($product->umkm_profile_id) {
                $existingFeatured = Product::where('umkm_profile_id', $product->umkm_profile_id)
                    ->where('id', '!=', $product->id)
                    ->where('is_featured', true)
                    ->get();

                foreach ($existingFeatured as $other) {
                    $other->update(['is_featured' => false]);
                    $replacedProduct = $other->name;
                }
            }
        }

        $product->save();

        if ($product->is_featured) {
            $statusText = $wasPending 
                ? 'disetujui & langsung dijadikan Produk Unggulan di Beranda' 
                : 'dijadikan Produk Unggulan dan tampil di Beranda';

            if ($replacedProduct) {
                $umkmTitle = $product->umkmProfile ? $product->umkmProfile->business_name : 'UMKM';
                $statusText .= " (menggantikan '{$replacedProduct}' dari {$umkmTitle} sesuai aturan 1 UMKM 1 Unggulan)";
            }
        } else {
            $statusText = 'dihapus dari daftar Produk Unggulan';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_featured' => (bool)$product->is_featured,
                'status' => $product->status,
                'replaced' => $replacedProduct,
                'message' => "Produk \"{$product->name}\" berhasil {$statusText}."
            ]);
        }

        return back()->with('success', "Produk \"{$product->name}\" berhasil {$statusText}.");
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
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
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
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
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
}
