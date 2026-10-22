@echo off
title Menjalankan Website Musholla Ar-rahman
echo ========================================================
echo   Website Resmi Musholla Ar-rahman - Gembor Periuk
echo   Local Development Server
echo ========================================================
echo.

set PHP_BIN=php
where php >nul 2>nul
if %errorlevel% neq 0 (
    if exist "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe" (
        set PHP_BIN=C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe
    ) else if exist "C:\xampp\php\php.exe" (
        set PHP_BIN=C:\xampp\php\php.exe
    ) else (
        echo [ERROR] PHP tidak ditemukan di sistem.
        echo Silakan pasang PHP atau jalankan Laragon/XAMPP.
        pause
        exit /b 1
    )
)

echo Menggunakan PHP: %PHP_BIN%
echo Menjalankan server pada: http://localhost:8000
echo Tekan Ctrl+C untuk menghentikan server.
echo.
"%PHP_BIN%" -S localhost:8000 -t public
pause
