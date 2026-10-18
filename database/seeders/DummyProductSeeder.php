<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\UmkmProfile;
use App\Models\User\Product;

class DummyProductSeeder extends Seeder
{
    public function run()
    {
        // 1. Mete Wonogiri Lestari (Dewi Lestari)
        $umkm1 = UmkmProfile::where('business_name', 'Mete Wonogiri Lestari')->first();
        if ($umkm1) {
            $products1 = [
                [
                    'name' => 'Kacang Mete Panggang Original Wonogiri 500g',
                    'category' => 'Makanan & Minuman',
                    'description' => 'Kacang mete pilihan asli Wonogiri diolah dengan proses panggang oven tanpa minyak berlebih, gurih alami dan renyah.',
                    'primary' => 'products/mete_original.jpg',
                    'images' => ['products/mete_original.jpg', 'products/mete_madu.jpg', 'products/nastar_mete.jpg'],
                ],
                [
                    'name' => 'Kacang Mete Rasa Madu Wijen 250g',
                    'category' => 'Makanan & Minuman',
                    'description' => 'Olahan mete dengan baluran madu murni dan taburan biji wijen pilihan, perpaduan manis gurih khas oleh-oleh Wonogiri.',
                    'primary' => 'products/mete_madu.jpg',
                    'images' => ['products/mete_madu.jpg', 'products/mete_original.jpg'],
                ],
                [
                    'name' => 'Kacang Mete Pedas Manis Crispy 250g',
                    'category' => 'Makanan & Minuman',
                    'description' => 'Mete kualitas super dengan bumbu pedas manis rempah alami, cocok untuk camilan santai keluarga.',
                    'primary' => 'products/mete_pedas.jpg',
                    'images' => ['products/mete_pedas.jpg', 'products/sambal_mete.jpg'],
                ],
                [
                    'name' => 'Sambal Mete Khas Wonogiri Kemasan Botol',
                    'category' => 'Makanan & Minuman',
                    'description' => 'Sambal uleg istimewa dengan campuran tumbukan kacang mete sangrai yang gurih dan sedap beraroma rempah nusantara.',
                    'primary' => 'products/sambal_mete.jpg',
                    'images' => ['products/sambal_mete.jpg', 'products/mete_original.jpg'],
                ],
                [
                    'name' => 'Kue Kering Nastar Mete Premium',
                    'category' => 'Makanan & Minuman',
                    'description' => 'Kue kering mentega lembut isi selai nanas dengan cacahan kacang mete gurih di atasnya, kemasan toples elegan.',
                    'primary' => 'products/nastar_mete.jpg',
                    'images' => ['products/nastar_mete.jpg', 'products/mete_madu.jpg'],
                ],
            ];

            foreach ($products1 as $p) {
                Product::updateOrCreate(
                    ['umkm_profile_id' => $umkm1->id, 'name' => $p['name']],
                    [
                        'category' => $p['category'],
                        'description' => $p['description'],
                        'image_path' => $p['primary'],
                        'images' => $p['images'],
                        'status' => 'pending'
                    ]
                );
            }
            echo "5 Produk Mete Wonogiri Lestari berhasil diupdate dengan foto khas!\n";
        }

        // 2. Batik Tulis Tirtomoyo Indah (Bambang Prakoso)
        $umkm2 = UmkmProfile::where('business_name', 'Batik Tulis Tirtomoyo Indah')->first();
        if ($umkm2) {
            $products2 = [
                [
                    'name' => 'Kain Batik Tulis Motif Kahyangan Dlepih',
                    'category' => 'Batik/Fashion',
                    'description' => 'Kain batik tulis halus primissima dengan motif khas spiritual Kahyangan Dlepih Tirtomoyo, pewarnaan alami dedaunan.',
                    'primary' => 'products/batik_tulis.jpg',
                    'images' => ['products/batik_tulis.jpg', 'products/kemeja_batik.jpg', 'products/syal_batik.jpg'],
                ],
                [
                    'name' => 'Kemeja Pria Batik Tulis Motif Parang Wonogiren',
                    'category' => 'Batik/Fashion',
                    'description' => 'Kemeja batik lengan panjang dilapisi furing katun halus, nyaman dipakai untuk acara formal maupun dinas.',
                    'primary' => 'products/kemeja_batik.jpg',
                    'images' => ['products/kemeja_batik.jpg', 'products/batik_tulis.jpg'],
                ],
                [
                    'name' => 'Syal Sutra Batik Cap Pewarna Alami Indigo',
                    'category' => 'Batik/Fashion',
                    'description' => 'Syal berbahan sutra lembut dengan aksen motif klasik khas perbukitan Tirtomoyo, diproses menggunakan pewarna alami indigo.',
                    'primary' => 'products/syal_batik.jpg',
                    'images' => ['products/syal_batik.jpg', 'products/tas_batik.jpg'],
                ],
                [
                    'name' => 'Tas Jinjing Tenun Kombinasi Batik Kulit',
                    'category' => 'Kerajinan',
                    'description' => 'Tas wanita handmade perpaduan kain batik cap dan kulit sintetis premium berkualitas tinggi, kokoh dan modis.',
                    'primary' => 'products/tas_batik.jpg',
                    'images' => ['products/tas_batik.jpg', 'products/kipas_masker.jpg'],
                ],
                [
                    'name' => 'Masker & Kipas Lipat Batik Tulis Handmade',
                    'category' => 'Produk Kreatif',
                    'description' => 'Set aksesoris kipas lipat bambu dan masker kain berbahan katun batik tulis asli pengerjaan tangan warga Tirtomoyo.',
                    'primary' => 'products/kipas_masker.jpg',
                    'images' => ['products/kipas_masker.jpg', 'products/batik_tulis.jpg'],
                ],
            ];

            foreach ($products2 as $p) {
                Product::updateOrCreate(
                    ['umkm_profile_id' => $umkm2->id, 'name' => $p['name']],
                    [
                        'category' => $p['category'],
                        'description' => $p['description'],
                        'image_path' => $p['primary'],
                        'images' => $p['images'],
                        'status' => 'pending'
                    ]
                );
            }
            echo "5 Produk Batik Tulis Tirtomoyo Indah berhasil diupdate dengan foto khas!\n";
        }

        // 3. Keripik Berkah Selogiri (Siti Rahmawati)
        $umkm3 = UmkmProfile::where('business_name', 'Keripik Berkah Selogiri')->first();
        if ($umkm3) {
            $products3 = [
                [
                    'name' => 'Keripik Singkong Renyah Balado Selogiri 200g',
                    'category' => 'Olahan Hasil Pertanian',
                    'description' => 'Keripik singkong dari hasil tani lereng perbukitan Selogiri dengan racikan bumbu balado gurih manis pedas.',
                    'primary' => 'products/keripik_singkong.jpg',
                    'images' => ['products/keripik_singkong.jpg', 'products/keripik_pisang.jpg', 'products/emping_jagung.jpg'],
                ],
                [
                    'name' => 'Keripik Pisang Tanduk Original Gurih 250g',
                    'category' => 'Olahan Hasil Pertanian',
                    'description' => 'Dibuat dari pisang tanduk matang pohon yang diiris tipis renyah dengan rasa gurih mentega yang nagih.',
                    'primary' => 'products/keripik_pisang.jpg',
                    'images' => ['products/keripik_pisang.jpg', 'products/keripik_singkong.jpg'],
                ],
                [
                    'name' => 'Emping Jagung Manis Pedas Renyah 200g',
                    'category' => 'Makanan & Minuman',
                    'description' => 'Jagung pipil lokal Wonogiri yang dipipihkan dan digoreng garing dengan taburan bumbu manis gurih renyah.',
                    'primary' => 'products/emping_jagung.jpg',
                    'images' => ['products/emping_jagung.jpg', 'products/peyek_kacang.jpg'],
                ],
                [
                    'name' => 'Peyek Kacang Hijau Daun Jeruk 250g',
                    'category' => 'Makanan & Minuman',
                    'description' => 'Rempeyek kacang hijau beraroma wangi daun jeruk yang sangat renyah dan gurih, kemasan toples kedap udara.',
                    'primary' => 'products/peyek_kacang.jpg',
                    'images' => ['products/peyek_kacang.jpg', 'products/kerupuk_rambak.jpg'],
                ],
                [
                    'name' => 'Kerupuk Rambak Sapi Asli Wonogiri 150g',
                    'category' => 'Makanan & Minuman',
                    'description' => 'Kerupuk rambak kulit sapi renyah tanpa pengawet buatan, cocok untuk teman makan bakso atau soto khas Wonogiri.',
                    'primary' => 'products/kerupuk_rambak.jpg',
                    'images' => ['products/kerupuk_rambak.jpg', 'products/peyek_kacang.jpg'],
                ],
            ];

            foreach ($products3 as $p) {
                Product::updateOrCreate(
                    ['umkm_profile_id' => $umkm3->id, 'name' => $p['name']],
                    [
                        'category' => $p['category'],
                        'description' => $p['description'],
                        'image_path' => $p['primary'],
                        'images' => $p['images'],
                        'status' => 'pending'
                    ]
                );
            }
            echo "5 Produk Keripik Berkah Selogiri berhasil diupdate dengan foto khas!\n";
        }
    }
}
