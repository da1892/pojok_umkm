<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\UmkmProfile;
use App\Models\User\Product;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $umkm = $user->umkmProfile;

        if (!$umkm) {
            return view('user.store.register');
        }

        $products = $umkm->products()->latest()->get();
        return view('user.store.dashboard', compact('umkm', 'products'));
    }

    public function profile()
    {
        $user = auth()->user();
        $umkm = $user->umkmProfile;

        if (!$umkm) {
            return redirect()->route('toko.create');
        }

        $productsCount = $umkm->products()->count();
        return view('user.store.profile', compact('umkm', 'productsCount'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $umkm = $user->umkmProfile;

        if (!$umkm) {
            return redirect()->route('toko.create');
        }

        $request->validate($this->getUmkmValidationRules(), $this->getUmkmValidationMessages());

        $data = [
            'business_name' => $request->business_name,
            'owner_name' => $request->owner_name,
            'phone' => $request->phone,
            'province' => $request->province ?: 'Jawa Tengah',
            'regency' => $request->regency ?: 'Kabupaten Wonogiri',
            'district' => $request->district,
            'village' => $request->village,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'nib' => $request->nib,
            'pirt' => $request->pirt,
            'halal_cert' => $request->halal_cert,
            'description' => $request->description,
            'map_link' => $request->map_link,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('umkm', 'public');
        }

        $wasRejected = ($umkm->status === 'rejected');
        if ($wasRejected) {
            $data['status'] = 'pending';
        }

        $umkm->update($data);

        $successMsg = $wasRejected
            ? 'Profil UMKM berhasil diperbarui dan diajukan ulang ke Admin! Status UMKM Anda saat ini kembali Menunggu Persetujuan.'
            : 'Profil UMKM berhasil diperbarui!';

        return redirect()->route('toko.profile')->with('success', $successMsg);
    }

    public function resubmitVerification()
    {
        $user = auth()->user();
        $umkm = $user->umkmProfile;

        if (!$umkm) {
            return redirect()->route('toko.create');
        }

        if ($umkm->status === 'verified') {
            return redirect()->route('toko.index')->with('success', 'UMKM Anda sudah berstatus Disetujui.');
        }

        $umkm->update(['status' => 'pending']);

        return redirect()->route('toko.index')->with('success', 'Pengajuan verifikasi ulang UMKM berhasil dikirim! Status UMKM Anda kini kembali Menunggu Persetujuan dari Administrator.');
    }

    public function create()
    {
        if (auth()->user()->umkmProfile) {
            return redirect()->route('toko.index');
        }
        return view('user.store.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->getUmkmValidationRules(), $this->getUmkmValidationMessages());

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('umkm', 'public');
        }

        auth()->user()->umkmProfile()->create([
            'business_name' => $request->business_name,
            'image_path' => $imagePath,
            'owner_name' => $request->owner_name,
            'province' => $request->province ?: 'Jawa Tengah',
            'regency' => $request->regency ?: 'Kabupaten Wonogiri',
            'district' => $request->district,
            'village' => $request->village,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'phone' => $request->phone,
            'nib' => $request->nib,
            'pirt' => $request->pirt,
            'halal_cert' => $request->halal_cert,
            'description' => $request->description,
            'map_link' => $request->map_link,
            'status' => 'pending'
        ]);

        return redirect()->route('toko.index')->with('success', 'Pendaftaran UMKM berhasil dikirim! Menunggu verifikasi dari Admin.');
    }

    public function createProduct()
    {
        $umkm = auth()->user()->umkmProfile;
        if (!$umkm) {
            return redirect()->route('toko.index');
        }

        if ($umkm->status !== 'verified') {
            return redirect()->route('toko.index')->with('error', 'Profil UMKM Anda saat ini masih berstatus ' . ($umkm->status === 'pending' ? 'Menunggu Persetujuan' : 'Ditolak') . '. Anda belum dapat menambahkan produk baru hingga disetujui oleh admin.');
        }

        return view('user.store.product_create');
    }

    public function storeProduct(Request $request)
    {
        $umkm = auth()->user()->umkmProfile;
        if (!$umkm) {
            return redirect()->route('toko.index');
        }

        if ($umkm->status !== 'verified') {
            return redirect()->route('toko.index')->with('error', 'Profil UMKM Anda belum disetujui oleh admin.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240'
        ], [
            'images.max' => 'Maksimal 5 foto produk dapat diunggah.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'images.*.max' => 'Ukuran setiap gambar maksimal 10MB.'
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (count($imagePaths) < 5) {
                    $imagePaths[] = $file->store('products', 'public');
                }
            }
        } elseif ($request->hasFile('image')) {
            $imagePaths[] = $request->file('image')->store('products', 'public');
        }

        if (empty($imagePaths)) {
            return back()->withErrors(['images' => 'Wajib mengunggah minimal 1 foto produk.'])->withInput();
        }

        $primaryImage = $imagePaths[0];

        $umkm->products()->create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'price' => null,
            'image_path' => $primaryImage,
            'images' => $imagePaths,
            'status' => 'pending'
        ]);

        return redirect()->route('toko.index')->with('success', 'Produk berhasil ditambahkan! Menunggu verifikasi admin sebelum tampil di katalog.');
    }

    public function consultations()
    {
        $consultations = \App\Models\Consultation::where('user_id', auth()->id())->latest()->get();
        return view('user.store.consultations', compact('consultations'));
    }

    public function destroyProduct($id)
    {
        $product = \App\Models\User\Product::where('id', $id)->whereHas('umkmProfile', function($q) {
            $q->where('user_id', auth()->id());
        })->firstOrFail();
        
        $product->delete();
        
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function editProduct($id)
    {
        $product = \App\Models\User\Product::where('id', $id)->whereHas('umkmProfile', function($q) {
            $q->where('user_id', auth()->id());
        })->firstOrFail();
        
        return view('user.store.product_edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = \App\Models\User\Product::where('id', $id)->whereHas('umkmProfile', function($q) {
            $q->where('user_id', auth()->id());
        })->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
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
            'price' => null,
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

        return redirect()->route('toko.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroyStore(Request $request)
    {
        $user = auth()->user();
        $umkm = $user->umkmProfile;

        if (!$umkm) {
            return redirect()->route('toko.index');
        }

        $businessName = $umkm->business_name;

        // Bersihkan storage foto toko
        if ($umkm->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($umkm->image_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($umkm->image_path);
        }

        // Bersihkan foto produk dan produk terkait
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

        return redirect()->route('toko.index')->with('warning', "Akun UMKM '{$businessName}' beserta seluruh katalog produknya telah berhasil dihapus dari sistem Pojok UMKM.");
    }

    public function destroyAccount(Request $request)
    {
        $user = auth()->user();
        $umkm = $user->umkmProfile;

        if ($umkm) {
            if ($umkm->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($umkm->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($umkm->image_path);
            }

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
        }

        \Illuminate\Support\Facades\Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('warning', 'Akun pengguna dan seluruh data UMKM Anda telah berhasil dihapus secara permanen dari sistem Pojok UMKM Wonogiri.');
    }

    private function getUmkmValidationRules(): array
    {
        return [
            'business_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'min:10', 'max:25'],
            'province' => 'nullable|string|max:100',
            'regency' => 'nullable|string|max:100',
            'district' => 'required|string|max:100',
            'village' => 'required|string|max:100',
            'postal_code' => ['nullable', 'string', 'size:5', 'regex:/^[0-9]+$/'],
            'address' => 'required|string',
            'nib' => ['nullable', 'string', 'regex:/^[0-9]{13}$/'],
            'pirt' => ['nullable', 'string', 'min:15', 'max:35'],
            'halal_cert' => ['nullable', 'string', 'min:10', 'max:35'],
            'description' => 'nullable|string',
            'map_link' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ];
    }

    private function getUmkmValidationMessages(): array
    {
        return [
            'nib.regex' => 'Nomor Induk Berusaha (NIB) wajib berupa tepat 13 digit angka standar OSS.',
            'pirt.min' => 'Nomor Sertifikasi PIRT minimal 15 karakter/digit standar BPOM/Dinkes.',
            'halal_cert.min' => 'Nomor Sertifikasi Halal minimal 10 karakter/digit standar BPJPH/MUI.',
            'postal_code.size' => 'Kode pos harus terdiri dari 5 digit angka.',
            'postal_code.regex' => 'Kode pos hanya boleh berisi angka.',
            'phone.min' => 'Nomor telepon/WhatsApp minimal 10 digit angka.',
            'image.image' => 'File foto profil harus berupa gambar.',
            'image.mimes' => 'Format foto profil harus JPG, PNG, atau WebP.',
            'image.max' => 'Ukuran foto profil maksimal 5MB.',
        ];
    }
}

