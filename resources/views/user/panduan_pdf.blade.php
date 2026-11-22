<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Panduan Penggunaan Portal Pojok UMKM Wonogiri</title>
    <style>
        @page {
            margin: 18mm 16mm 18mm 16mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10.5pt;
            line-height: 1.6;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        .page-break {
            page-break-before: always;
        }
        .avoid-break {
            page-break-inside: avoid;
        }

        /* KOP SURAT RESMI KEDINASAN */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
            padding-bottom: 8px;
            border-bottom: 3px solid #800000;
        }
        .kop-table td {
            vertical-align: middle;
        }
        .kop-logo {
            width: 65px;
            text-align: center;
        }
        .kop-logo img {
            width: 58px;
            height: auto;
        }
        .kop-text {
            text-align: center;
            padding-left: 10px;
            padding-right: 25px;
        }
        .kop-text h2 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kop-text h3 {
            margin: 2px 0 0 0;
            font-size: 10.5pt;
            font-weight: bold;
            color: #800000;
            text-transform: uppercase;
        }
        .kop-text p {
            margin: 3px 0 0 0;
            font-size: 8pt;
            color: #475569;
            line-height: 1.3;
        }

        /* KOTAK JUDUL DOKUMEN */
        .doc-title-box {
            background-color: #800000;
            color: #ffffff;
            padding: 12px 14px;
            border-radius: 6px;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 12px;
        }
        .doc-title-box h1 {
            margin: 0;
            font-size: 13.5pt;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .doc-title-box p {
            margin: 4px 0 0 0;
            font-size: 9pt;
            color: #fef08a;
            font-weight: normal;
        }

        /* INFORMASI DOKUMEN */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-bottom: 14px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
        }
        .meta-table td {
            padding: 6px 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .meta-label {
            font-weight: bold;
            color: #475569;
            width: 25%;
        }
        .meta-val {
            color: #0f172a;
        }

        /* JUDUL BAB & BAGIAN */
        h2.chapter-title {
            font-size: 12pt;
            color: #800000;
            border-bottom: 1.5px solid #800000;
            padding-bottom: 4px;
            margin-top: 14px;
            margin-bottom: 8px;
            text-transform: uppercase;
            font-weight: bold;
        }
        h3.section-title {
            font-size: 10.5pt;
            color: #0f172a;
            margin-top: 10px;
            margin-bottom: 4px;
            font-weight: bold;
        }

        /* KOTAK PANDUAN LANGKAH-LANGKAH (MUDAH DIBACA) */
        .step-box {
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            padding: 8px 12px;
            margin-bottom: 8px;
        }
        .step-header {
            font-size: 10pt;
            font-weight: bold;
            color: #800000;
            margin-bottom: 3px;
        }
        .step-desc {
            font-size: 9.5pt;
            color: #334155;
            margin: 0;
            line-height: 1.5;
        }

        /* KOTAK PENTING / TIPS */
        .tip-box {
            background-color: #fffbeb;
            border: 1.5px solid #f59e0b;
            border-left: 5px solid #d97706;
            padding: 8px 12px;
            border-radius: 4px;
            margin: 8px 0;
            font-size: 9pt;
            line-height: 1.5;
            color: #78350f;
        }
        .tip-box strong {
            color: #92400e;
        }

        /* BADGES / INDIKATOR */
        .sym-ok {
            font-family: 'DejaVu Sans', sans-serif;
            color: #15803d;
            font-weight: bold;
        }
        .sym-no {
            font-family: 'DejaVu Sans', sans-serif;
            color: #b91c1c;
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 2px 7px;
            font-size: 8pt;
            font-weight: bold;
            border-radius: 3px;
        }
        .badge-green {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }
        .badge-red {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* TABEL PERBANDINGAN */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin: 8px 0 10px 0;
        }
        .content-table th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: bold;
            text-align: left;
            padding: 6px 8px;
            border: 1px solid #cbd5e1;
        }
        .content-table td {
            padding: 6px 8px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
            line-height: 1.45;
        }
        .content-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }

        /* FOOTER */
        .footer-note {
            text-align: center;
            font-size: 8pt;
            color: #64748b;
            border-top: 1px solid #cbd5e1;
            padding-top: 6px;
            margin-top: 16px;
        }
    </style>
