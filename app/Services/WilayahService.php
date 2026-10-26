<?php

namespace App\Services;

use Exception;
use ZipArchive;

class WilayahService
{
    /**
     * Cari lokasi file master excel di folder standar Laravel.
     */
    public static function resolveFilePath(string $filename): ?string
    {
        $locations = [
            database_path('data/' . $filename),
            storage_path('app/master/' . $filename),
            storage_path('app/data/' . $filename),
            storage_path('app/' . $filename),
            base_path($filename),
        ];

        foreach ($locations as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Parse file XLSX menggunakan ZipArchive dan XML parser native PHP.
     * Cepat, andal, dan tidak memerlukan composer package eksternal.
     */
    public static function parseXlsx(string $xlsxPath): array
    {
        if (!file_exists($xlsxPath)) {
            throw new Exception("File Excel tidak ditemukan pada path: {$xlsxPath}");
        }

        $zip = new ZipArchive();
        if ($zip->open($xlsxPath) !== true) {
            throw new Exception("Gagal membuka file Excel zip: {$xlsxPath}");
        }

        // 1. Baca shared strings
        $sharedStrings = [];
        $ssXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($ssXml) {
            $xml = simplexml_load_string($ssXml);
            if ($xml && isset($xml->si)) {
                foreach ($xml->si as $si) {
                    if (isset($si->t)) {
                        $sharedStrings[] = (string) $si->t;
                    } elseif (isset($si->r)) {
                        $text = '';
                        foreach ($si->r as $r) {
                            $text .= (string) $r->t;
                        }
                        $sharedStrings[] = $text;
                    } else {
                        $sharedStrings[] = '';
                    }
                }
            }
        }

        // 2. Baca sheet1
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        if (!$sheetXml) {
            $zip->close();
            throw new Exception("Sheet1 tidak ditemukan di dalam: {$xlsxPath}");
        }

        $xml = simplexml_load_string($sheetXml);
        $rows = [];

        if ($xml && isset($xml->sheetData->row)) {
            foreach ($xml->sheetData->row as $row) {
                $rowData = [];
                foreach ($row->c as $cell) {
                    $ref = (string) $cell['r'];
                    $colLetter = preg_replace('/[0-9]/', '', $ref);

                    $colIdx = 0;
                    $len = strlen($colLetter);
                    for ($i = 0; $i < $len; $i++) {
                        $colIdx = $colIdx * 26 + (ord($colLetter[$i]) - ord('A') + 1);
                    }
                    $colIdx -= 1;

                    $val = (string) $cell->v;
                    $type = (string) $cell['t'];

                    if ($type === 's' && isset($sharedStrings[(int) $val])) {
                        $val = $sharedStrings[(int) $val];
                    }

                    $rowData[$colIdx] = $val;
                }
                $rows[] = $rowData;
            }
        }

        $zip->close();
        return $rows;
    }

    /**
     * Sinkronisasi data Wonogiri dari master_kecamatan.xlsx dan master_desa.xlsx
     * ke public/wonogiri_wilayah.json
     */
    public static function syncFromExcel(): array
    {
        $kecPath = self::resolveFilePath('master_kecamatan.xlsx');
        $desaPath = self::resolveFilePath('master_desa.xlsx');

        if (!$kecPath) {
            throw new Exception("File master_kecamatan.xlsx tidak ditemukan di database/data/ maupun root project.");
        }
        if (!$desaPath) {
            throw new Exception("File master_desa.xlsx tidak ditemukan di database/data/ maupun root project.");
        }

        // 1. Ekstrak Kecamatan Wonogiri (kode_kabupatenkota = 3312)
        $kecRows = self::parseXlsx($kecPath);
        if (empty($kecRows)) {
            throw new Exception("File master_kecamatan.xlsx kosong.");
        }

        $headerKec = $kecRows[0];
        $colKodeKab = array_search('kode_kabupatenkota', $headerKec);
        $colKodeKec = array_search('kode', $headerKec);
        $colNamaKec = array_search('nama', $headerKec);

        if ($colKodeKab === false || $colKodeKec === false || $colNamaKec === false) {
            throw new Exception("Format kolom master_kecamatan.xlsx tidak sesuai header Kemendagri.");
        }

        $wonogiriKec = []; // kode_kec => Nama Kecamatan
        foreach (array_slice($kecRows, 1) as $r) {
            if (isset($r[$colKodeKab]) && trim($r[$colKodeKab]) === '3312') {
                $wonogiriKec[trim($r[$colKodeKec])] = ucwords(strtolower(trim($r[$colNamaKec])));
            }
        }

        asort($wonogiriKec);

        // 2. Ekstrak Desa/Kelurahan Wonogiri (kode_kecamatan berelasi)
        $desaRows = self::parseXlsx($desaPath);
        if (empty($desaRows)) {
            throw new Exception("File master_desa.xlsx kosong.");
        }

        $headerDesa = $desaRows[0];
        $colKodeKecInDesa = array_search('kode_kecamatan', $headerDesa);
        $colNamaDesa = array_search('nama', $headerDesa);

        if ($colKodeKecInDesa === false || $colNamaDesa === false) {
            throw new Exception("Format kolom master_desa.xlsx tidak sesuai header Kemendagri.");
        }

        $resultStructure = [];
        foreach ($wonogiriKec as $namaKec) {
            $resultStructure[$namaKec] = [];
        }

        $totalDesa = 0;
        foreach (array_slice($desaRows, 1) as $r) {
            $kCode = isset($r[$colKodeKecInDesa]) ? trim($r[$colKodeKecInDesa]) : null;
            if ($kCode && isset($wonogiriKec[$kCode])) {
                $namaKec = $wonogiriKec[$kCode];
                $namaDesa = ucwords(strtolower(trim($r[$colNamaDesa])));
                $resultStructure[$namaKec][] = $namaDesa;
                $totalDesa++;
            }
        }

        // Urutkan nama desa secara alfabetis
        foreach ($resultStructure as $kec => &$desas) {
            sort($desas);
        }
        unset($desas);

        // Simpan ke public/wonogiri_wilayah.json
        $targetJson = public_path('wonogiri_wilayah.json');
        file_put_contents($targetJson, json_encode($resultStructure, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return [
            'kecamatan_count' => count($wonogiriKec),
            'desa_count' => $totalDesa,
            'kecamatan_file' => $kecPath,
            'desa_file' => $desaPath,
            'target_json' => $targetJson,
            'kecamatans' => array_values($wonogiriKec),
        ];
    }
}
