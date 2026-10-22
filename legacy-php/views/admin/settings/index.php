<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold m-0">Pengaturan Profil Musholla & Website</h4>
        <small class="text-muted">Kelola identitas, alamat, kontak DKM, sejarah, dan konfigurasi umum</small>
    </div>
</div>

<form action="<?= Helper::url('admin/settings/update') ?>" method="POST" enctype="multipart/form-data">
    <?= Csrf::field() ?>

    <div class="row g-4">
        <!-- Kolom Kiri: Identitas & Sejarah -->
        <div class="col-lg-7">
            <!-- Kartu Identitas Umum -->
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="fw-bold m-0"><i class="bi bi-building-check text-success me-2"></i>Identitas Musholla</h5>
                </div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label for="mushola_name" class="form-label small fw-bold">Nama Resmi Musholla <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mushola_name" name="mushola_name" value="<?= htmlspecialchars($settings['mushola_name'] ?? 'Musholla Ar-rahman') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="tagline" class="form-label small fw-bold">Tagline / Slogan</label>
                        <input type="text" class="form-control" id="tagline" name="tagline" value="<?= htmlspecialchars($settings['tagline'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="history" class="form-label small fw-bold">Sejarah Berdiri (Tahun 1990 Gotong Royong)</label>
                        <textarea class="form-control" id="history" name="history" rows="4"><?= htmlspecialchars($settings['history'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="vision" class="form-label small fw-bold">Visi Musholla</label>
                        <textarea class="form-control" id="vision" name="vision" rows="2"><?= htmlspecialchars($settings['vision'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="mission" class="form-label small fw-bold">Misi Musholla (Pisahkan dengan baris baru)</label>
                        <textarea class="form-control" id="mission" name="mission" rows="5"><?= htmlspecialchars($settings['mission'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-0">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="facilities" class="form-label small fw-bold m-0">Fasilitas Tempat Ibadah</label>
                            <span class="badge bg-success-subtle text-success small"><i class="bi bi-info-circle me-1"></i>Pisahkan dengan tanda koma (,)</span>
                        </div>
                        <textarea class="form-control mb-2" id="facilities" name="facilities" rows="3" placeholder="Contoh: Ruang Sholat Ber-AC, Tempat Wudhu Bersih, Karpet Sholat Nyaman, Sound System Berkualitas..."><?= htmlspecialchars($settings['facilities'] ?? '') ?></textarea>
                        <small class="text-muted d-block mb-2">
                            <i class="bi bi-lightbulb text-warning me-1"></i> <strong>Cara Menambah Fasilitas:</strong> Cukup ketik fasilitas baru di dalam kotak di atas dengan pemisah tanda koma. Fasilitas baru akan otomatis muncul di halaman <a href="<?= Helper::url('profil') ?>" target="_blank" class="fw-bold text-success text-decoration-none">Profil Musholla</a>.
                        </small>
                        <?php if (!empty($settings['facilities'])): ?>
                            <div class="p-2 bg-light rounded-3 border">
                                <small class="text-muted d-block mb-1 fw-bold" style="font-size: 0.75rem;">Pratinjau Fasilitas Saat Ini:</small>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php 
                                    foreach (explode(',', $settings['facilities']) as $fac): 
                                        $trimmed = trim($fac);
                                        if (empty($trimmed)) continue;
                                    ?>
                                        <span class="badge bg-white text-dark border shadow-sm py-1 px-2 fw-semibold" style="font-size: 0.78rem;">
                                            <i class="bi bi-check-circle-fill text-success me-1"></i><?= htmlspecialchars($trimmed) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Kartu Susunan DKM -->
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="fw-bold m-0"><i class="bi bi-people-fill text-primary me-2"></i>Susunan Pengurus DKM</h5>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="dkm_lead" class="form-label small fw-bold">Ketua DKM</label>
                            <input type="text" class="form-control" id="dkm_lead" name="dkm_lead" value="<?= htmlspecialchars($settings['dkm_lead'] ?? 'USTADZ TATA A.S') ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="dkm_treasurer" class="form-label small fw-bold">Bendahara DKM</label>
                            <input type="text" class="form-control" id="dkm_treasurer" name="dkm_treasurer" value="<?= htmlspecialchars($settings['dkm_treasurer'] ?? 'Bapak Suwadi') ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="dkm_secretary" class="form-label small fw-bold">Sekretaris DKM</label>
                            <input type="text" class="form-control" id="dkm_secretary" name="dkm_secretary" value="<?= htmlspecialchars($settings['dkm_secretary'] ?? 'Bapak Bakri') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Alamat, Kontak, Logo & Modul -->
        <div class="col-lg-5">
            <!-- Kartu Kontak & Alamat -->
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="fw-bold m-0"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Alamat & Kontak Pengurus</h5>
                </div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label for="address" class="form-label small fw-bold">Alamat Lengkap</label>
                        <textarea class="form-control" id="address" name="address" rows="3"><?= htmlspecialchars($settings['address'] ?? '') ?></textarea>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="phone_1" class="form-label small fw-bold">WhatsApp Kontak 1</label>
                            <input type="text" class="form-control" id="phone_1" name="phone_1" value="<?= htmlspecialchars($settings['phone_1'] ?? '0813-8619-8079') ?>">
                        </div>
                        <div class="col-6">
                            <label for="phone_2" class="form-label small fw-bold">WhatsApp Kontak 2</label>
                            <input type="text" class="form-control" id="phone_2" name="phone_2" value="<?= htmlspecialchars($settings['phone_2'] ?? '0812-9465-6075') ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold">Email DKM</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($settings['email'] ?? 'dkm.musholla.arrahman@gmail.com') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="maps_url" class="form-label small fw-bold">Tautan Google Maps</label>
                        <input type="text" class="form-control" id="maps_url" name="maps_url" value="<?= htmlspecialchars($settings['maps_url'] ?? 'https://maps.app.goo.gl/JZzSrDEKjCseGwgw7?g_st=aw') ?>">
                    </div>

                    <div class="mb-0">
                        <label for="maps_embed" class="form-label small fw-bold">Embed URL Google Maps (Iframe Src)</label>
                        <input type="text" class="form-control" id="maps_embed" name="maps_embed" value="<?= htmlspecialchars($settings['maps_embed'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <!-- Kartu Logo & Media -->
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="fw-bold m-0"><i class="bi bi-image text-warning me-2"></i>Logo & Banner Hero</h5>
                </div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Logo Musholla</label>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <img src="<?= !empty($settings['logo_image']) ? Helper::uploadUrl($settings['logo_image']) : Helper::asset('images/default-logo.svg') ?>" alt="Logo" class="rounded-circle border" width="60" height="60">
                            <div>
                                <input type="file" class="form-control form-control-sm" name="logo_image" accept="image/*">
                                <small class="text-muted">Kosongkan jika tetap memakai logo default</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold">Ganti Banner Hero Beranda</label>
                        <input type="file" class="form-control form-control-sm" name="hero_image" accept="image/*">
                        <small class="text-muted">Maksimal 8MB (JPG, PNG, WEBP)</small>
                    </div>
                </div>
            </div>

            <!-- Kartu Pengaturan Modul -->
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="fw-bold m-0"><i class="bi bi-toggles text-info me-2"></i>Status Modul Website</h5>
                </div>
                <div class="admin-card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="donation_active" name="donation_active" value="1" <?= ($settings['donation_active'] ?? '1') === '1' ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold small" for="donation_active">Aktifkan Modul Donasi & Infaq Publik</label>
                    </div>

                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch" id="finance_active" name="finance_active" value="1" <?= ($settings['finance_active'] ?? '1') === '1' ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold small" for="finance_active">Aktifkan Modul Laporan Kas Keuangan Publik</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold shadow-sm">
                <i class="bi bi-save me-1"></i> Simpan Semua Pengaturan
            </button>
        </div>
    </div>
</form>
