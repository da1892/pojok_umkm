@echo off
title Pojok UMKM Wonogiri - Web Server
color 0a
echo ========================================================
echo   MENJALANKAN SERVER WEBSITE POJOK UMKM WONOGIRI
echo ========================================================
echo.
cd /d "%~dp0"
echo Direktori aktif: %CD%
echo.
echo Website berjalan di:
echo   -^> http://127.0.0.1:8000
echo   -^> http://localhost:8000
echo.
echo Tekan [Ctrl + C] jika ingin mematikan server.
echo ========================================================
echo.
php artisan serve --port=8000
pause
