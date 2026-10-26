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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