</head>
<body>

    <!-- KOP RESMI PEMKAB WONOGIRI -->
    <table class="kop-table">
        <tr>
            @if(!empty($logoWonogiri))
            <td class="kop-logo">
                <img src="{{ $logoWonogiri }}" alt="Logo Wonogiri">
            </td>
            @endif
            <td class="kop-text">
                <h2>Pemerintah Kabupaten Wonogiri</h2>
                <h3>Dinas Koperasi, Usaha Kecil Menengah, Perindustrian dan Perdagangan</h3>
                <p>Jl. Pemuda No. 1, Giriwono, Kabupaten Wonogiri, Jawa Tengah (Kode Pos: 57613)<br>
                Layanan Digital Resmi: <strong>pojokumkm.wonogirikab.go.id</strong></p>
            </td>
        </tr>
    </table>

    <!-- JUDUL DOKUMEN -->
    <div class="doc-title-box">
        <h1>PANDUAN PRAKTIS PENGGUNAAN WEBSITE POJOK UMKM</h1>
        <p>Petunjuk Tata Cara Pemakaian Website &amp; Panduan Pengisian Formulir bagi Pelaku Usaha (UMKM)</p>
    </div>

    <!-- META DATA -->
    <table class="meta-table">
        <tr>
            <td class="meta-label">Nama Website</td>
            <td class="meta-val">Portal Pojok UMKM Kabupaten Wonogiri</td>
            <td class="meta-label">Tanggal Panduan</td>
            <td class="meta-val">{{ $generatedAt ?? date('d F Y') }}</td>
        </tr>
        <tr>
            <td class="meta-label">Sasaran Pembaca</td>
            <td class="meta-val">Pelaku Usaha Mikro Kecil Menengah (UMKM) dan Warga Masyarakat Wonogiri</td>
            <td class="meta-label">Sifat Dokumen</td>
            <td class="meta-val">Buku Petunjuk Operasional (Terbuka untuk Umum)</td>
        </tr>
    </table>

    <!-- ============================================================== -->
    <!-- BAGIAN 1: MENGENAL WEBSITE                                     -->
    <!-- ============================================================== -->
    <h2 class="chapter-title">Bagian 1: Mengenal Website Pojok UMKM Wonogiri</h2>
    <p style="font-size: 9.5pt; text-align: justify; margin: 4px 0;">
        Website <strong>Pojok UMKM Wonogiri</strong> adalah layanan internet resmi dari Pemerintah Kabupaten Wonogiri. Website ini dibuat untuk membantu Bapak dan Ibu pelaku usaha agar produk jualannya bisa dikenal oleh masyarakat luas, mudah dicari di peta wilayah Wonogiri, dan mendapatkan bantuan perizinan usaha dari dinas secara gratis.
    </p>

    <div class="tip-box">
        <strong>Keuntungan bagi Bapak / Ibu Pelaku Usaha:</strong><br>
        1. <strong>Toko dan Produk Tampil di Peta Wonogiri:</strong> Pembeli dapat melihat lokasi toko Anda di 25 kecamatan.<br>
        2. <strong>Terhubung Langsung ke WhatsApp:</strong> Pembeli yang tertarik dapat langsung mengklik tombol WhatsApp untuk memesan produk ke nomor HP Anda.<br>
        3. <strong>Bantuan Konsultasi Gratis:</strong> Anda bisa meminta pendampingan izin NIB, P-IRT, Sertifikat Halal, dan kemasan langsung ke petugas dinas.
    </div>

    <!-- ============================================================== -->
    <!-- BAGIAN 2: CARA MELIHAT PRODUK & PETA                           -->
    <!-- ============================================================== -->
    <h2 class="chapter-title">Bagian 2: Cara Melihat Peta &amp; Produk (Bagi Warga / Pembeli)</h2>

    <div class="step-box">
        <div class="step-header">Langkah 1: Melihat Peta Sebaran Toko UMKM di Halaman Depan</div>
        <p class="step-desc">
            Buka halaman utama website. Geser layar ke bawah hingga menemukan <strong>Peta Kabupaten Wonogiri</strong>. Titik-titik merah di peta menunjukkan lokasi toko UMKM. Anda bisa mengklik salah satu titik merah untuk melihat nama toko, foto produk unggulan, dan rute jalan menuju toko.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header">Langkah 2: Mencari Produk pada Menu 'Produk' / Katalog</div>
        <p class="step-desc">
            Klik menu <strong>Produk</strong> di bagian atas layar. Anda bisa memilih kategori yang diinginkan (misalnya: Makanan &amp; Minuman, Batik/Pakaian, atau Kerajinan), atau memilih nama kecamatan asal produk.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header">Langkah 3: Memesan Produk Melalui WhatsApp</div>
        <p class="step-desc">
            Klik pada foto produk yang diminati. Pada halaman detail produk, klik tombol hijau <strong>"Hubungi Penjual via WhatsApp"</strong>. Anda akan langsung diarahkan ke chat WhatsApp dengan pemilik usaha untuk menanyakan stok atau memesan.
        </p>
    </div>

    <!-- PAGE BREAK -->
    <div class="page-break"></div>

    <!-- ============================================================== -->
    <!-- BAGIAN 3: CARA DAFTAR USAHA BARU                               -->
    <!-- ============================================================== -->
    <h2 class="chapter-title">Bagian 3: Panduan Mendaftarkan Usaha Baru (Bagi Pelaku UMKM)</h2>
    <p style="font-size: 9.5pt; margin: 4px 0;">
        Bagi Bapak/Ibu yang memiliki usaha di wilayah Kabupaten Wonogiri dan ingin tokonya tampil di website, silakan ikuti petunjuk pengisian berikut:
    </p>

    <table class="content-table">
        <thead>
            <tr>
                <th style="width: 28%;">Nama Kolom Formulir</th>
                <th style="width: 42%;">Petunjuk Cara Mengisi yang Benar</th>
                <th style="width: 30%;">Contoh Pengisian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>1. Nama Pemilik Usaha</strong></td>
                <td>Tuliskan nama lengkap Bapak/Ibu sesuai KTP. Hindari menggunakan nama panggilan yang tidak resmi.</td>
                <td>
                    <span class="badge badge-green">[Benar] Sukardi Santoso</span><br>
                    <span class="badge badge-red">[Hindari] Pak Kardi Mete</span>
                </td>
            </tr>
            <tr>
                <td><strong>2. Alamat Email &amp; Kata Sandi</strong></td>
                <td>Gunakan alamat email yang aktif. Buat kata sandi (password) <strong>minimal 8 karakter</strong> (kombinasi huruf dan angka) yang mudah diingat untuk masuk ke akun Anda nantinya.</td>
                <td>
                    <span class="badge badge-green">[Benar] sukardi77@gmail.com</span><br>
                    <span class="badge badge-green">[Benar] Sandi: wonogiri123</span>
                </td>
            </tr>
            <tr>
                <td><strong>3. Nama Usaha / Merek</strong></td>
                <td>Tuliskan nama merek atau nama toko Bapak/Ibu. Jangan mencantumkan kata berlebihan seperti "Murah Banget".</td>
                <td>
                    <span class="badge badge-green">[Benar] Mete Barokah Wonogiri</span><br>
                    <span class="badge badge-red">[Hindari] METE SUPER MURAH BANGET</span>
                </td>
            </tr>
            <tr>
                <td><strong>4. Nomor WhatsApp Usaha</strong></td>
                <td>Masukkan nomor HP yang aktif dan bisa menerima chat WhatsApp, agar pembeli bisa langsung menghubungi Bapak/Ibu.</td>
                <td>
                    <span class="badge badge-green">[Benar] 081234567890</span><br>
                    <span class="badge badge-red">[Hindari] Nomor telepon rumah mati</span>
                </td>
            </tr>
            <tr>
                <td><strong>5. Kecamatan dan Desa</strong></td>
                <td>Pilih kecamatan tempat tinggal / lokasi produksi di Kabupaten Wonogiri (tersedia 25 pilihan kecamatan), lalu ketikkan nama desa/kelurahan.</td>
                <td>
                    <span class="badge badge-green">[Benar] Kec. Ngadirojo</span><br>
                    <span class="badge badge-green">[Benar] Ds. Kasihan</span>
                </td>
            </tr>
            <tr>
                <td><strong>6. Alamat Lengkap</strong></td>
                <td>Tuliskan alamat jalan, RT, RW, dan patokan rumah atau tempat usaha agar mudah ditemukan petugas maupun pembeli.</td>
                <td>
                    <span class="badge badge-green">[Benar] RT 02 / RW 04, Depan Balai Desa Kasihan</span>
                </td>
            </tr>
            <tr>
                <td><strong>7. Surat Izin Usaha (Jika Ada)</strong></td>
                <td>
                    Jika sudah punya izin, masukkan nomornya:<br>
                    &bull; NIB: 13 digit angka dari OSS.<br>
                    &bull; P-IRT: 15 digit angka dari Dinas Kesehatan.<br>
                    &bull; Sertifikat Halal: ID resmi dari BPJPH.<br>
                    <em>(Jika belum punya, boleh dikosongkan dahulu).</em>
                </td>
                <td>
                    <span class="badge badge-green">[Benar] NIB: 1209230045671</span><br>
                    <span class="badge badge-green">[Benar] Halal: ID3311000123456</span>
                </td>
            </tr>
            <tr>
                <td><strong>8. Foto Tempat Usaha / Toko</strong></td>
                <td>
                    Foto bagian depan toko, plang usaha, atau tempat produksi Bapak/Ibu.<br>
                    <strong>Ketentuan Ukuran:</strong> Foto kamera HP biasa berformat JPG atau PNG dengan ukuran <strong>Maksimal 5MB</strong>.
                </td>
                <td>
                    <span class="badge badge-green">[Benar] Foto terang tampak depan</span><br>
                    <span class="badge badge-red">[Hindari] Foto buram/gelap</span>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="tip-box">
        <strong>Pemberitahuan:</strong> Setelah formulir pendaftaran dikirimkan, petugas admin Dinas KUKM dan Perindag akan memeriksa data Bapak/Ibu. Jika data sudah sesuai, toko Bapak/Ibu akan langsung disetujui dan aktif di website.
    </div>

    <!-- PAGE BREAK -->
    <div class="page-break"></div>

    <!-- ============================================================== -->
    <!-- BAGIAN 4: CARA MEMASUKKAN PRODUK                               -->
    <!-- ============================================================== -->
    <h2 class="chapter-title">Bagian 4: Panduan Menambahkan Produk Jualan</h2>
    <p style="font-size: 9.5pt; margin: 4px 0;">
        Setelah akun disetujui, Bapak/Ibu dapat masuk ke akun toko dan menambahkan produk makanan, pakaian, kerajinan, atau produk olahan lainnya:
    </p>

    <div class="step-box">
        <div class="step-header">Langkah 1: Masuk ke Menu 'Kelola Produk'</div>
        <p class="step-desc">
            Klik tombol <strong>Masuk / Login</strong> di pojok kanan atas, masukkan email dan kata sandi Bapak/Ibu, lalu pilih menu <strong>Kelola Produk</strong> &gt; tekan tombol <strong>Tambah Produk Baru</strong>.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header">Langkah 2: Menuliskan Nama Produk yang Jelas dan Lengkap</div>
        <p class="step-desc">
            Tuliskan jenis produk + rasa/tipe + berat kemasan. Contoh yang baik: <em>"Kacang Mete Goreng Asin Gurih 250gr"</em> atau <em>"Kemeja Batik Tulis Motif Kahyangan Dlepih"</em>. Jangan hanya menuliskan "Mete Enak" karena pembeli butuh tahu varian dan ukurannya.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header">Langkah 3: Memilih Kategori Produk</div>
        <p class="step-desc">
            Pilihlah kategori yang sesuai dengan barang yang dijual, misalnya: <strong>Makanan &amp; Minuman</strong>, <strong>Batik / Fashion</strong>, <strong>Kerajinan Tangan</strong>, atau <strong>Pertanian</strong>.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header">Langkah 4: Menjelaskan Keterangan Produk (Deskripsi)</div>
        <p class="step-desc">
            Ceritakan produk Bapak/Ibu dengan 4 hal sederhana:<br>
            1. <strong>Bahan Baku:</strong> Terbuat dari bahan apa (contoh: mete asli Wonogiri pilihan).<br>
            2. <strong>Rasa &amp; Ciri Khas:</strong> Bagaimana rasanya (gurih, renyah, tanpa bahan pengawet).<br>
            3. <strong>Pilihan Ukuran:</strong> Tersedia kemasan toples atau plastik (misal: 250 gram, 500 gram, 1 kg).<br>
            4. <strong>Daya Tahan Simpan:</strong> Tahan berapa bulan jika disimpan rapat di tempat kering.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header">Langkah 5: Memilih Foto Produk yang Menarik</div>
        <p class="step-desc">
            Bapak/Ibu bisa memilih <strong>1 sampai 5 foto produk</strong>. Foto pertama akan otomatis menjadi foto sampul depan. Gunakan pencahayaan yang terang di atas meja yang bersih. Ukuran setiap foto <strong>Maksimal 5MB</strong>.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header">Langkah 6: Menandai Produk Unggulan (Maksimal 2 Produk)</div>
        <p class="step-desc">
            Jika produk tersebut adalah produk paling laris atau paling diandalkan, centang kotak <strong>"Jadikan Produk Unggulan"</strong>. Setiap UMKM mendapat jatah <strong>maksimal 2 produk unggulan</strong> yang akan dipajang di halaman depan peta website.
        </p>
    </div>

    <!-- PAGE BREAK -->
    <div class="page-break"></div>

    <!-- ============================================================== -->
    <!-- BAGIAN 5: KONSULTASI ONLINE                                    -->
    <!-- ============================================================== -->
    <h2 class="chapter-title">Bagian 5: Panduan Meminta Bantuan / Konsultasi Online</h2>
    <p style="font-size: 9.5pt; margin: 4px 0;">
        Jika Bapak/Ibu mengalami kesulitan dalam mengurus izin usaha (NIB), izin P-IRT makanan, izin Halal, atau ingin memperbaiki desain kemasan produk, Pemerintah Kabupaten Wonogiri menyediakan layanan konsultasi online:
    </p>

    <div class="step-box">
        <div class="step-header">Langkah 1: Membuka Halaman Konsultasi</div>
        <p class="step-desc">
            Klik menu <strong>Konsultasi</strong> di bagian atas website. Bapak/Ibu tidak harus login untuk menggunakan layanan ini.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header">Langkah 2: Memilih Jenis Bantuan yang Dibutuhkan</div>
        <p class="step-desc">
            Pilihlah salah satu topik yang sesuai dengan kendala Bapak/Ibu:<br>
            &bull; <strong>Perizinan Usaha (NIB / OSS):</strong> Untuk bantuan pembuatan izin NIB online.<br>
            &bull; <strong>Izin P-IRT:</strong> Untuk sertifikat keamanan pangan dari Dinas Kesehatan.<br>
            &bull; <strong>Sertifikasi Halal:</strong> Untuk pendampingan sertifikat halal resmi dari Kemenag/BPJPH.<br>
            &bull; <strong>Desain Kemasan &amp; Merek:</strong> Untuk perbaikan stiker, logo, atau bungkus produk.
        </p>
    </div>

    <div class="step-box">
        <div class="step-header">Langkah 3: Menceritakan Kendala &amp; Melampirkan Foto</div>
        <p class="step-desc">
            Tuliskan pertanyaan atau kendala Bapak/Ibu secara jelas. Jika ada berkas atau foto kemasan yang bermasalah, lampirkan foto tersebut (Bisa sampai 3 berkas, masing-masing <strong>Maksimal 5MB</strong>).
        </p>
    </div>

    <div class="step-box">
        <div class="step-header">Langkah 4: Mencatat Nomor Tiket Konsultasi</div>
        <p class="step-desc">
            Setelah dikirim, layar akan menampilkan <strong>Nomor Tiket Konsultasi</strong> (misalnya: <code>KST-202611-0089</code>). Catat nomor ini di buku catatan atau simpan di HP Bapak/Ibu untuk memeriksa balasan dan jawaban dari petugas dinas.
        </p>
    </div>

    <!-- ============================================================== -->
    <!-- BAGIAN 6: TANYA JAWAB UMUM (FAQ)                               -->
    <!-- ============================================================== -->
    <h2 class="chapter-title">Bagian 6: Tanya Jawab Masalah yang Sering Dialami</h2>

    <div class="avoid-break">
        <p style="font-size: 9pt; margin-bottom: 2px;"><strong>Pertanyaan: Kenapa foto saya tidak bisa terunggah / gagal disimpan?</strong></p>
        <p style="font-size: 9pt; margin-top: 0; color: #475569; margin-bottom: 8px;">
            <strong>Jawaban:</strong> Biasanya karena ukuran foto dari kamera HP terlalu besar (lebih dari 5MB). Solusinya: kirimkan foto tersebut terlebih dahulu ke WhatsApp keluarga/rekan lalu simpan kembali, atau gunakan pengaturan kamera HP dengan resolusi standar.
        </p>

        <p style="font-size: 9pt; margin-bottom: 2px;"><strong>Pertanyaan: Bagaimana jika saya lupa kata sandi akun saya?</strong></p>
        <p style="font-size: 9pt; margin-top: 0; color: #475569; margin-bottom: 8px;">
            <strong>Jawaban:</strong> Bapak/Ibu tidak perlu panik. Silakan kirim pesan ke layanan helpdesk dinas atau gunakan menu Konsultasi dengan menyebutkan nama usaha dan nomor WhatsApp yang terdaftar. Petugas akan membantu memulihkan kata sandi Bapak/Ibu.
        </p>

        <p style="font-size: 9pt; margin-bottom: 2px;"><strong>Pertanyaan: Apakah pendaftaran di Pojok UMKM ini dipungut biaya?</strong></p>
        <p style="font-size: 9pt; margin-top: 0; color: #475569; margin-bottom: 8px;">
            <strong>Jawaban:</strong> <strong>100% GRATIS.</strong> Seluruh layanan pendaftaran profil, pemajangan katalog produk di peta, dan konsultasi online difasilitasi gratis oleh Pemerintah Kabupaten Wonogiri.
        </p>
    </div>

    <!-- ============================================================== -->
    <!-- BAGIAN 7: KONTAK HELPDESK DINAS                                -->
    <!-- ============================================================== -->
    <h2 class="chapter-title">Bagian 7: Alamat Kantor &amp; Layanan Bantuan Langsung</h2>
    <div class="tip-box" style="background-color: #f8fafc; border-color: #800000; border-left-color: #800000; color: #0f172a;">
        <strong>Dinas Koperasi, Usaha Kecil Menengah, Perindustrian dan Perdagangan Kab. Wonogiri</strong><br>
        Alamat: Jl. Pemuda No. 1, Giriwono, Kecamatan Wonogiri, Kabupaten Wonogiri, Jawa Tengah<br>
        Hari &amp; Jam Layanan Kantor: Senin s/d Jumat, Pukul 08.00 - 15.30 WIB<br>
        Website Resmi: <strong>pojokumkm.wonogirikab.go.id</strong>
    </div>

    <div class="footer-note">
        Buku Panduan Penggunaan Resmi &bull; Hak Cipta &copy; {{ date('Y') }} Dinas KUKM dan Perindag Kabupaten Wonogiri
    </div>

</body>
</html>
