<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Konsultasi - Pojok UMKM Wonogiri</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; -webkit-font-smoothing: antialiased; color: #1e293b; line-height: 1.6;">

    <!-- Outer Container -->
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f8fafc; padding: 40px 15px;">
        <tr>
            <td align="center">
                
                <!-- Main Email Card (Max 580px) -->
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 580px; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03); border: 1px solid #e2e8f0;">
                    
                    <!-- Top Accent Banner -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #800000 0%, #991b1b 50%, #b91c1c 100%); padding: 36px 30px 32px 30px; text-align: center; color: #ffffff;">
                            
                            <!-- Logo Kabupaten Wonogiri (Tanpa Border Putih) -->
                            @if(file_exists(public_path('images/logo-wonogiri.png')))
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: 0 auto 14px auto;">
                                    <tr>
                                        <td align="center">
                                            <img src="{{ $message->embed(public_path('images/logo-wonogiri.png')) }}" alt="Logo Wonogiri" width="60" height="auto" style="display: block; max-width: 60px; height: auto; border: 0; outline: none; text-decoration: none;">
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #fecaca; margin-bottom: 4px;">
                                Layanan Konsultasi Bisnis
                            </div>
                            <h1 style="margin: 0; font-size: 22px; font-weight: 800; letter-spacing: -0.3px; color: #ffffff;">
                                Pojok UMKM Wonogiri
                            </h1>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 32px 32px 24px 32px;">
                            
                            <!-- Sapaan Hangat & Profesional -->
                            @php
                                $cleanName = trim($consultation->name);
                                $lowerName = strtolower($cleanName);
                                
                                // Deteksi awalan sapaan (Ibu, Bu, Bapak, Pak, dll)
                                if (
                                    str_starts_with($lowerName, 'ibu ') || 
                                    str_starts_with($lowerName, 'bu ') || 
                                    str_starts_with($lowerName, 'ny. ') || 
                                    str_starts_with($lowerName, 'nn. ') || 
                                    str_starts_with($lowerName, 'sdri ') || 
                                    str_starts_with($lowerName, 'sdri. ')
                                ) {
                                    $displayName = $cleanName;
                                } elseif (
                                    str_starts_with($lowerName, 'bapak ') || 
                                    str_starts_with($lowerName, 'pak ') || 
                                    str_starts_with($lowerName, 'sdr ') || 
                                    str_starts_with($lowerName, 'sdr. ')
                                ) {
                                    $displayName = $cleanName;
                                } else {
                                    // Default sopan & universal untuk pria maupun wanita
                                    $displayName = 'Bapak/Ibu ' . $cleanName;
                                }
                            @endphp

                            <h2 style="margin: 0 0 10px 0; font-size: 18px; font-weight: 700; color: #0f172a;">
                                Halo, {{ $displayName }}
                            </h2>
                            <p style="margin: 0 0 24px 0; font-size: 14px; color: #475569; line-height: 1.65;">
                                Pengajuan konsultasi Anda telah berhasil kami terima. Tim konsultan Pojok UMKM Wonogiri akan segera meninjau dan memberikan solusi terbaik untuk memajukan usaha Anda.
                            </p>

                            <!-- Modern Ticket Box (Card Style) -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background: linear-gradient(180deg, #fff5f5 0%, #fef2f2 100%); border: 1px solid #fecaca; border-radius: 16px; margin-bottom: 26px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 20px 22px; text-align: center;">
                                        <div style="display: inline-block; background-color: #fee2e2; color: #991b1b; font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; padding: 4px 12px; border-radius: 20px; margin-bottom: 10px;">
                                            ID Tiket Konsultasi Anda
                                        </div>
                                        <div style="background-color: #ffffff; border: 1.5px dashed #f87171; border-radius: 10px; padding: 12px 14px; font-family: 'SF Mono', Consolas, Monaco, monospace; font-size: 15px; font-weight: 800; color: #800000; letter-spacing: 0.5px; word-break: break-all; box-shadow: inset 0 1px 2px rgba(0,0,0,0.03);">
                                            {{ $consultation->ticket_id }}
                                        </div>
                                        <p style="margin: 10px 0 0 0; font-size: 12px; color: #7f1d1d; line-height: 1.4;">
                                            Simpan kode tiket ini untuk mengecek tanggapan dari konsultan kami.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Informasi Pengajuan (Clean Card) -->
                            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px 20px; margin-bottom: 26px;">
                                <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #64748b; margin-bottom: 12px;">
                                    Ringkasan Konsultasi
                                </div>

                                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size: 13.5px;">
                                    <tr>
                                        <td width="38%" style="padding: 6px 0; color: #64748b; font-weight: 500;">Kategori Topik</td>
                                        <td style="padding: 6px 0; color: #0f172a; font-weight: 700;">
                                            <span style="display: inline-block; background-color: #fee2e2; color: #991b1b; padding: 2px 10px; border-radius: 12px; font-size: 12px; font-weight: 700;">
                                                {{ $consultation->subject }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="38%" style="padding: 6px 0; color: #64748b; font-weight: 500;">Waktu Dikirim</td>
                                        <td style="padding: 6px 0; color: #1e293b; font-weight: 600;">
                                            {{ $consultation->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') }} WIB
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b; font-weight: 500;">Status</td>
                                        <td style="padding: 6px 0; color: #1e293b;">
                                            <span style="display: inline-block; background-color: #fef3c7; color: #92400e; padding: 2px 9px; border-radius: 12px; font-size: 11.5px; font-weight: 700;">
                                                ⏳ Menunggu Balasan
                                            </span>
                                        </td>
                                    </tr>
                                    @if($consultation->message)
                                        <tr>
                                            <td valign="top" style="padding: 8px 0 0 0; color: #64748b; font-weight: 500;">Pesan Anda</td>
                                            <td style="padding: 8px 0 0 0; color: #334155; font-style: italic; font-size: 13px; line-height: 1.5;">
                                                "{{ Str::limit($consultation->message, 160) }}"
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>

                            <!-- Tombol Call To Action Utama -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom: 26px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('konsultasi.cek', ['ticket_id' => $consultation->ticket_id]) }}" target="_blank" style="display: inline-block; background-color: #800000; background: linear-gradient(135deg, #800000 0%, #991b1b 100%); color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 700; padding: 14px 34px; border-radius: 50px; box-shadow: 0 4px 14px rgba(128, 0, 0, 0.25); letter-spacing: 0.3px;">
                                            Lihat Status & Balasan &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0; font-size: 12.5px; color: #64748b; line-height: 1.6; text-align: center;">
                                Konsultan kami biasanya merespons dalam <strong>1&times;24 jam kerja</strong>. Anda dapat mengklik tombol di atas kapan saja untuk melihat perkembangannya.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer Minimalis & Profesional -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 24px 32px; text-align: center; border-top: 1px solid #f1f5f9;">
                            <div style="font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 2px;">
                                Pojok UMKM Wonogiri
                            </div>
                            <div style="font-size: 11.5px; color: #64748b; margin-bottom: 12px;">
                                Dinas KUKM dan Perdagangan Kabupaten Wonogiri
                            </div>
                            <div style="font-size: 11px; color: #94a3b8; line-height: 1.5;">
                                Email ini dibuat secara otomatis oleh sistem. Harap tidak membalas email ini secara langsung.
                            </div>
                        </td>
                    </tr>

                </table>
                <!-- End Main Card -->

            </td>
        </tr>
    </table>

</body>
</html>
