<div class="mb-4">
    <a href="<?= Helper::url('admin/events') ?>" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Agenda Kegiatan
    </a>
    <h4 class="fw-bold m-0 mt-1">Edit Agenda Kegiatan</h4>
</div>

<div class="admin-card">
    <div class="admin-card-body p-4">
        <form action="<?= Helper::url('admin/events/update/' . $event['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= Csrf::field() ?>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label for="title" class="form-label small fw-bold">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($event['title']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label small fw-bold">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="8" required><?= htmlspecialchars($event['description']) ?></textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="location" class="form-label small fw-bold">Tempat / Lokasi</label>
                            <input type="text" class="form-control" id="location" name="location" value="<?= htmlspecialchars($event['location'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label small fw-bold">Kategori Kegiatan</label>
                            <select class="form-select" id="category" name="category">
                                <?php
                                $categories = ['Ibadah Harian', 'Mingguan', 'Bulanan', 'Pendidikan', 'Sosial', 'PHBI'];
                                foreach ($categories as $cat):
                                ?>
                                    <option value="<?= $cat ?>" <?= ($event['category'] === $cat) ? 'selected' : '' ?>><?= $cat ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <h6 class="fw-bold mb-3">Waktu & Jadwal</h6>

                        <div class="mb-3">
                            <label for="event_date" class="form-label small fw-bold">Tanggal Kegiatan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" id="event_date" name="event_date" value="<?= htmlspecialchars($event['event_date']) ?>" required>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label for="start_time" class="form-label small fw-bold">Jam Mulai</label>
                                <input type="text" class="form-control form-control-sm" id="start_time" name="start_time" value="<?= htmlspecialchars($event['start_time']) ?>">
                            </div>
                            <div class="col-6">
                                <label for="end_time" class="form-label small fw-bold">Jam Selesai</label>
                                <input type="text" class="form-control form-control-sm" id="end_time" name="end_time" value="<?= htmlspecialchars($event['end_time']) ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label small fw-bold">Status</label>
                            <select class="form-select form-select-sm" id="status" name="status">
                                <option value="Mendatang" <?= ($event['status'] === 'Mendatang') ? 'selected' : '' ?>>Mendatang</option>
                                <option value="Selesai" <?= ($event['status'] === 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                                <option value="Dibatalkan" <?= ($event['status'] === 'Dibatalkan') ? 'selected' : '' ?>>Dibatalkan</option>
                            </select>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 border">
                        <h6 class="fw-bold mb-2">Foto / Pamflet</h6>
                        <?php if (!empty($event['image'])): ?>
                            <div class="mb-2">
                                <small class="text-muted d-block mb-1">Foto saat ini:</small>
                                <img src="<?= Helper::uploadUrl($event['image']) ?>" alt="Foto" class="img-fluid rounded border mb-2 w-100" style="max-height: 140px; object-fit: cover;">
                            </div>
                        <?php endif; ?>
                        <label class="form-label small text-muted">Ganti foto (kosongkan jika tidak diubah):</label>
                        <input type="file" class="form-control form-control-sm mb-1" id="image" name="image" accept="image/*" data-preview="preview-evt-edit">
                        <small class="text-muted d-block mb-2">Format: JPG, PNG, WEBP (Maks 8MB)</small>
                        <img id="preview-evt-edit" src="" alt="Preview Baru" class="img-fluid rounded border shadow-sm w-100" style="display:none; max-height: 140px; object-fit: cover;">
                    </div>
                </div>

                <div class="col-12 border-top pt-3 d-flex justify-content-end gap-2">
                    <a href="<?= Helper::url('admin/events') ?>" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
