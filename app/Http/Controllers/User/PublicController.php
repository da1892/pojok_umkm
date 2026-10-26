<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function welcome()
    {
        // Hanya ambil berita yang aktif (is_published = true / 1)
        $latestNews = \App\Models\User\NewsInformation::where('is_published', true)
            ->latest()
            ->take(3)
            ->get();

        $featuredProducts = \App\Models\User\Product::with('umkmProfile')
            ->where('status', 'verified')
            ->latest()
            ->take(8)
            ->get();

        $totalUmkm = \App\Models\User\UmkmProfile::where('status', '!=', 'rejected')->count();
        $totalProducts = \App\Models\User\Product::where('status', 'verified')->count();
        $totalConsultations = \App\Models\User\Consultation::where('status', 'selesai')->count();

        return view('user.welcome', compact('latestNews', 'featuredProducts', 'totalUmkm', 'totalProducts', 'totalConsultations'));
    }

    public function panduan(Request $request)
    {
        return view('user.panduan');
    }

    public function informasi(Request $request)
    {
        $query = \App\Models\User\NewsInformation::where('is_published', true);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($b) use ($q) {
                $b->where('title', 'like', "%{$q}%")
                  ->orWhere('excerpt', 'like', "%{$q}%")
                  ->orWhere('content', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('category', $request->kategori);
        }

        $newsList = $query->latest()->paginate(6)->withQueryString();
        return view('user.informasi', compact('newsList'));
    }

    public function showNews($id)
    {
        $news = \App\Models\User\NewsInformation::where('is_published', true)->findOrFail($id);
        $otherNews = \App\Models\User\NewsInformation::where('is_published', true)
            ->where('id', '!=', $id)
            ->latest()
            ->take(3)
            ->get();

        return view('user.news_detail', compact('news', 'otherNews'));
    }

    public function katalog(Request $request)
    {
        $query = \App\Models\User\Product::with('umkmProfile')->where('status', 'verified');
        
        if ($request->filled('q')) {
            $search = strtolower(trim($request->q));
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereHas('umkmProfile', function($q2) use ($search) {
                      $q2->whereRaw('LOWER(business_name) LIKE ?', ['%' . $search . '%'])
                         ->orWhereRaw('LOWER(address) LIKE ?', ['%' . $search . '%']);
                  });
            });
        }
        
        if ($request->filled('kategori')) {
            $cat = strtolower(trim($request->kategori));
            if ($cat === 'makanan' || str_contains($cat, 'makan')) {
                $query->whereRaw('LOWER(category) LIKE ?', ['%makan%']);
            } elseif ($cat === 'kerajinan' || str_contains($cat, 'rajin')) {
                $query->whereRaw('LOWER(category) LIKE ?', ['%rajin%']);
            } elseif ($cat === 'batik' || str_contains($cat, 'batik') || str_contains($cat, 'fashion')) {
                $query->where(function($cq) {
                    $cq->whereRaw('LOWER(category) LIKE ?', ['%batik%'])
                       ->orWhereRaw('LOWER(category) LIKE ?', ['%fashion%']);
                });
            } elseif ($cat === 'pertanian' || str_contains($cat, 'pertan')) {
                $query->whereRaw('LOWER(category) LIKE ?', ['%pertan%']);
            } elseif ($cat === 'kreatif' || str_contains($cat, 'kreatif')) {
                $query->whereRaw('LOWER(category) LIKE ?', ['%kreatif%']);
            } else {
                $query->whereRaw('LOWER(category) LIKE ?', ['%' . $cat . '%']);
            }
        }

        if ($request->filled('kecamatan')) {
            $dist = strtolower(trim($request->kecamatan));
            $query->whereHas('umkmProfile', function($q) use ($dist) {
                $q->where(function($subQ) use ($dist) {
                    $subQ->whereRaw('LOWER(district) LIKE ?', ['%' . $dist . '%'])
                         ->orWhereRaw('LOWER(address) LIKE ?', ['%' . $dist . '%']);
                });
            });
        }
        
        $products = $query->latest()->paginate(9)->withQueryString();

        $wilayahJsonPath = public_path('wonogiri_wilayah.json');
        $kecamatanList = file_exists($wilayahJsonPath)
            ? array_keys(json_decode(file_get_contents($wilayahJsonPath), true))
            : [
                'Baturetno', 'Batuwarno', 'Bulukerto', 'Eromoko', 'Girimarto', 
                'Giritontro', 'Giriwoyo', 'Jatipurno', 'Jatiroto', 'Jatisrono', 
                'Karangtengah', 'Kismantoro', 'Manyaran', 'Ngadirojo', 'Nguntoronadi', 
                'Paranggupito', 'Pracimantoro', 'Puhpelem', 'Purwantoro', 'Selogiri', 
                'Sidoharjo', 'Slogohimo', 'Tirtomoyo', 'Wonogiri', 'Wuryantoro'
            ];
        sort($kecamatanList);
        
        return view('user.katalog', compact('products', 'kecamatanList'));
    }

    public function direktori(Request $request)
    {
        $query = \App\Models\User\UmkmProfile::with(['user', 'products' => function($q) {
            $q->where('status', 'verified');
        }])->where('status', 'verified');
        
        if ($request->filled('q')) {
            $search = strtolower(trim($request->q));
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(business_name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(owner_name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(address) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(village) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(district) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $search . '%'])
                  ->orWhereHas('products', function($pq) use ($search) {
                      $pq->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                  });
            });
        }
        
        if ($request->filled('kategori')) {
            $kategori = strtolower(trim($request->kategori));
            $query->whereHas('products', function($pq) use ($kategori) {
                $pq->where('status', 'verified');
                if ($kategori === 'makanan' || str_contains($kategori, 'makan')) {
                    $pq->whereRaw('LOWER(category) LIKE ?', ['%makan%']);
                } elseif ($kategori === 'kerajinan' || str_contains($kategori, 'rajin')) {
                    $pq->whereRaw('LOWER(category) LIKE ?', ['%rajin%']);
                } elseif ($kategori === 'batik' || str_contains($kategori, 'batik') || str_contains($kategori, 'fashion')) {
                    $pq->where(function($cq) {
                        $cq->whereRaw('LOWER(category) LIKE ?', ['%batik%'])
                           ->orWhereRaw('LOWER(category) LIKE ?', ['%fashion%']);
                    });
                } elseif ($kategori === 'pertanian' || str_contains($kategori, 'pertan')) {
                    $pq->whereRaw('LOWER(category) LIKE ?', ['%pertan%']);
                } elseif ($kategori === 'kreatif' || str_contains($kategori, 'kreatif')) {
                    $pq->whereRaw('LOWER(category) LIKE ?', ['%kreatif%']);
                } else {
                    $pq->whereRaw('LOWER(category) LIKE ?', ['%' . $kategori . '%']);
                }
            });
        }

        if ($request->filled('kecamatan')) {
            $kecamatan = strtolower(trim($request->kecamatan));
            $query->where(function($q) use ($kecamatan) {
                $q->whereRaw('LOWER(district) LIKE ?', ['%' . $kecamatan . '%'])
                  ->orWhereRaw('LOWER(address) LIKE ?', ['%' . $kecamatan . '%']);
            });
        }
        
        $umkms = $query->latest()->paginate(12)->withQueryString();
        
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

        $attachmentItems = [];
        $filesToProcess = [];

        if ($request->hasFile('attachments')) {
            $filesToProcess = $request->file('attachments');
        } elseif ($request->hasFile('attachment')) {
            $filesToProcess = [$request->file('attachment')];
        }

        foreach ($filesToProcess as $file) {
            if ($file && $file->isValid()) {
                $cleanName = time() . '_' . \Illuminate\Support\Str::random(5) . '_' . \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('consultations', $cleanName, 'public');

                $dataUri = null;
                try {
                    $mime = $file->getMimeType();
                    $base64 = base64_encode(file_get_contents($file->getRealPath()));
                    $dataUri = 'data:' . $mime . ';base64,' . $base64;
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning('Gagal encode base64 lampiran: ' . $e->getMessage());
                }

                $attachmentItems[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'data' => $dataUri,
                ];
            }
        }

        $storedAttachment = !empty($attachmentItems) ? json_encode($attachmentItems) : null;

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
            // Jika gagal kirim email, beri tahu pengguna alasannya dan arahkan ke halaman cek tiket dengan ID di URL
            return redirect()->route('konsultasi.cek', ['ticket_id' => $ticket_id])
                ->with('error', 'Konsultasi Anda tersimpan, tetapi sistem gagal mengirimkan email ke alamat Anda. (Error: ' . $e->getMessage() . ')')
                ->with('ticket_id', $ticket_id)
                ->with('auto_copy', true);
        }

        // Arahkan langsung ke halaman cek konsultasi dengan ID di URL dan trigger auto-copy
        return redirect()->route('konsultasi.cek', ['ticket_id' => $ticket_id])
            ->with('success', 'Pengajuan konsultasi Anda berhasil dikirim! ID Tiket telah otomatis disalin ke clipboard.')
            ->with('ticket_id', $ticket_id)
            ->with('auto_copy', true);
    }

    public function cekKonsultasi(Request $request, $ticket_id = null)
    {
        // Jika parameter dikirim via query string (?ticket_id=...), redirect ke format URL bersih (/konsultasi/cek/{ticket_id})
        if ($request->filled('ticket_id') && empty($ticket_id)) {
            return redirect()->route('konsultasi.cek', ['ticket_id' => trim($request->ticket_id)]);
        }

        $ticketId = $ticket_id ?: $request->query('ticket_id');
        $consultations = collect();

        if (!empty($ticketId)) {
            $consultations = \App\Models\Consultation::where('ticket_id', $ticketId)
                                ->orderBy('created_at', 'desc')
                                ->get();
            
            if ($consultations->isEmpty()) {
                return redirect()->route('konsultasi.cek')
                    ->with('error', 'Riwayat konsultasi untuk ID Tiket "' . $ticketId . '" tidak ditemukan.');
            }
        }

        return view('user.konsultasi_cek', compact('consultations', 'ticketId'));
    }
}
