@echo off
title Push Codingan ke GitLab Wonogiri
echo ========================================================
echo   MENGUNGGAH SELURUH CODINGAN KE GITLAB WONOGIRI
echo ========================================================
echo.
cd /d "%~dp0"

echo 1. Mengunggah ke branch 'main'...
git push gitlab main

echo.
echo 2. Mengunggah ke branch 'dev'...
git push gitlab main:dev

echo.
echo ========================================================
echo   SELESAI! Tekan sembarang tombol untuk menutup jendela.
echo ========================================================
pause
