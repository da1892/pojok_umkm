<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\UmkmProfile;
use App\Models\User\Product;

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
                    'price' => $p->price > 0 ? 'Rp ' . number_format($p->price, 0, ',', '.') : 'Hubungi Toko',
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
            'allCategoriesList'
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

        $products = $query->paginate(10)->withQueryString();

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

        return view('admin.products.index', compact(
            'products', 
            'districtsWithCounts', 
            'allCategories', 
            'allKecamatanList',
            'totalAllProducts',
            'wilayahWonogiri'
        ));
    }

    public function consultations()
    {
        $consultations = \App\Models\Consultation::latest()->paginate(10);
        return view('admin.consultations.index', compact('consultations'));
    }
    
    public function replyConsultation(Request $request, $id)
    {
        $consultation = \App\Models\Consultation::findOrFail($id);
        
        $request->validate([
            'status' => 'required',
            'response' => 'nullable|string'
        ]);
        
        $consultation->update([
            'status' => $request->status,
            'response' => $request->response,
            'admin_id' => auth()->id()
        ]);
        
        return back()->with('success', 'Tiket konsultasi berhasil diperbarui.');
    }

    public function verifications()
    {
        $pendingUmkms = UmkmProfile::with('products')->where('status', 'pending')->latest()->get();
        $pendingProducts = Product::with('umkmProfile')->where('status', 'pending')->latest()->get();
        return view('admin.verifications.index', compact('pendingUmkms', 'pendingProducts'));
    }

    public function reports()
    {
        return view('admin.reports.index');
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
        $umkm->update(['status' => 'verified']);
        return back()->with('success', 'UMKM Profil berhasil diverifikasi.');
    }

    public function rejectUmkm($id)
    {
        $umkm = UmkmProfile::findOrFail($id);
        $umkm->update(['status' => 'rejected']);
        return back()->with('success', 'UMKM Profil ditolak.');
    }

    public function verifyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => 'verified']);
        return back()->with('success', 'Produk berhasil diverifikasi.');
    }

    public function rejectProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => 'rejected']);
        return back()->with('success', 'Produk ditolak.');
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

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
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
            'nib.regex' => 'Nomor Induk Berusaha (NIB) harus terdiri dari 13 digit angka standar OSS.',
            'pirt.min' => 'Nomor Sertifikasi PIRT minimal 15 karakter/digit standar BPOM/Dinkes.',
            'halal_cert.min' => 'Nomor Sertifikasi Halal minimal 10 karakter/digit standar BPJPH/MUI.',
            'postal_code.size' => 'Kode pos harus terdiri dari 5 digit angka.',
            'phone.min' => 'Nomor telepon/WhatsApp minimal 10 digit angka.',
        ]);

        $data = $request->only(
            'business_name', 'owner_name', 'phone', 'province', 'regency',
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
        // Hapus produk terkait jika perlu, tapi biasanya sudah ada onDelete cascade.
        $umkm->delete();
        
        return back()->with('success', 'Toko / UMKM berhasil dihapus.');
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
