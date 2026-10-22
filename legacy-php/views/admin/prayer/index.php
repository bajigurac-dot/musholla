<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold m-0">Pengaturan Jadwal Salat</h4>
        <small class="text-muted">Konfigurasi perhitungan otomatis Kemenag RI atau input manual oleh DKM</small>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="fw-bold m-0"><i class="bi bi-clock-history text-success me-2"></i>Konfigurasi Jadwal Salat</h5>
            </div>
            <div class="admin-card-body p-4">
                <form action="<?= Helper::url('admin/prayer/update') ?>" method="POST">
                    <?= Csrf::field() ?>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Pilih Mode Jadwal Salat</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="prayer_mode" id="mode_api" value="api" <?= ($settings['prayer_mode'] ?? 'api') === 'api' ? 'checked' : '' ?>>
                                <label class="form-check-label fw-bold small" for="mode_api">
                                    Otomatis Berdasarkan Lokasi (API Kemenag RI)
                                </label>
                                <small class="text-muted d-block">Menyesuaikan posisi matahari harian Kota Tangerang & sekitarnya dengan sistem fallback offline.</small>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="prayer_mode" id="mode_manual" value="manual" <?= ($settings['prayer_mode'] ?? '') === 'manual' ? 'checked' : '' ?>>
                                <label class="form-check-label fw-bold small" for="mode_manual">
                                    Input Manual Pengurus
                                </label>
                                <small class="text-muted d-block">Menggunakan jam salat tetap yang ditentukan di bawah ini.</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="prayer_city" class="form-label small fw-bold">Nama Kota / Wilayah Tampilan</label>
                        <input type="text" class="form-control" id="prayer_city" name="prayer_city" value="<?= htmlspecialchars($settings['prayer_city'] ?? 'Kota Tangerang') ?>">
                    </div>

                    <h6 class="fw-bold mb-3 border-top pt-3">Waktu Salat Manual (Dipakai jika mode manual atau saat koneksi API offline)</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-4">
                            <label class="form-label small fw-bold">Subuh</label>
                            <input type="text" class="form-control form-control-sm" name="prayer_fajr" value="<?= htmlspecialchars($settings['prayer_fajr'] ?? '04:22') ?>">
                        </div>
                        <div class="col-4">
                            <label class="form-label small fw-bold">Terbit / Syuruq</label>
                            <input type="text" class="form-control form-control-sm" name="prayer_sunrise" value="<?= htmlspecialchars($settings['prayer_sunrise'] ?? '05:38') ?>">
                        </div>
                        <div class="col-4">
                            <label class="form-label small fw-bold">Dzuhur</label>
                            <input type="text" class="form-control form-control-sm" name="prayer_dhuhr" value="<?= htmlspecialchars($settings['prayer_dhuhr'] ?? '11:47') ?>">
                        </div>
                        <div class="col-4">
                            <label class="form-label small fw-bold">Ashar</label>
                            <input type="text" class="form-control form-control-sm" name="prayer_asr" value="<?= htmlspecialchars($settings['prayer_asr'] ?? '15:02') ?>">
                        </div>
                        <div class="col-4">
                            <label class="form-label small fw-bold">Maghrib</label>
                            <input type="text" class="form-control form-control-sm" name="prayer_maghrib" value="<?= htmlspecialchars($settings['prayer_maghrib'] ?? '17:53') ?>">
                        </div>
                        <div class="col-4">
                            <label class="form-label small fw-bold">Isya</label>
                            <input type="text" class="form-control form-control-sm" name="prayer_isha" value="<?= htmlspecialchars($settings['prayer_isha'] ?? '19:03') ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-save me-1"></i> Simpan Pengaturan Jadwal
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Live Preview Jadwal Saat Ini -->
    <div class="col-lg-5">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="fw-bold m-0"><i class="bi bi-eye text-primary me-2"></i>Pratinjau Jadwal Hari Ini</h5>
            </div>
            <div class="admin-card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-success small"><?= htmlspecialchars($schedule['city'] ?? 'Kota Tangerang') ?></span>
                    <small class="text-muted"><?= htmlspecialchars($schedule['source'] ?? '') ?></small>
                </div>

                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="fw-bold">Subuh</span>
                        <strong class="fs-5 text-success"><?= htmlspecialchars($schedule['Fajr']) ?> WIB</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="fw-bold">Terbit / Syuruq</span>
                        <strong class="fs-5 text-muted"><?= htmlspecialchars($schedule['Sunrise']) ?> WIB</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="fw-bold">Dzuhur</span>
                        <strong class="fs-5 text-success"><?= htmlspecialchars($schedule['Dhuhr']) ?> WIB</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="fw-bold">Ashar</span>
                        <strong class="fs-5 text-success"><?= htmlspecialchars($schedule['Asr']) ?> WIB</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="fw-bold">Maghrib</span>
                        <strong class="fs-5 text-success"><?= htmlspecialchars($schedule['Maghrib']) ?> WIB</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="fw-bold">Isya</span>
                        <strong class="fs-5 text-success"><?= htmlspecialchars($schedule['Isha']) ?> WIB</strong>
                    </li>
                </ul>

                <small class="text-muted d-block border-top pt-2">
                    <i class="bi bi-info-circle me-1"></i> Jadwal ini langsung ditampilkan pada widget beranda publik.
                </small>
            </div>
        </div>
    </div>
</div>
