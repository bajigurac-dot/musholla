<?php
/**
 * Front Controller Musholla Ar-rahman
 */

// Error reporting untuk development (bisa disesuaikan via .env APP_ENV=production)
if (getenv('APP_ENV') === 'production') {
    ini_set('display_errors', '0');
    error_reporting(0);
} else {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

// 1. Load Konfigurasi
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

// 2. Load Core Classes
require_once __DIR__ . '/../core/Helper.php';
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../core/Csrf.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Uploader.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/App.php';

// Inisialisasi Session Aman
Session::start();

// 3. Load Models
require_once __DIR__ . '/../models/Setting.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/Gallery.php';
require_once __DIR__ . '/../models/Finance.php';
require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../models/PrayerSchedule.php';

// 4. Inisialisasi Database Connection & Seeder jika diperlukan
Database::getConnection();

// 5. Load Routes
require_once __DIR__ . '/../config/routes.php';

// 6. Jalankan Aplikasi
App::run();
