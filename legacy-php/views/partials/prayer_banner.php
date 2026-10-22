<?php
$prayer = $prayer ?? PrayerSchedule::getTodaySchedule();
?>

<div class="prayer-widget-wrapper">
    <div class="container">
        <div class="prayer-card">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                        <i class="bi bi-clock-history me-1"></i> Jadwal Salat Hari Ini
                    </span>
                    <strong class="text-dark small"><i class="bi bi-geo-alt-fill text-danger"></i> <?= htmlspecialchars($prayer['city'] ?? 'Kota Tangerang') ?></strong>
                </div>
                <div class="small text-muted">
                    <i class="bi bi-calendar-event me-1"></i> <?= Helper::formatDate(date('Y-m-d')) ?>
                    <span class="badge bg-light text-secondary border ms-1"><?= htmlspecialchars($prayer['source'] ?? '') ?></span>
                </div>
            </div>

            <div class="row g-2 g-md-3">
                <!-- Subuh -->
                <div class="col-4 col-md-2">
                    <div class="prayer-item" data-time="<?= htmlspecialchars($prayer['Fajr']) ?>">
                        <div class="prayer-name">Subuh</div>
                        <div class="prayer-time"><?= htmlspecialchars($prayer['Fajr']) ?></div>
                    </div>
                </div>
                <!-- Terbit / Syuruq -->
                <div class="col-4 col-md-2">
                    <div class="prayer-item" data-time="<?= htmlspecialchars($prayer['Sunrise']) ?>">
                        <div class="prayer-name">Terbit</div>
                        <div class="prayer-time"><?= htmlspecialchars($prayer['Sunrise']) ?></div>
                    </div>
                </div>
                <!-- Dzuhur -->
                <div class="col-4 col-md-2">
                    <div class="prayer-item" data-time="<?= htmlspecialchars($prayer['Dhuhr']) ?>">
                        <div class="prayer-name">Dzuhur</div>
                        <div class="prayer-time"><?= htmlspecialchars($prayer['Dhuhr']) ?></div>
                    </div>
                </div>
                <!-- Ashar -->
                <div class="col-4 col-md-2">
                    <div class="prayer-item" data-time="<?= htmlspecialchars($prayer['Asr']) ?>">
                        <div class="prayer-name">Ashar</div>
                        <div class="prayer-time"><?= htmlspecialchars($prayer['Asr']) ?></div>
                    </div>
                </div>
                <!-- Maghrib -->
                <div class="col-4 col-md-2">
                    <div class="prayer-item" data-time="<?= htmlspecialchars($prayer['Maghrib']) ?>">
                        <div class="prayer-name">Maghrib</div>
                        <div class="prayer-time"><?= htmlspecialchars($prayer['Maghrib']) ?></div>
                    </div>
                </div>
                <!-- Isya -->
                <div class="col-4 col-md-2">
                    <div class="prayer-item" data-time="<?= htmlspecialchars($prayer['Isha']) ?>">
                        <div class="prayer-name">Isya</div>
                        <div class="prayer-time"><?= htmlspecialchars($prayer['Isha']) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
