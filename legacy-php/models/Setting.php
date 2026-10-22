<?php
/**
 * Setting Model
 */

class Setting extends Model {
    protected string $table = 'settings';
    private static ?array $cachedSettings = null;

    public static function getAllAssoc(): array {
        if (self::$cachedSettings !== null) {
            return self::$cachedSettings;
        }

        $db = Database::getConnection();
        $stmt = $db->query("SELECT setting_key, setting_value FROM settings");
        $rows = $stmt->fetchAll();
        $res = [];
        foreach ($rows as $r) {
            $res[$r['setting_key']] = $r['setting_value'];
        }
        self::$cachedSettings = $res;
        return $res;
    }

    public static function get(string $key, $default = ''): string {
        $settings = self::getAllAssoc();
        return $settings[$key] ?? $default;
    }

    public static function set(string $key, ?string $value): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE settings SET setting_value = :val WHERE setting_key = :key");
        $res = $stmt->execute([':val' => $value, ':key' => $key]);
        self::$cachedSettings = null; // flush cache
        return $res;
    }

    public static function updateMany(array $data): void {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE settings SET setting_value = :val WHERE setting_key = :key");
        foreach ($data as $key => $val) {
            $stmt->execute([':val' => $val, ':key' => $key]);
        }
        self::$cachedSettings = null;
    }
}
