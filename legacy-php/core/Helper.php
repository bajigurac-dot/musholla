<?php
/**
 * Helper Functions & Formatting
 */

class Helper {
    public static function e(?string $text): string {
        return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
    }

    public static function url(string $path = ''): string {
        $path = ltrim($path, '/');
        return BASE_URL . ($path ? '/' . $path : '');
    }

    public static function asset(string $path): string {
        return self::url('assets/' . ltrim($path, '/'));
    }

    public static function uploadUrl(?string $filename, string $default = 'placeholder.svg'): string {
        if (!empty($filename) && file_exists(UPLOAD_DIR . '/' . $filename)) {
            return UPLOAD_URL . '/' . $filename;
        }
        return self::asset('images/' . $default);
    }

    public static function slug(string $text): string {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return empty($text) ? 'n-a' : $text;
    }

    public static function formatDate(?string $date, bool $withTime = false): string {
        if (empty($date)) return '-';
        $timestamp = strtotime($date);
        if (!$timestamp) return $date;

        $months = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $days = [
            'Sunday' => 'Ahad', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];

        $dayName = $days[date('l', $timestamp)] ?? '';
        $dayNum = date('j', $timestamp);
        $monthName = $months[(int)date('n', $timestamp)] ?? '';
        $year = date('Y', $timestamp);

        $result = "$dayName, $dayNum $monthName $year";
        if ($withTime) {
            $result .= ' ' . date('H:i', $timestamp) . ' WIB';
        }
        return $result;
    }

    public static function formatRupiah($amount): string {
        $num = (float)($amount ?? 0);
        return 'Rp ' . number_format($num, 0, ',', '.');
    }

    public static function limitWords(string $text, int $limit = 25): string {
        $clean = strip_tags($text);
        $words = explode(' ', $clean);
        if (count($words) <= $limit) {
            return $clean;
        }
        return implode(' ', array_slice($words, 0, $limit)) . '...';
    }

    public static function isActive(string $route): string {
        $currentUri = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
        $route = trim($route, '/');
        if ($route === '' && ($currentUri === '' || $currentUri === 'index.php')) {
            return 'active';
        }
        if ($route !== '' && (strpos($currentUri, $route) !== false)) {
            return 'active';
        }
        return '';
    }
}

// Global short functions
function e(?string $text): string {
    return Helper::e($text);
}
function url(string $path = ''): string {
    return Helper::url($path);
}
