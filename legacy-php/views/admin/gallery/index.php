<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold m-0">Manajemen Galeri & Foto</h4>
        <small class="text-muted">Kelola dokumentasi kegiatan, fasilitas, dan momen kebersamaan jamaah</small>
    </div>
</div>

<div class="row g-4">
    <!-- Form Unggah Foto Baru -->
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="fw-bold m-0"><i class="bi bi-cloud-arrow-up-fill text-success me-2"></i>Unggah Foto Baru</h5>
            </div>
            <div class="admin-card-body">
                <form action="<?= Helper::url('admin/gallery/upload') ?>" method="POST" enctype="multipart/form-data">
                    <?= Csrf::field() ?>

                    <div class="mb-3">
                        <label for="image" class="form-label small fw-bold">Pilih File Foto <span class="text-danger">*</span></label>
                        <input type="file" class="form-control form-control-sm" id="image" name="image" accept="image/*" required data-preview="preview-gallery">
                        <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP (Maks 8MB)</small>
                        <img id="preview-gallery" src="" alt="Preview" class="img-fluid rounded border mt-2 w-100" style="display:none; max-height: 160px; object-fit: cover;">
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label small fw-bold">Judul / Keterangan Foto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="Contoh: Jamaah Sholat Isya Berjamaah" required>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label small fw-bold">Kategori</label>
                        <select class="form-select form-select-sm" id="category" name="category">
                            <option value="Kegiatan">Kegiatan</option>
                            <option value="Ibadah">Ibadah</option>
                            <option value="Kajian">Kajian & Yasinan</option>
                            <option value="Fasilitas">Fasilitas Musholla</option>
                            <option value="Sosial">Sosial & Gotong Royong</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="alt_text" class="form-label small fw-bold">Teks Alternatif (Aksesibilitas / SEO)</label>
                        <input type="text" class="form-control form-control-sm" id="alt_text" name="alt_text" placeholder="Deskripsi singkat foto...">
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="bi bi-upload me-1"></i> Unggah ke Galeri
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Koleksi Foto Galeri -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5 class="fw-bold m-0"><i class="bi bi-images text-primary me-2"></i>Daftar Foto Dokumentasi</h5>
                <span class="badge bg-light text-dark border"><?= count($galleries) ?> Foto</span>
            </div>
            <div class="admin-card-body">
                <?php if (!empty($galleries)): ?>
                    <div class="row g-3">
                        <?php foreach ($galleries as $gal): ?>
                            <div class="col-sm-6 col-md-4">
                                <div class="border rounded-3 overflow-hidden shadow-sm h-100 d-flex flex-direction-column">
                                    <div class="position-relative" style="height: 150px;">
                                        <img src="<?= Helper::uploadUrl($gal['image']) ?>" alt="<?= htmlspecialchars($gal['title']) ?>" class="w-100 h-100 object-fit-cover">
                                        <span class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 small">
                                            <?= htmlspecialchars($gal['category']) ?>
                                        </span>
                                    </div>
                                    <div class="p-2 flex-grow-1 d-flex flex-column justify-content-between">
                                        <strong class="d-block text-dark small mb-2 text-truncate" title="<?= htmlspecialchars($gal['title']) ?>">
                                            <?= htmlspecialchars($gal['title']) ?>
                                        </strong>
                                        <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                            <small class="text-muted" style="font-size:0.75rem;"><?= date('d/m/Y', strtotime($gal['created_at'])) ?></small>
                                            <div class="d-flex gap-1">
                                                <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2" data-bs-toggle="modal" data-bs-target="#editGalleryModal<?= $gal['id'] ?>" title="Edit Keterangan">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <form action="<?= Helper::url('admin/gallery/delete/' . $gal['id']) ?>" method="POST" class="d-inline">
                                                    <?= Csrf::field() ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2 btn-delete-confirm" data-title="<?= htmlspecialchars($gal['title']) ?>" title="Hapus Foto">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Edit Keterangan Foto -->
                                <div class="modal fade" id="editGalleryModal<?= $gal['id'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="<?= Helper::url('admin/gallery/update/' . $gal['id']) ?>" method="POST">
                                                <?= Csrf::field() ?>
                                                <div class="modal-header">
                                                    <h6 class="modal-title fw-bold"><i class="bi bi-pencil-square me-1 text-primary"></i> Edit Keterangan Foto</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center mb-3">
                                                        <img src="<?= Helper::uploadUrl($gal['image']) ?>" alt="Foto" class="img-fluid rounded border shadow-sm" style="max-height: 140px; object-fit: cover;">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Judul / Keterangan Foto <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($gal['title']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Kategori</label>
                                                        <select class="form-select" name="category">
                                                            <?php foreach (['Kegiatan', 'Ibadah', 'Kajian', 'Fasilitas', 'Sosial'] as $c): ?>
                                                                <option value="<?= $c ?>" <?= ($gal['category'] === $c) ? 'selected' : '' ?>><?= $c ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-0">
                                                        <label class="form-label small fw-bold">Teks Alternatif (Alt Text)</label>
                                                        <input type="text" class="form-control" name="alt_text" value="<?= htmlspecialchars($gal['alt_text'] ?? '') ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-sm btn-primary-custom">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-images fs-1 text-muted d-block mb-2"></i>
                        <p class="text-muted m-0">Belum ada foto yang diunggah.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
