<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
