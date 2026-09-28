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
}
