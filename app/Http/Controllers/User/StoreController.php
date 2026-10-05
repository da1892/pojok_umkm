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

    public function create()
    {
        if (auth()->user()->umkmProfile) {
            return redirect()->route('toko.index');
        }
        return view('user.store.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'nib' => 'nullable|string|max:255',
            'pirt' => 'nullable|string|max:255',
            'halal_cert' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        auth()->user()->umkmProfile()->create([
            'business_name' => $request->business_name,
            'owner_name' => $request->owner_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'nib' => $request->nib,
            'pirt' => $request->pirt,
            'halal_cert' => $request->halal_cert,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        return redirect()->route('toko.index')->with('success', 'Toko UMKM berhasil didaftarkan! Menunggu verifikasi dari admin.');
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
            'price' => 'nullable|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10240'
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        $umkm->products()->create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
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
            'price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:10240'
        ]);

        $data = [
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
        ];

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('toko.index')->with('success', 'Produk berhasil diperbarui!');
    }
}
