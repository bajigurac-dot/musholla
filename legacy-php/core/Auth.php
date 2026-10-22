<?php
/**
 * Authentication & Access Control
 */

class Auth {
    private const MAX_ATTEMPTS = 5;
    private const LOCKOUT_SECONDS = 900; // 15 menit

    public static function attempt(string $username, string $password): bool {
        Session::start();

        // Cek brute-force lockout
        $attemptsKey = 'login_attempts_' . md5($username);
        $lockoutKey = 'login_lockout_' . md5($username);

        $lockoutTime = Session::get($lockoutKey, 0);
        if ($lockoutTime > time()) {
            $remaining = ceil(($lockoutTime - time()) / 60);
            Session::setFlash('error', "Terlalu banyak percobaan gagal. Silakan coba lagi dalam {$remaining} menit.");
            return false;
        }

        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE (username = :u OR email = :e) AND is_active = 1 LIMIT 1");
        $stmt->execute([':u' => $username, ':e' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Reset attempts
            Session::remove($attemptsKey);
            Session::remove($lockoutKey);

            // Perbarui last_login
            $update = $db->prepare("UPDATE users SET last_login = :ll WHERE id = :id");
            $update->execute([':ll' => date('Y-m-d H:i:s'), ':id' => $user['id']]);

            // Regenerasi ID Session untuk cegah session fixation
            session_regenerate_id(true);

            // Simpan info user di session (tanpa hash password)
            unset($user['password_hash']);
            Session::set('user', $user);
            return true;
        }

        // Catat kegagalan
        $attempts = Session::get($attemptsKey, 0) + 1;
        Session::set($attemptsKey, $attempts);

        if ($attempts >= self::MAX_ATTEMPTS) {
            Session::set($lockoutKey, time() + self::LOCKOUT_SECONDS);
            Session::setFlash('error', 'Terlalu banyak percobaan login yang gagal. Akun sementara dikunci selama 15 menit.');
        } else {
            Session::setFlash('error', 'Nama pengguna atau kata sandi tidak sesuai.');
        }

        return false;
    }

    public static function check(): bool {
        return Session::get('user') !== null;
    }

    public static function user(): ?array {
        return Session::get('user');
    }

    public static function id(): ?int {
        $u = self::user();
        return $u['id'] ?? null;
    }

    public static function role(): ?string {
        $u = self::user();
        return $u['role'] ?? null;
    }

    public static function isSuperAdmin(): bool {
        return self::role() === 'super_admin';
    }

    public static function requireAuth(): void {
        if (!self::check()) {
            Session::setFlash('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
            header('Location: ' . Helper::url('admin/login'));
            exit;
        }
    }

    public static function requireSuperAdmin(): void {
        self::requireAuth();
        if (!self::isSuperAdmin()) {
            Session::setFlash('error', 'Akses ditolak. Fitur ini hanya dapat diakses oleh Super Admin.');
            header('Location: ' . Helper::url('admin'));
            exit;
        }
    }

    public static function logout(): void {
        Session::destroy();
    }
}
