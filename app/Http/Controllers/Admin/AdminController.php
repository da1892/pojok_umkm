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
        
        return view('admin.dashboard', compact('pendingUmkms', 'pendingProducts', 'totalUmkm', 'totalProducts'));
    }

    public function products()
    {
        $products = Product::with('umkmProfile')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
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
            'phone' => 'required|string',
            'province' => 'nullable|string|max:100',
            'regency' => 'nullable|string|max:100',
            'district' => 'required|string',
            'village' => 'required|string',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'nib' => 'nullable|string',
            'pirt' => 'nullable|string',
            'halal_cert' => 'nullable|string',
            'status' => 'nullable|string|in:pending,verified,rejected'
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
