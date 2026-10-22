<?php
/**
 * Prayer Schedule Service (Jadwal Salat Otomatis & Manual dengan Fallback)
 */

class PrayerSchedule {
    public static function getTodaySchedule(): array {
        $mode = Setting::get('prayer_mode', 'api');
        $city = Setting::get('prayer_city', 'Kota Tangerang');

        // Fallback default jadwal Tangerang & sekitarnya jika offline / API gagal
        $fallback = [
            'Fajr'    => '04:22',
            'Sunrise' => '05:38',
            'Dhuhr'   => '11:47',
            'Asr'     => '15:02',
            'Maghrib' => '17:53',
            'Isha'    => '19:03',
            'source'  => 'Perkiraan Standar (Offline Fallback)',
            'city'    => $city,
            'date'    => date('d-m-Y')
        ];

        if ($mode === 'manual') {
            return [
                'Fajr'    => Setting::get('prayer_fajr', '04:22'),
                'Sunrise' => Setting::get('prayer_sunrise', '05:38'),
                'Dhuhr'   => Setting::get('prayer_dhuhr', '11:47'),
                'Asr'     => Setting::get('prayer_asr', '15:02'),
                'Maghrib' => Setting::get('prayer_maghrib', '17:53'),
                'Isha'    => Setting::get('prayer_isha', '19:03'),
                'source'  => 'Input Manual Pengurus',
                'city'    => $city,
                'date'    => date('d-m-Y')
            ];
        }

        // Cek cache lokal hari ini (agar tidak memanggil API berulang-ulang pada setiap load)
        $cacheFile = ROOT_PATH . '/database/prayer_cache_' . date('Ymd') . '.json';
        if (file_exists($cacheFile)) {
            $cached = json_decode(file_get_contents($cacheFile), true);
            if (is_array($cached) && !empty($cached['Fajr'])) {
                return $cached;
            }
        }

        // Panggil Aladhan API dengan timeout ketat (1.5 detik) agar tidak memperlambat loading
        try {
            // Koordinat Tangerang Periuk: Lat -6.18, Long 106.58, Kemenag method = 20 (KEMENAG)
            $url = "https://api.aladhan.com/v1/timings/" . time() . "?latitude=-6.1804&longitude=106.5772&method=20";
            
            $ctx = stream_context_create([
                'http' => [
                    'timeout' => 1.5,
                    'user_agent' => 'Musholla-Ar-rahman-Web/1.0'
                ]
            ]);

            $json = @file_get_contents($url, false, $ctx);
            if ($json) {
                $res = json_decode($json, true);
                if (isset($res['data']['timings'])) {
                    $timings = $res['data']['timings'];
                    $data = [
                        'Fajr'    => substr($timings['Fajr'], 0, 5),
                        'Sunrise' => substr($timings['Sunrise'], 0, 5),
                        'Dhuhr'   => substr($timings['Dhuhr'], 0, 5),
                        'Asr'     => substr($timings['Asr'], 0, 5),
                        'Maghrib' => substr($timings['Maghrib'], 0, 5),
                        'Isha'    => substr($timings['Isha'], 0, 5),
                        'source'  => 'Kemenag RI / Aladhan API',
                        'city'    => $city,
                        'date'    => date('d-m-Y')
                    ];
                    @file_put_contents($cacheFile, json_encode($data));
                    return $data;
                }
            }
        } catch (\Throwable $e) {
            // Abaikan kesalahan koneksi dan gunakan fallback
        }

        return $fallback;
    }
}
