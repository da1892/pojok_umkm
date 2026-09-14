# Pojok UMKM Kabupaten Wonogiri

Pojok UMKM adalah sebuah platform web inovatif yang dirancang untuk mewadahi, mempromosikan, dan membantu Usaha Mikro, Kecil, dan Menengah (UMKM) di wilayah Kabupaten Wonogiri. Aplikasi ini menyediakan direktori UMKM, katalog produk, dan layanan informasi atau konsultasi yang terintegrasi dalam satu portal resmi.

## 🚀 Fitur Utama

- **Desain UI/UX Premium & Inovatif:** Menggunakan skema warna Maroon (Merah Gelap) `#800000` dengan elemen *glassmorphism*, micro-animations, dan tampilan yang responsif untuk semua perangkat.
- **Sistem Autentikasi Kustom (Single Page Sliding Panel):** Pengalaman masuk (Login) dan daftar (Register) yang disatukan dalam satu halaman interaktif dengan animasi panel geser (*sliding panel*) yang halus tanpa memuat ulang halaman.
- **Manajemen Peran Pengguna (Role-based):** Mendukung beberapa jenis pengguna (Admin, Pemilik UMKM, dan Pengguna Umum) dengan hak akses yang berbeda.
- **Katalog Produk & Direktori UMKM:** Etalase digital yang memudahkan masyarakat menemukan produk lokal berkualitas dan mencari profil UMKM terverifikasi.
- **Pusat Informasi & Pelatihan:** Halaman yang memuat berita, regulasi, dan jadwal pelatihan untuk mendukung pengembangan UMKM.

## 🛠️ Teknologi yang Digunakan

Aplikasi ini dibangun menggunakan teknologi web modern:
- **Framework Backend:** [Laravel 12](https://laravel.com/) (PHP 8.2+)
- **Framework Frontend / CSS:** [Tailwind CSS v4](https://tailwindcss.com/)
- **Bundler:** Vite
- **Database:** SQLite (Dikonfigurasi untuk kemudahan instalasi lokal)
- **Javascript:** Vanilla JS (Digunakan untuk interaksi UI ringan seperti Sliding Panel)

## 🗄️ Struktur Database (Schema)

Proyek ini telah dilengkapi dengan migrasi database berikut:
1. **`users`**: Menyimpan data autentikasi (Nama, Email, Password, Role).
2. **`umkm_profiles`**: Menyimpan detail profil usaha (Nama Bisnis, Pemilik, NIB, PIRT, Sertifikat Halal, Alamat, Status Verifikasi). Terhubung (Relasi) dengan `users`.
3. **`products`**: Menyimpan data katalog (Nama Produk, Kategori, Harga, Gambar, Deskripsi). Terhubung dengan `umkm_profiles`.
4. **`consultations`**: Modul tiket konsultasi bisnis antara UMKM dan Admin/Pakar.
5. **`news_informations`**: Sistem publikasi artikel berita, program, dan jadwal pelatihan.

## ⚙️ Panduan Instalasi (Lokal)

Jika Anda ingin menjalankan proyek ini di komputer lokal, ikuti langkah-langkah berikut:

1. **Persiapan:** Pastikan Anda telah menginstal **PHP (Minimal versi 8.2)**, **Composer**, dan **Node.js** (npm) di komputer Anda.
2. **Kloning Proyek & Masuk ke Direktori:**
   ```bash
   cd c:\xampp\htdocs\pojokumkm
   ```
3. **Instal Dependensi PHP (Laravel):**
   ```bash
   composer install
   ```
4. **Instal Dependensi Node.js (Tailwind CSS/Vite):**
   ```bash
   npm install
   ```
5. **Konfigurasi Environment:**
   Jika file `.env` belum ada, salin dari `.env.example`.
   ```bash
   cp .env.example .env
   ```
   Pastikan variabel database diarahkan ke SQLite:
   ```env
   DB_CONNECTION=sqlite
   ```
6. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```
7. **Jalankan Migrasi Database:**
   ```bash
   php artisan migrate
   ```
   *(Pilih "yes" jika ditanya untuk membuat file `database.sqlite` yang baru)*

## 🏃‍♂️ Menjalankan Aplikasi

Anda perlu menjalankan dua perintah terminal (command prompt) secara bersamaan:

1. **Jalankan Server Backend (PHP Laravel):**
   ```bash
   php artisan serve
   ```
   *Aplikasi akan berjalan di `http://localhost:8000`*

2. **Jalankan Server Frontend (Vite & Tailwind):**
   *(Buka terminal baru di folder yang sama)*
   ```bash
   npm run dev
   ```
   *Proses ini akan mengompilasi CSS secara real-time (HMR) setiap kali ada perubahan file.*

---
*Dibuat untuk mendukung digitalisasi UMKM Kabupaten Wonogiri.*
