<?php
/**
 * Konfigurasi Database (Mendukung MySQL/MariaDB & SQLite fallback)
 */

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            self::initConnection();
        }
        return self::$instance;
    }

    private static function initConnection(): void {
        // Cek file .env sederhana jika ada
        $envFile = ROOT_PATH . '/.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) continue;
                $parts = explode('=', $line, 2);
                if (count($parts) === 2) {
                    $key = trim($parts[0]);
                    $val = trim($parts[1]);
                    if (!isset($_ENV[$key])) {
                        $_ENV[$key] = $val;
                        putenv("$key=$val");
                    }
                }
            }
        }

        $driver = getenv('DB_CONNECTION') ?: 'sqlite'; // Default sqlite untuk lokal zero-config, atau mysql
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $port = getenv('DB_PORT') ?: '3306';
        $dbname = getenv('DB_DATABASE') ?: 'mushola_ar_rahman';
        $username = getenv('DB_USERNAME') ?: 'root';
        $password = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '';

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            if ($driver === 'mysql') {
                $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
                self::$instance = new PDO($dsn, $username, $password, $options);
            } else {
                // SQLite connection
                $dbPath = ROOT_PATH . '/database/mushola.sqlite';
                $dir = dirname($dbPath);
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                $isNew = !file_exists($dbPath);
                self::$instance = new PDO("sqlite:{$dbPath}", null, null, $options);
                self::$instance->exec('PRAGMA foreign_keys = ON;');
                if ($isNew) {
                    require_once ROOT_PATH . '/database/DatabaseSeeder.php';
                    DatabaseSeeder::run(self::$instance, 'sqlite');
                }
            }
        } catch (PDOException $e) {
            // Jika koneksi MySQL gagal, coba fallback ke SQLite lokal agar website tetap bisa dijalankan
            if ($driver === 'mysql') {
                try {
                    $dbPath = ROOT_PATH . '/database/mushola.sqlite';
                    $dir = dirname($dbPath);
                    if (!is_dir($dir)) {
                        mkdir($dir, 0755, true);
                    }
                    $isNew = !file_exists($dbPath);
                    self::$instance = new PDO("sqlite:{$dbPath}", null, null, $options);
                    self::$instance->exec('PRAGMA foreign_keys = ON;');
                    if ($isNew) {
                        require_once ROOT_PATH . '/database/DatabaseSeeder.php';
                        DatabaseSeeder::run(self::$instance, 'sqlite');
                    }
                    return;
                } catch (PDOException $e2) {
                    die("Koneksi database gagal: " . $e->getMessage());
                }
            }
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }
}
