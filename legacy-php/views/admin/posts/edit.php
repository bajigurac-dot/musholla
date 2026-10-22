<div class="mb-4">
    <a href="<?= Helper::url('admin/posts') ?>" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Berita
    </a>
    <h4 class="fw-bold m-0 mt-1">Edit Berita / Pengumuman</h4>
</div>

<div class="admin-card">
    <div class="admin-card-body p-4">
        <form action="<?= Helper::url('admin/posts/update/' . $post['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= Csrf::field() ?>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label for="title" class="form-label small fw-bold">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label small fw-bold">Ringkasan Singkat (Lead / Excerpt)</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="2"><?= htmlspecialchars($post['excerpt'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label small fw-bold">Konten / Isi Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="content" name="content" rows="12" required><?= htmlspecialchars($post['content']) ?></textarea>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <h6 class="fw-bold mb-3">Publikasi</h6>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label small fw-bold">Kategori</label>
                            <select class="form-select form-select-sm" id="category" name="category">
                                <option value="Berita" <?= ($post['category'] === 'Berita') ? 'selected' : '' ?>>Berita</option>
                                <option value="Pengumuman" <?= ($post['category'] === 'Pengumuman') ? 'selected' : '' ?>>Pengumuman</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label small fw-bold">Status Tayang</label>
                            <select class="form-select form-select-sm" id="status" name="status">
                                <option value="Terbit" <?= ($post['status'] === 'Terbit') ? 'selected' : '' ?>>Terbit (Publik)</option>
                                <option value="Draft" <?= ($post['status'] === 'Draft') ? 'selected' : '' ?>>Draft (Simpan Saja)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label small fw-bold">Nama Penulis</label>
                            <input type="text" class="form-control form-control-sm" id="author" name="author" value="<?= htmlspecialchars($post['author'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 border">
                        <h6 class="fw-bold mb-2">Foto Utama</h6>
                        <?php if (!empty($post['image'])): ?>
                            <div class="mb-2">
                                <small class="text-muted d-block mb-1">Foto saat ini:</small>
                                <img src="<?= Helper::uploadUrl($post['image']) ?>" alt="Foto" class="img-fluid rounded border mb-2 w-100" style="max-height: 140px; object-fit: cover;">
                            </div>
                        <?php endif; ?>
                        <label class="form-label small text-muted">Ganti foto (kosongkan jika tidak diubah):</label>
                        <input type="file" class="form-control form-control-sm mb-1" id="image" name="image" accept="image/*" data-preview="preview-img-edit">
                        <small class="text-muted d-block mb-2">Format: JPG, PNG, WEBP (Maks 8MB)</small>
                        <img id="preview-img-edit" src="" alt="Preview Baru" class="img-fluid rounded border shadow-sm w-100" style="display:none; max-height: 140px; object-fit: cover;">
                    </div>
                </div>

                <div class="col-12 border-top pt-3 d-flex justify-content-end gap-2">
                    <a href="<?= Helper::url('admin/posts') ?>" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
