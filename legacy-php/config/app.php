<?php
/**
 * Konfigurasi Aplikasi Musholla Ar-rahman
 */

// Zona Waktu Indonesia Barat
date_default_timezone_set('Asia/Jakarta');

// Environment (development / production)
define('APP_ENV', getenv('APP_ENV') ?: 'development');

// Base URL otomatis mendeteksi protokol, domain, subfolder, atau konfigurasi .env
$envAppUrl = getenv('APP_URL');
if (!empty($envAppUrl)) {
    define('BASE_URL', rtrim($envAppUrl, '/'));
} else {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    
    // Jika root .htaccess meneruskan request ke public tanpa ada '/public' di REQUEST_URI pengunjung,
    // maka hilangkan '/public' dari path agar link tetap bersih dan elegan (misal: https://domain.com/profil)
    $reqUri = $_SERVER['REQUEST_URI'] ?? '/';
    if (substr($scriptDir, -7) === '/public' && strpos($reqUri, '/public') !== 0) {
        $scriptDir = substr($scriptDir, 0, -7);
    }
    
    $basePath = rtrim($scriptDir, '/');
    define('BASE_URL', rtrim($protocol . $host . $basePath, '/'));
}

// Nama & Pengaturan Default Aplikasi
define('APP_NAME', 'Musholla Ar-rahman');
define('APP_VERSION', '1.0.0');

// Direktori Unggahan (Uploads)
define('ROOT_PATH', realpath(__DIR__ . '/..'));
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('UPLOAD_DIR', PUBLIC_PATH . '/uploads');
define('UPLOAD_URL', BASE_URL . '/uploads');

// Batas Ukuran File Unggahan (8MB agar foto kamera HP leluasa)
define('MAX_UPLOAD_SIZE', 8 * 1024 * 1024);
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);
