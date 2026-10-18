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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
