<?php
/**
 * Admin Prayer Controller (Pengaturan Jadwal Salat)
 */

class AdminPrayerController extends Controller {
    public function index(): void {
        Auth::requireAuth();

        $schedule = PrayerSchedule::getTodaySchedule();

        $this->render('admin/prayer/index', [
            'title'    => 'Pengaturan Jadwal Salat',
            'settings' => Setting::getAllAssoc(),
            'schedule' => $schedule
        ], 'admin');
    }

    public function update(): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $mode = $_POST['prayer_mode'] ?? 'api';
        $city = trim($_POST['prayer_city'] ?? 'Kota Tangerang');

        $data = [
            'prayer_mode'    => $mode,
            'prayer_city'    => $city,
            'prayer_fajr'    => trim($_POST['prayer_fajr'] ?? '04:22'),
            'prayer_sunrise' => trim($_POST['prayer_sunrise'] ?? '05:38'),
            'prayer_dhuhr'   => trim($_POST['prayer_dhuhr'] ?? '11:47'),
            'prayer_asr'     => trim($_POST['prayer_asr'] ?? '15:02'),
            'prayer_maghrib' => trim($_POST['prayer_maghrib'] ?? '17:53'),
            'prayer_isha'    => trim($_POST['prayer_isha'] ?? '19:03')
        ];

        Setting::updateMany($data);

        // Hapus cache jadwal salat hari ini agar langsung memperbarui
        $cacheFile = ROOT_PATH . '/database/prayer_cache_' . date('Ymd') . '.json';
        if (file_exists($cacheFile)) {
            @unlink($cacheFile);
        }

        Session::setFlash('success', 'Pengaturan jadwal salat berhasil diperbarui.');
        $this->redirect('admin/prayer');
    }
}
