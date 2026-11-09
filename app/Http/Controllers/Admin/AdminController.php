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
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'all_images' => 'nullable|array|max:4',
            'all_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'umkm_profile_id.required' => 'Pilih UMKM Binaan pemilik produk ini.',
            'name.required' => 'Nama produk wajib diisi.',
            'price.required' => 'Harga produk wajib diisi.',
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

        if ($isFeatured) {
            Product::where('umkm_profile_id', $request->umkm_profile_id)
                ->where('is_featured', true)
                ->update(['is_featured' => false]);
        }

        $product = Product::create([
            'umkm_profile_id' => $request->umkm_profile_id,
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'image_path' => $imagePath,
            'all_images' => !empty($allImagesPaths) ? $allImagesPaths : null,
            'status' => 'verified',
            'is_featured' => $isFeatured,
        ]);

        return redirect()->route('admin.binaan.index')->with('success', "Produk '{$product->name}' berhasil ditambahkan ke UMKM Binaan dan langsung tayang di katalog publik.");
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
        // Default tab adalah 'umkm' agar akun administrator tidak tercampur di tabel utama
        $currentRole = $request->input('role', 'umkm');

        $query = User::with(['umkmProfile.products'])->latest();

        // Pencarian Nama, Email, atau Toko UMKM
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('umkmProfile', function($u) use ($search) {
                      $u->where('business_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('district', 'like', "%{$search}%")
                        ->orWhere('village', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Role (jika bukan 'all')
        if ($currentRole !== 'all') {
            $query->where('role', $currentRole);
        }

        $users = $query->paginate(15)->withQueryString();

        $totalUsers = User::count();
        $totalUmkmUsers = User::where('role', 'umkm')->count();
        $totalAdminUsers = User::where('role', 'admin')->count();
        $totalPublicUsers = User::where('role', 'user')->count();

        $districts = $this->getWilayahWonogiri();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'totalUmkmUsers',
            'totalAdminUsers',
            'totalPublicUsers',
            'currentRole',
            'districts'
        ));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
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
                'name' => trim($request->name),
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'role' => 'umkm',
                'email_verified_at' => now(),
            ]);

            // 2. Buat Profil Toko UMKM
            $umkmData = [
                'user_id' => $user->id,
                'business_name' => trim($request->business_name),
                'owner_name' => trim($request->name),
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
                    ->with('success', "Akun '{$user->email}' dan UMKM '{$umkm->business_name}' berhasil dibuat! Silakan tambahkan produk pertama di bawah ini.");
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
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'category.required' => 'Kategori produk wajib dipilih.',
            'image.image' => 'File foto harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 3MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $allImagesPaths = [];
        if ($imagePath) {
            $allImagesPaths[] = $imagePath;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $allImagesPaths[] = $path;
            }
        }

        $isFeatured = $request->has('is_featured');
        if ($isFeatured && Schema::hasColumn('products', 'is_featured')) {
            $featuredCount = Product::where('umkm_profile_id', $umkm->id)
                ->where('is_featured', true)
                ->count();
            if ($featuredCount >= 2) {
                $isFeatured = false;
            }
        }

        $productData = [
            'umkm_profile_id' => $umkm->id,
            'name' => trim($request->name),
            'category' => trim($request->category),
            'price' => $request->filled('price') ? (float)$request->price : 0,
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
            ->with('success', "Produk '{$product->name}' berhasil ditambahkan untuk toko '{$umkm->business_name}' dan langsung tayang di katalog publik!");
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

    public function downloadExcelTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_import_umkm_wonogiri.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() {
            $handle = fopen('php://output', 'w');
            // Tulis UTF-8 BOM agar Excel Windows langsung membaca kolom dengan sempurna
            fwrite($handle, "\xEF\xBB\xBF");

            // Header kolom
            fputcsv($handle, [
                'nama_pemilik',
                'email',
                'password',
                'gender',
                'nama_usaha',
                'no_whatsapp',
                'kecamatan',
                'desa',
                'alamat',
                'kategori_produk',
                'nama_produk',
                'harga_produk',
                'deskripsi_produk',
                'nib',
                'pirt',
                'halal',
            ], ',', '"', "\\");

            // Contoh Data 1
            fputcsv($handle, [
                'Budi Santoso',
                'budi.santoso@gmail.com',
                'PojokUmkm2026!',
                'L',
                'Keripik Singkong Barokah',
                '081234567890',
                'Wonogiri',
                'Giriwono',
                'Jl. Ahmad Yani No. 12',
                'Makanan & Minuman',
                'Keripik Singkong Balado 250g',
                '15000',
                'Keripik singkong renyah dengan bumbu balado khas Wonogiri.',
                '1234567890123',
                'P-IRT 2063312010123-26',
                'ID3311000123456',
            ], ',', '"', "\\");

            // Contoh Data 2
            fputcsv($handle, [
                'Siti Rahayu',
                'siti.batik@gmail.com',
                'PojokUmkm2026!',
                'P',
                'Batik Tulis Wonogiren',
                '089876543210',
                'Tirtomoyo',
                'Dlepih',
                'Dusun Dlepih RT 02/03',
                'Batik/Fashion',
                'Kain Batik Tulis Motif Wonogiren',
                '250000',
                'Kain batik tulis halus dengan pewarna alam khas Wonogiri.',
                '',
                '',
                '',
            ], ',', '"', "\\");

            // Contoh Data 3 (Email & password kosong, sistem otomatis membuatkannya)
            fputcsv($handle, [
                'Slamet Widodo',
                '',
                '',
                'L',
                'Madu Hutan Asli Baturetno',
                '085612345678',
                'Baturetno',
                'Belikurip',
                'Jl. Raya Baturetno KM 3',
                'Makanan & Minuman',
                'Madu Hutan Murni 500ml',
                '85000',
                'Madu murni alami tanpa bahan pengawet.',
                '',
                '',
                '',
            ], ',', '"', "\\");

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ], [
            'file.required' => 'Pilih file Excel (.xlsx) atau CSV yang akan diimpor.',
            'file.max' => 'Ukuran file maksimal 10MB.',
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
                $hargaProduk = $getCol($row, ['harga_produk', 'harga', 'price']);
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
                    $cleanPrice = 0;
                    if (!empty($hargaProduk)) {
                        $cleanPrice = (float)preg_replace('/[^0-9.]/', '', str_replace(',', '.', $hargaProduk));
                    }

                    $productData = [
                        'umkm_profile_id' => $umkm->id,
                        'name' => $namaProduk,
                        'category' => $kategoriProduk,
                        'price' => $cleanPrice,
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
