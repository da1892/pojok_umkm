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
        $pendingUmkms = UmkmProfile::where('status', 'pending')->latest()->get();
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
        $pendingUmkms = UmkmProfile::where('status', 'pending')->latest()->get();
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
        $umkm = UmkmProfile::findOrFail($id);
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
            'price' => 'nullable|numeric',
            'description' => 'nullable|string'
        ]);

        $product->update($request->only('name', 'category', 'price', 'description'));

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
            'district' => 'required|string',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'nib' => 'nullable|string',
            'pirt' => 'nullable|string',
            'halal_cert' => 'nullable|string'
        ]);

        $umkm->update($request->only(
            'business_name', 'owner_name', 'phone', 'district', 'address',
            'description', 'nib', 'pirt', 'halal_cert'
        ));

        return redirect()->route('admin.stores')->with('success', 'Profil UMKM berhasil diperbarui.');
    }

    public function stores()
    {
        $umkms = UmkmProfile::latest()->paginate(10);
        return view('admin.stores.index', compact('umkms'));
    }

    public function destroyUmkm($id)
    {
        $umkm = UmkmProfile::findOrFail($id);
        // Hapus produk terkait jika perlu, tapi biasanya sudah ada onDelete cascade.
        $umkm->delete();
        
        return back()->with('success', 'Toko / UMKM berhasil dihapus.');
    }
}
