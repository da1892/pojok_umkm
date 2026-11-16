# Pojok UMKM Kabupaten Wonogiri

Portal Sistem Informasi, Direktori Usaha, dan Pendampingan UMKM Kabupaten Wonogiri.

---

## 📌 Fitur Utama

- **Katalog & Direktori UMKM:** Menampilkan profil dan produk unggulan UMKM terkurasi dari 25 kecamatan di Kabupaten Wonogiri.
- **Manajemen User Pelaku UMKM:** Fasilitas bagi admin dinas perdagangan untuk mendaftarkan akun pelaku usaha, melengkapi profil toko & legalitas (NIB, P-IRT, Sertifikasi Halal), serta langsung menambahkan produk.
- **Peta Persebaran & Pointing Produk Unggulan:** Visualisasi pemetaan titik koordinat lokasi produk unggulan pilihan di 25 kecamatan dengan marker interaktif bintang emas, filter pencarian, dan tautan rute Google Maps.
- **Layanan Konsultasi & Alur Selesai Tuntas:** Fasilitas pendampingan bisnis dengan visual stepper 3 tahap, penutupan sesi tuntas dari sisi pemohon UMKM disertai survei rating kepuasan bintang (1-5), serta tanggapan berkala dinas.
- **Dashboard Manajemen Admin:** Verifikasi data pendaftaran UMKM, kurasi produk baru, kelola berita & agenda kegiatan dinas, serta analisis statistik pengunjung.

---

## 🛠️ Teknologi yang Digunakan

- **Framework:** Laravel 11.x (PHP 8.2+)
- **Database:** PostgreSQL
- **Frontend / Styling:** Tailwind CSS & Blade Template
- **Visualisasi & Peta:** Chart.js, OpenStreetMap (Leaflet)
- **Asset Bundler:** Vite

---

## 🚀 Panduan Instalasi Lokal

```bash
# 1. Clone repositori
git clone https://github.com/da1892/pojok_umkm.git
cd pojok_umkm

# 2. Install dependensi PHP & JavaScript
composer install
npm install

# 3. Salin file environment dan generate application key
cp .env.example .env
php artisan key:generate

# 4. Hubungkan storage publik
php artisan storage:link

# 5. Jalankan migrasi database
php artisan migrate

# 6. Jalankan server lokal
npm run dev
php artisan serve
```

---

*Dikembangkan untuk kemajuan dan digitalisasi UMKM Kabupaten Wonogiri.*
