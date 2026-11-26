<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\User\Product;
use App\Models\User\UmkmProfile;

class ComprehensiveSystemTest extends TestCase
{
    protected ?User $admin = null;
    protected ?User $umkmUser = null;
    protected ?Product $sampleProduct = null;
    protected ?UmkmProfile $sampleUmkm = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::where('role', 'admin')->first();
        $this->umkmUser = User::where('role', 'umkm')->whereHas('umkmProfile')->first();
        $this->sampleProduct = Product::where('status', 'verified')->first();
        $this->sampleUmkm = UmkmProfile::where('status', 'verified')->first();
    }

    public function test_public_pages_load_successfully(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/katalog')->assertStatus(200);
        $this->get('/direktori')->assertStatus(200);
        $this->get('/informasi')->assertStatus(200);
        $this->get('/panduan')->assertStatus(200);
        $this->get('/konsultasi')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
        $this->get('/forgot-password')->assertStatus(200);
    }

    public function test_friendly_redirect_aliases(): void
    {
        $this->get('/produk')->assertRedirect(route('katalog'));
        $this->get('/direktori-umkm')->assertRedirect(route('direktori'));
        $this->get('/info-panduan')->assertRedirect(route('panduan'));
    }

    public function test_detail_pages_load_successfully(): void
    {
        if ($this->sampleProduct) {
            $this->get('/katalog/' . $this->sampleProduct->id)->assertStatus(200);
        }
        if ($this->sampleUmkm) {
            $this->get('/direktori/' . $this->sampleUmkm->id)->assertStatus(200);
        }
    }

    public function test_guest_cannot_access_protected_areas(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('login'));
        $this->get('/toko')->assertRedirect(route('login'));
    }

    public function test_umkm_cannot_access_admin_dashboard(): void
    {
        if ($this->umkmUser) {
            $this->actingAs($this->umkmUser)->get('/admin/dashboard')->assertStatus(403);
        }
    }

    public function test_admin_can_access_all_admin_features(): void
    {
        if ($this->admin) {
            $this->actingAs($this->admin)->get('/admin/dashboard')->assertStatus(200);
            $this->actingAs($this->admin)->get('/admin/users')->assertStatus(200);
            $this->actingAs($this->admin)->get('/admin/produk')->assertStatus(200);
            $this->actingAs($this->admin)->get('/admin/toko')->assertStatus(200);
            $this->actingAs($this->admin)->get('/admin/konsultasi')->assertStatus(200);
            $this->actingAs($this->admin)->get('/admin/berita')->assertStatus(200);
            $this->actingAs($this->admin)->get('/admin/users/unduh-template')->assertStatus(200);
        }
    }

    public function test_umkm_owner_can_access_store_dashboard(): void
    {
        if ($this->umkmUser) {
            $this->actingAs($this->umkmUser)->get('/toko')->assertStatus(200);
            $this->actingAs($this->umkmUser)->get('/toko/profil')->assertStatus(200);
            $this->actingAs($this->umkmUser)->get('/toko/konsultasi')->assertStatus(200);
        }
    }

    public function test_custom_404_page(): void
    {
        $this->get('/halaman-yang-pasti-tidak-ada-random-404-test')->assertStatus(404);
    }
}
