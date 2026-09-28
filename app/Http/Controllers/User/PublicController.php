<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function katalog(Request $request)
    {
        $query = \App\Models\User\Product::with('umkmProfile')->where('status', 'verified');
        
        if ($request->has('q') && $request->q != '') {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
        
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('category', $request->kategori);
        }
        
        $products = $query->latest()->paginate(9)->withQueryString();
        
        return view('user.katalog', compact('products'));
    }

    public function direktori(Request $request)
    {
        $query = \App\Models\User\UmkmProfile::with('user')->where('status', 'verified');
        
        if ($request->has('q') && $request->q != '') {
            $query->where(function($q) use ($request) {
                $q->where('business_name', 'like', '%' . $request->q . '%')
                  ->orWhere('owner_name', 'like', '%' . $request->q . '%')
                  ->orWhere('address', 'like', '%' . $request->q . '%')
                  ->orWhereHas('products', function($pq) use ($request) {
                      $pq->where('name', 'like', '%' . $request->q . '%');
                  });
            });
        }
        
        if ($request->has('kategori') && $request->kategori != '') {
            // The directory uses kategori now based on the form
            $query->whereHas('products', function($pq) use ($request) {
                $pq->where('category', $request->kategori);
            });
        }

        if ($request->has('kecamatan') && $request->kecamatan != '') {
            $query->where('district', $request->kecamatan);
        }
        
        $umkms = $query->latest()->paginate(8)->withQueryString();
        
        return view('user.direktori', compact('umkms'));
    }

    public function showProduct($id)
    {
        $product = \App\Models\User\Product::with('umkmProfile')->findOrFail($id);
        return view('user.product_detail', compact('product'));
    }

    public function showUmkm($id)
    {
        $umkm = \App\Models\User\UmkmProfile::with('products')->findOrFail($id);
        return view('user.umkm_detail', compact('umkm'));
    }

    public function konsultasi()
    {
        return view('user.konsultasi');
    }

    public function storeKonsultasi(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $ticket_id = 'UMKM-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        \App\Models\Consultation::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'ticket_id' => $ticket_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'menunggu',
        ]);

        return back()->with('success', "Konsultasi berhasil dikirim. Nomor Tiket Anda: $ticket_id. Simpan nomor ini untuk mengecek status.");
    }

    public function cekKonsultasi(Request $request)
    {
        $consultations = collect();
        if ($request->has('phone') && $request->phone != '') {
            $consultations = \App\Models\Consultation::where('phone', $request->phone)
                                ->orderBy('created_at', 'desc')
                                ->get();
            
            if ($consultations->isEmpty()) {
                return back()->with('error', 'Tidak ada riwayat konsultasi yang ditemukan untuk nomor HP tersebut.');
            }
        }

        return view('user.konsultasi_cek', compact('consultations'));
    }
}
