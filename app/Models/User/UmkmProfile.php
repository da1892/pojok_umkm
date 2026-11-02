<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'image_path',
        'owner_name',
        'gender',
        'nib',
        'pirt',
        'halal_cert',
        'address',
        'province',
        'regency',
        'district',
        'village',
        'postal_code',
        'phone',
        'description',
        'map_link',
        'status',
        'rejection_note',
    ];

    public function getFullAddressAttribute()
    {
        $parts = [];
        if (!empty($this->address)) $parts[] = $this->address;
        if (!empty($this->village)) $parts[] = 'Desa/Kel. ' . $this->village;
        if (!empty($this->district)) $parts[] = 'Kec. ' . $this->district;
        if (!empty($this->regency)) $parts[] = $this->regency;
        if (!empty($this->province)) $parts[] = 'Prov. ' . $this->province;
        if (!empty($this->postal_code)) $parts[] = $this->postal_code;
        return implode(', ', $parts);
    }

    public function getGoogleMapsEmbedUrlAttribute(): string
    {
        // 1. Jika map_link sudah berupa iframe embed atau URL embed Google Maps
        if (!empty($this->map_link)) {
            $link = trim($this->map_link);
            if (preg_match('/<iframe.*?src=["\'](.*?)["\']/i', $link, $matches)) {
                return $matches[1];
            }
            if (str_contains($link, '/maps/embed') || str_contains($link, 'output=embed')) {
                return $link;
            }
            if (preg_match('/[?&]q=([^&]+)/i', $link, $matches)) {
                return 'https://maps.google.com/maps?q=' . $matches[1] . '&t=&z=15&ie=UTF8&iwloc=&output=embed';
            }
        }

        // 2. Terbaca secara otomatis dari data alamat lengkap yang tersimpan
        $parts = [];
        if (!empty($this->address)) {
            $parts[] = trim($this->address);
        }
        if (!empty($this->village) && !str_contains(strtolower($this->address ?? ''), strtolower($this->village))) {
            $parts[] = 'Desa ' . $this->village;
        }
        if (!empty($this->district) && !str_contains(strtolower($this->address ?? ''), strtolower($this->district))) {
            $parts[] = 'Kecamatan ' . $this->district;
        }
        if (!str_contains(strtolower($this->address ?? ''), 'wonogiri')) {
            $parts[] = !empty($this->regency) ? $this->regency : 'Kabupaten Wonogiri';
        }
        if (!str_contains(strtolower($this->address ?? ''), 'jawa tengah')) {
            $parts[] = !empty($this->province) ? $this->province : 'Jawa Tengah';
        }
        if (!empty($this->postal_code) && !str_contains(strtolower($this->address ?? ''), (string)$this->postal_code)) {
            $parts[] = (string)$this->postal_code;
        }

        $query = implode(', ', $parts);
        if (empty($query)) {
            $query = 'Kabupaten Wonogiri, Jawa Tengah';
        }

        return 'https://maps.google.com/maps?q=' . urlencode($query) . '&t=&z=15&ie=UTF8&iwloc=&output=embed';
    }

    public function getGoogleMapsDirectionsUrlAttribute(): string
    {
        if (!empty($this->map_link)) {
            $link = trim($this->map_link);
            if (preg_match('/<iframe.*?src=["\'](.*?)["\']/i', $link, $matches)) {
                $link = $matches[1];
            }
            if (filter_var($link, FILTER_VALIDATE_URL)) {
                return $link;
            }
        }

        $parts = [];
        if (!empty($this->address)) {
            $parts[] = trim($this->address);
        }
        if (!empty($this->village) && !str_contains(strtolower($this->address ?? ''), strtolower($this->village))) {
            $parts[] = 'Desa ' . $this->village;
        }
        if (!empty($this->district) && !str_contains(strtolower($this->address ?? ''), strtolower($this->district))) {
            $parts[] = 'Kecamatan ' . $this->district;
        }
        if (!str_contains(strtolower($this->address ?? ''), 'wonogiri')) {
            $parts[] = 'Kabupaten Wonogiri';
        }
        if (!str_contains(strtolower($this->address ?? ''), 'jawa tengah')) {
            $parts[] = 'Jawa Tengah';
        }

        $query = implode(', ', $parts);
        if (empty($query)) {
            $query = 'Kabupaten Wonogiri, Jawa Tengah';
        }

        return 'https://www.google.com/maps/search/?api=1&query=' . urlencode($query);
    }

    public static function getDistrictCentroids(): array
    {
        return [
            'wonogiri'     => [-7.8136, 110.9254],
            'selogiri'     => [-7.7818, 110.8932],
            'ngadirojo'    => [-7.8285, 111.0022],
            'sidoharjo'    => [-7.8542, 111.0827],
            'jatisrono'    => [-7.8441, 111.1465],
            'jatipurno'    => [-7.7428, 111.1444],
            'girimarto'    => [-7.7533, 111.0667],
            'slogohimo'    => [-7.8222, 111.1963],
            'bulukerto'    => [-7.7651, 111.2389],
            'puhpelem'     => [-7.7412, 111.2917],
            'purwantoro'   => [-7.8488, 111.2662],
            'kismantoro'   => [-7.9252, 111.2415],
            'jatiroto'     => [-7.8978, 111.1425],
            'tirtomoyo'    => [-7.9234, 111.0543],
            'nguntoronadi' => [-7.8863, 110.9904],
            'batuwarno'    => [-7.9482, 110.9972],
            'karangtengah' => [-8.0163, 111.0475],
            'baturetno'    => [-7.9867, 110.9389],
            'giriwoyo'     => [-8.0433, 110.9258],
            'giritontro'   => [-8.0772, 110.8778],
            'paranggupito' => [-8.1967, 110.8464],
            'pracimantoro' => [-8.0583, 110.8167],
            'eromoko'      => [-7.9717, 110.8356],
            'wuryantoro'   => [-7.8936, 110.8658],
            'manyaran'     => [-7.8631, 110.7711],
        ];
    }

    public function getCoordinatesAttribute(): array
    {
        $centroids = self::getDistrictCentroids();

        // 1. Coba deteksi koordinat eksplisit dari map_link (jika ada)
        if (!empty($this->map_link)) {
            $link = $this->map_link;
            if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $link, $m)) {
                return ['lat' => (float)$m[1], 'lng' => (float)$m[2], 'is_exact' => true, 'source' => 'map_link'];
            }
            if (preg_match('/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/', $link, $m)) {
                return ['lat' => (float)$m[1], 'lng' => (float)$m[2], 'is_exact' => true, 'source' => 'map_link'];
            }
            if (preg_match('/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/', $link, $m)) {
                return ['lat' => (float)$m[1], 'lng' => (float)$m[2], 'is_exact' => true, 'source' => 'map_link'];
            }
        }

        // 2. Deteksi kecamatan dari field district
        $districtKey = null;
        if (!empty($this->district)) {
            $dClean = strtolower(trim($this->district));
            if (isset($centroids[$dClean])) {
                $districtKey = $dClean;
            } else {
                foreach ($centroids as $key => $coord) {
                    if (str_contains($dClean, $key)) {
                        $districtKey = $key;
                        break;
                    }
                }
            }
        }

        // 3. Fallback deteksi dari alamat atau desa jika district kosong/tidak cocok
        if (!$districtKey) {
            $combinedAddress = strtolower(($this->village ?? '') . ' ' . ($this->address ?? ''));
            foreach ($centroids as $key => $coord) {
                if (preg_match('/\b' . preg_quote($key, '/') . '\b/i', $combinedAddress)) {
                    $districtKey = $key;
                    break;
                }
            }
        }

        // 4. Fallback ke Wonogiri pusat jika masih belum terdeteksi
        if (!$districtKey) {
            $districtKey = 'wonogiri';
        }

        $base = $centroids[$districtKey];

        // 5. Berikan radial jitter halus berbasis hash id & desa agar titik tidak bertumpuk persis di satu koordinat
        $hashStr = (string)$this->id . '-' . ($this->village ?? '') . '-' . substr(md5($this->business_name ?? ''), 0, 4);
        $seed = hexdec(substr(md5($hashStr), 0, 8));
        $angle = ($seed % 360) * (M_PI / 180);
        // Radius variasi antara 0.003 (~330m) hingga 0.012 (~1.3km)
        $distance = 0.003 + (($seed % 100) / 100.0) * 0.009;

        $lat = round($base[0] + ($distance * sin($angle)), 6);
        $lng = round($base[1] + ($distance * cos($angle) * 1.05), 6);

        return [
            'lat' => $lat,
            'lng' => $lng,
            'is_exact' => false,
            'district' => ucfirst($districtKey),
            'source' => 'district_centroid'
        ];
    }

    public function toMapPayload(): array
    {
        $coords = $this->coordinates;
        $products = $this->relationLoaded('products') ? $this->products : $this->products()->where('status', 'verified')->get();
        $productSamples = $products->take(3)->pluck('name')->values()->all();
        $firstProduct = $products->first();
        $primaryCategory = $firstProduct ? $firstProduct->category : 'UMKM & Industri Kreatif';

        return [
            'id' => $this->id,
            'name' => $this->business_name,
            'owner' => $this->owner_name ?? 'Pelaku UMKM',
            'district' => $this->district ?: ($coords['district'] ?? 'Wonogiri'),
            'village' => $this->village ?? '',
            'address' => $this->full_address,
            'phone' => $this->phone ?? '',
            'category' => $primaryCategory,
            'image' => $this->image_path ? asset('storage/' . $this->image_path) : ($firstProduct && $firstProduct->image_path ? asset('storage/' . $firstProduct->image_path) : asset('img/hero_wonogiri_3.jpg')),
            'status' => $this->status,
            'products_count' => $products->count(),
            'product_samples' => $productSamples,
            'detail_url' => route('direktori.show', $this->id),
            'directions_url' => $this->google_maps_directions_url,
            'whatsapp_url' => !empty($this->phone) ? 'https://wa.me/' . preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $this->phone)) : null,
            'lat' => $coords['lat'],
            'lng' => $coords['lng'],
            'is_exact' => $coords['is_exact'] ?? false,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
