@echo off
title Pojok UMKM Wonogiri - Server Cepat Multi-Worker
set PHP_CLI_SERVER_WORKERS=4
echo ====================================================================
echo   Memulai Server Pojok UMKM (Multi-Worker Mode: 4 Proses Paralel)
echo   Navigasi antar fitur kini cepat dan tidak saling mengantre.
echo   Akses di browser: http://127.0.0.1:8000
echo ====================================================================
php artisan serve --port=8000
pause
