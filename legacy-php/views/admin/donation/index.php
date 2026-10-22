<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold m-0">Pengaturan Donasi & Rekening Infaq</h4>
        <small class="text-muted">Kelola rekening Bank BJB, gambar QRIS, dan panduan donasi bagi jamaah</small>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="fw-bold m-0"><i class="bi bi-wallet2 text-success me-2"></i>Rekening Resmi Musholla</h5>
            </div>
            <div class="admin-card-body p-4">
                <form action="<?= Helper::url('admin/donation/update') ?>" method="POST" enctype="multipart/form-data">
                    <?= Csrf::field() ?>

                    <div class="form-check form-switch mb-4 p-3 bg-light rounded-3 border">
                        <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="donation_active" name="donation_active" value="1" <?= ($settings['donation_active'] ?? '1') === '1' ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold" for="donation_active">
                            Aktifkan Tampilan Donasi di Website Publik
                        </label>
                        <small class="text-muted d-block mt-1">Jika dinonaktifkan, menu dan tombol donasi tidak dapat diakses jamaah.</small>
                    </div>

                    <div class="mb-3">
                        <label for="donation_bank" class="form-label small fw-bold">Nama Bank <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="donation_bank" name="donation_bank" value="<?= htmlspecialchars($settings['donation_bank'] ?? 'Bank BJB') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="donation_account" class="form-label small fw-bold">Nomor Rekening Resmi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="donation_account" name="donation_account" value="<?= htmlspecialchars($settings['donation_account'] ?? '0152632533100') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="donation_holder" class="form-label small fw-bold">Atas Nama Rekening <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="donation_holder" name="donation_holder" value="<?= htmlspecialchars($settings['donation_holder'] ?? 'Musholla Ar-rahman') ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="donation_notes" class="form-label small fw-bold">Petunjuk & Pesan Konfirmasi Donasi</label>
                        <textarea class="form-control" id="donation_notes" name="donation_notes" rows="4"><?= htmlspecialchars($settings['donation_notes'] ?? '') ?></textarea>
                    </div>

                    <div class="p-3 bg-light rounded-3 border mb-4">
                        <h6 class="fw-bold mb-2">Unggah Gambar QRIS Resmi</h6>
                        <input type="file" class="form-control form-control-sm mb-2" id="qris_image" name="qris_image" accept="image/*" data-preview="preview-qris-admin">
                        <small class="text-muted d-block">Unggah barcode QRIS resmi dari pengurus jika ada. Format JPG/PNG/WEBP.</small>
                    </div>

                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-save me-1"></i> Simpan Pengaturan Donasi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Pratinjau Tampilan Donasi -->
    <div class="col-lg-5">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="fw-bold m-0"><i class="bi bi-qr-code text-warning me-2"></i>QRIS Saat Ini</h5>
            </div>
            <div class="admin-card-body p-4 text-center">
                <img id="preview-qris-admin" src="<?= !empty($settings['qris_image']) ? Helper::uploadUrl($settings['qris_image']) : Helper::asset('images/default-qris.svg') ?>" alt="QRIS" class="img-fluid rounded border shadow-sm p-2 bg-white mb-3" style="max-width: 260px;">
                <p class="text-muted small m-0">Gambar QRIS ini tampil di halaman publik dan kartu infaq beranda.</p>
            </div>
        </div>
    </div>
</div>
