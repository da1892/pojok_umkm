<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GuideController extends Controller
{
    /**
     * Tampilkan halaman Panduan Pengguna (User Guide) Portal Pojok UMKM Wonogiri.
     * Dapat diakses secara publik tanpa login dan terintegrasi dengan layout utama portal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('user.panduan');
    }

    /**
     * Unduh Buku Panduan Pengguna Resmi dalam format PDF.
     * Berisi panduan lengkap pemakaian web, pendaftaran profil usaha, kurasi produk,
     * dan pengajuan konsultasi online untuk pelaku UMKM dan masyarakat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf(Request $request)
    {
        $logoWonogiri = '';
        $logoPath = public_path('images/logo-wonogiri.png');
        if (file_exists($logoPath)) {
            $logoWonogiri = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $pdf = Pdf::loadView('user.panduan_pdf', [
            'logoWonogiri' => $logoWonogiri,
            'generatedAt' => date('d F Y'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('Buku_Panduan_Pengguna_Pojok_UMKM_Wonogiri.pdf');
    }
}
