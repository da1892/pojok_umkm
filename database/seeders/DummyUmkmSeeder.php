<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\User\UmkmProfile;
use App\Models\User\Product;
use Illuminate\Support\Facades\Hash;

class DummyUmkmSeeder extends Seeder
{
    public function run()
    {
        $accounts = [
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.umkm@wonogiri.id',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'umkm' => [
                    'business_name' => 'Mete Wonogiri Lestari',
                    'owner_name' => 'Dewi Lestari',
                    'phone' => '081226123451',
                    'province' => 'Jawa Tengah',
                    'regency' => 'Kabupaten Wonogiri',
                    'district' => 'Ngadirojo',
                    'village' => 'Kasihan',
                    'postal_code' => '57681',
                    'address' => 'Jl. Raya Ngadirojo - Jatipurno No. 45, RT 02/RW 03, Dusun Kasihan',
                    'nib' => '9120004561234',
                    'pirt' => 'P-IRT 2153312010145-26',
                    'halal_cert' => 'ID33110000456780122',
                    'description' => 'Produsen kacang mete asli Wonogiri berbagai varian rasa (original oven, madu, wijen, pedas manis) dan olahan mete khas Ngadirojo kualitas super.',
                    'image_path' => 'umkm/mete_wonogiri.jpg',
                    'status' => 'pending'
                ]
            ],
            [
                'name' => 'Bambang Prakoso',
                'email' => 'bambang.umkm@wonogiri.id',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'umkm' => [
                    'business_name' => 'Batik Tulis Tirtomoyo Indah',
                    'owner_name' => 'Bambang Prakoso',
                    'phone' => '081393234562',
                    'province' => 'Jawa Tengah',
                    'regency' => 'Kabupaten Wonogiri',
                    'district' => 'Tirtomoyo',
                    'village' => 'Dlepih',
                    'postal_code' => '57672',
                    'address' => 'Jl. Kahyangan No. 18, RT 01/RW 02, Dusun Dlepih',
                    'nib' => '9120007894561',
                    'pirt' => null,
                    'halal_cert' => null,
                    'description' => 'Kerajinan batik tulis dan cap khas Wonogiri bermotif alam perbukitan dan sejarah Kahyangan Dlepih dengan pewarnaan alami ramah lingkungan.',
                    'image_path' => 'umkm/batik_tirtomoyo.jpg',
                    'status' => 'pending'
                ]
            ],
            [
                'name' => 'Siti Rahmawati',
                'email' => 'siti.umkm@wonogiri.id',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'umkm' => [
                    'business_name' => 'Keripik Berkah Selogiri',
                    'owner_name' => 'Siti Rahmawati',
                    'phone' => '085728345673',
                    'province' => 'Jawa Tengah',
                    'regency' => 'Kabupaten Wonogiri',
                    'district' => 'Selogiri',
                    'village' => 'Kaliancar',
                    'postal_code' => '57652',
                    'address' => 'Jl. Wonogiri - Sukoharjo Km. 3, RT 03/RW 01, Dusun Kaliancar',
                    'nib' => '9120003216549',
                    'pirt' => 'P-IRT 2153312020298-25',
                    'halal_cert' => 'ID33110000789010323',
                    'description' => 'Aneka olahan keripik singkong renyah, keripik pisang tanduk, emping jagung, dan camilan tradisional khas Wonogiri tanpa bahan pengawet.',
                    'image_path' => 'umkm/keripik_berkah.jpg',
                    'status' => 'pending'
                ]
            ]
        ];

        foreach ($accounts as $acc) {
            $user = User::updateOrCreate(
                ['email' => $acc['email']],
                [
                    'name' => $acc['name'],
                    'password' => $acc['password'],
                    'role' => $acc['role']
                ]
            );

            $umkm = UmkmProfile::updateOrCreate(
                ['user_id' => $user->id],
                $acc['umkm']
            );

            echo "Akun {$user->name} ({$user->email}) & Toko {$umkm->business_name} berhasil dibuat (Status: Pending).\n";
        }
    }
}
