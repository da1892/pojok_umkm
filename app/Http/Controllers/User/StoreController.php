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


        $umkm->update([
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
        ]);

        return redirect()->route('toko.profile')->with('success', 'Profil UMKM berhasil diperbarui!');
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


        auth()->user()->umkmProfile()->create([
            'business_name' => $request->business_name,
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

        return view('user.store.product_create');
    }

    public function storeProduct(Request $request)
    {
        $umkm = auth()->user()->umkmProfile;
        if (!$umkm) {
            return redirect()->route('toko.index');
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
        ];
    }
}
