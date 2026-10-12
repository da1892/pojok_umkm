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
        if ($request->file('attachment') && ! $request->file('attachment')->isValid()) {
            \Illuminate\Support\Facades\Log::warning('Upload attachment error: ' . $request->file('attachment')->getError() . ' - ' . $request->file('attachment')->getErrorMessage());
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (!str_contains($value, '@')) {
                        $fail('Alamat email tidak valid. Harap sertakan simbol "@".');
                    } else {
                        $domain = explode('@', $value)[1] ?? '';
                        if (empty($domain)) {
                            $fail('Alamat email tidak lengkap. Harap masukkan nama domain (contoh: gmail.com).');
                        } elseif (!str_contains($domain, '.')) {
                            $fail('Alamat email tidak valid. Harap sertakan ekstensi domain (contoh: .com atau .co.id).');
                        }
                    }
                }
            ],
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments' => 'nullable|array|max:3',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,webp,pdf,doc,docx|max:5120',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf,doc,docx|max:5120',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'phone.required' => 'Nomor telepon atau WhatsApp wajib diisi.',
            'subject.required' => 'Topik konsultasi wajib dipilih.',
            'message.required' => 'Pesan atau detail konsultasi wajib diisi.',
            'attachments.max' => 'Maksimal 3 file lampiran yang dapat diunggah.',
            'attachments.*.mimes' => 'Format file lampiran harus berupa JPG, PNG, WEBP, PDF, atau DOC.',
            'attachments.*.max' => 'Ukuran masing-masing file lampiran tidak boleh lebih dari 5MB.',
            'attachment.mimes' => 'Format file lampiran harus berupa JPG, PNG, WEBP, PDF, atau DOC.',
            'attachment.max' => 'Ukuran file lampiran tidak boleh lebih dari 5MB.',
        ]);

        // Menggunakan UUID (Universally Unique Identifier) bawaan Laravel
        $ticket_id = (string) \Illuminate\Support\Str::uuid();

        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file && $file->isValid()) {
                    $attachmentPaths[] = $file->store('consultations', 'public');
                }
            }
        } elseif ($request->hasFile('attachment')) {
            $attachmentPaths[] = $request->file('attachment')->store('consultations', 'public');
        }

        $storedAttachment = !empty($attachmentPaths) ? json_encode($attachmentPaths) : null;

        $consultation = \App\Models\Consultation::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'ticket_id' => $ticket_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'attachment' => $storedAttachment,
            'status' => 'menunggu',
        ]);

        // Mengirimkan email konfirmasi HTML resmi berisi UUID ke pengguna
        try {
            \Illuminate\Support\Facades\Mail::to($consultation->email)
                ->send(new \App\Mail\ConsultationTicketMail($consultation));
        } catch (\Exception $e) {
            // Jika gagal kirim email, beri tahu pengguna alasannya
            return back()
                ->with('error', 'Konsultasi Anda tersimpan, tetapi sistem gagal mengirimkan email ke alamat Anda. (Error: ' . $e->getMessage() . ')')
                ->with('ticket_id', $ticket_id);
        }

        // Tampilkan UUID di layar untuk sementara agar user bisa menyalinnya
        return back()
            ->with('success', 'Pengajuan konsultasi Anda berhasil dikirim!')
            ->with('ticket_id', $ticket_id);
    }

    public function cekKonsultasi(Request $request)
    {
        $consultations = collect();
        if ($request->has('ticket_id') && $request->ticket_id != '') {
            $consultations = \App\Models\Consultation::where('ticket_id', $request->ticket_id)
                                ->orderBy('created_at', 'desc')
                                ->get();
            
            if ($consultations->isEmpty()) {
                return back()->with('error', 'Riwayat konsultasi untuk ID Tiket tersebut tidak ditemukan.');
            }
        }

        return view('user.konsultasi_cek', compact('consultations'));
    }
}
