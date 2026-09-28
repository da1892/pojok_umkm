<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KatalogController extends Controller
{
    private function getProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'Tiwul',
                'slug' => 'tiwul',
                'category' => 'Makanan',
                'seller' => 'Rasa Lestari',
                'location' => 'Kec. Ngadirojo',
                'image' => asset('img/products/tiwul.jpg'),
                'price' => 'Rp 15.000',
                'description' => 'Tiwul instan yang terbuat dari singkong pilihan asli Wonogiri. Mudah disajikan, rasanya gurih manis, cocok untuk sarapan atau camilan keluarga.',
                'phone' => '081234567890',
                'address' => 'Jl. Raya Ngadirojo No. 12, Wonogiri',
            ],
            [
                'id' => 2,
                'name' => 'Tas Rotan',
                'slug' => 'tas-rotan',
                'category' => 'Kerajinan',
                'seller' => 'Kriya Mandiri',
                'location' => 'Kec. Wuryantoro',
                'image' => asset('img/products/tas_rotan.jpg'),
                'price' => 'Rp 120.000',
                'description' => 'Tas rotan buatan tangan asli pengrajin Wonogiri. Desain modern, awet, dan ramah lingkungan.',
                'phone' => '081298765432',
                'address' => 'Desa Wisata Rotan, Wuryantoro, Wonogiri',
            ],
            [
                'id' => 3,
                'name' => 'Batik Tulis Premium',
                'slug' => 'batik-tulis-premium',
                'category' => 'Batik/Fashion',
                'seller' => 'Batik Sekar Arum',
                'location' => 'Kec. Wonogiri',
                'image' => asset('img/products/batik_tulis.jpg'),
                'price' => 'Rp 350.000',
                'description' => 'Kain batik tulis premium dengan motif khas Wonogiren. Menggunakan pewarna alami sehingga ramah lingkungan.',
                'phone' => '085611223344',
                'address' => 'Jl. Jenderal Sudirman No. 45, Wonogiri',
            ],
            [
                'id' => 4,
                'name' => 'Keripik Singkong',
                'slug' => 'keripik-singkong',
                'category' => 'Makanan',
                'seller' => 'UD Sari Rasa',
                'location' => 'Kec. Selogiri',
                'image' => asset('img/products/keripik_singkong.jpg'),
                'price' => 'Rp 20.000',
                'description' => 'Keripik singkong renyah dengan bumbu rempah pilihan. Tersedia rasa original, balado, dan pedas manis.',
                'phone' => '081344556677',
                'address' => 'Desa Sendang, Selogiri, Wonogiri',
            ],
            [
                'id' => 5,
                'name' => 'Piring Hias',
                'slug' => 'piring-hias',
                'category' => 'Kerajinan',
                'seller' => 'Logam Jaya',
                'location' => 'Kec. Purwantoro',
                'image' => asset('img/products/piring_hias.jpg'),
                'price' => 'Rp 75.000',
                'description' => 'Piring hias cantik untuk dekorasi ruangan. Dibuat dengan ukiran tangan yang detail dan rapi.',
                'phone' => '082233445566',
                'address' => 'Kawasan Sentra Kerajinan, Purwantoro, Wonogiri',
            ],
            [
                'id' => 6,
                'name' => 'Jahe Merah Instan',
                'slug' => 'jahe-merah-instan',
                'category' => 'Olahan Hasil Pertanian',
                'seller' => 'Sido Muncul Wonogiri',
                'location' => 'Kec. Bulukerto',
                'image' => asset('img/products/jahe_merah.jpg'),
                'price' => 'Rp 35.000',
                'description' => 'Serbuk jahe merah instan siap seduh. Menghangatkan badan dan menjaga daya tahan tubuh.',
                'phone' => '085712345678',
                'address' => 'Desa Agrowisata, Bulukerto, Wonogiri',
            ],
            [
                'id' => 7,
                'name' => 'Kue Cucur',
                'slug' => 'kue-cucur',
                'category' => 'Makanan',
                'seller' => 'Karya Makmur',
                'location' => 'Kec. Pracimantoro',
                'image' => asset('img/products/kue_cucur.jpg'),
                'price' => 'Rp 10.000',
                'description' => 'Kue cucur khas tradisional, manis legit dengan tekstur berserat. Enak dinikmati selagi hangat.',
                'phone' => '081234123412',
                'address' => 'Pasar Tradisional Pracimantoro, Wonogiri',
            ],
            [
                'id' => 8,
                'name' => 'Guci Keramik',
                'slug' => 'guci-keramik',
                'category' => 'Kerajinan',
                'seller' => 'Arto Moro',
                'location' => 'Kec. Baturetno',
                'image' => asset('img/products/guci_keramik.jpg'),
                'price' => 'Rp 450.000',
                'description' => 'Guci keramik besar bermotif estetik untuk hiasan sudut rumah. Kualitas terjamin dan tahan lama.',
                'phone' => '081199887766',
                'address' => 'Pusat Oleh-oleh Baturetno, Wonogiri',
            ],
            [
                'id' => 9,
                'name' => 'Kemeja Batik',
                'slug' => 'kemeja-batik',
                'category' => 'Batik/Fashion',
                'seller' => 'Griya Busana',
                'location' => 'Kec. Wonogiri',
                'image' => asset('img/products/kemeja_batik.jpg'),
                'price' => 'Rp 150.000',
                'description' => 'Kemeja batik pria dengan potongan modern fit. Cocok untuk acara formal maupun gaya kasual.',
                'phone' => '087812345678',
                'address' => 'Jl. Diponegoro No. 8, Wonogiri',
            ]
        ];
    }

    public function index(Request $request)
    {
        $products = $this->getProducts();
        
        $searchQuery = strtolower(trim($request->input('q', '')));
        $categoryFilter = strtolower(trim($request->input('kategori', '')));
        $districtFilter = strtolower(trim($request->input('kecamatan', '')));

        $filteredProducts = array_filter($products, function($item) use ($searchQuery, $categoryFilter, $districtFilter) {
            if ($searchQuery !== '') {
                $haystack = strtolower($item['name'] . ' ' . $item['seller'] . ' ' . $item['location']);
                if (strpos($haystack, $searchQuery) === false) {
                    return false;
                }
            }

            if ($categoryFilter !== '') {
                $itemCategory = strtolower($item['category']);
                if ($categoryFilter === 'makanan' && strpos($itemCategory, 'makan') === false) return false;
                if ($categoryFilter === 'kerajinan' && strpos($itemCategory, 'kerajinan') === false) return false;
                if ($categoryFilter === 'batik' && strpos($itemCategory, 'batik') === false) return false;
                if ($categoryFilter === 'pertanian' && strpos($itemCategory, 'pertanian') === false) return false;
                if ($categoryFilter === 'kreatif' && strpos($itemCategory, 'kreatif') === false) return false;
            }

            if ($districtFilter !== '') {
                $itemDistrict = strtolower($item['location']);
                if (strpos($itemDistrict, $districtFilter) === false) {
                    return false;
                }
            }

            return true;
        });

        $currentPage = (int) $request->input('page', 1);
        if ($currentPage < 1) $currentPage = 1;
        if ($currentPage > 3) $currentPage = 3;

        return view('user.katalog', [
            'filteredProducts' => $filteredProducts,
            'currentPage' => $currentPage
        ]);
    }

    public function show($slug)
    {
        $products = $this->getProducts();
        $product = collect($products)->firstWhere('slug', $slug);

        if (!$product) {
            abort(404);
        }

        return view('user.produk_detail', compact('product'));
    }
}
