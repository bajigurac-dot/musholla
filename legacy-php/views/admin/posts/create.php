<div class="mb-4">
    <a href="<?= Helper::url('admin/posts') ?>" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Berita
    </a>
    <h4 class="fw-bold m-0 mt-1">Tulis Berita / Pengumuman Baru</h4>
</div>

<div class="admin-card">
    <div class="admin-card-body p-4">
        <form action="<?= Helper::url('admin/posts/store') ?>" method="POST" enctype="multipart/form-data">
            <?= Csrf::field() ?>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label for="title" class="form-label small fw-bold">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul berita yang menarik..." required>
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label small fw-bold">Ringkasan Singkat (Lead / Excerpt)</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="2" placeholder="Ringkasan 1-2 kalimat yang tampil di kartu warta..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label small fw-bold">Konten / Isi Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="content" name="content" rows="12" placeholder="Tuliskan isi berita di sini (mendukung tag HTML sederhana seperti <p>, <strong>, <ul>)..." required></textarea>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <h6 class="fw-bold mb-3">Publikasi</h6>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label small fw-bold">Kategori</label>
                            <select class="form-select form-select-sm" id="category" name="category">
                                <option value="Berita">Berita</option>
                                <option value="Pengumuman">Pengumuman</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label small fw-bold">Status Tayang</label>
                            <select class="form-select form-select-sm" id="status" name="status">
                                <option value="Terbit">Terbit (Publik)</option>
                                <option value="Draft">Draft (Simpan Saja)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label small fw-bold">Nama Penulis</label>
                            <input type="text" class="form-control form-control-sm" id="author" name="author" value="<?= htmlspecialchars(Auth::user()['name'] ?? 'Pengurus DKM') ?>">
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 border">
                        <h6 class="fw-bold mb-2">Foto Utama</h6>
                        <input type="file" class="form-control form-control-sm mb-2" id="image" name="image" accept="image/*" data-preview="preview-img">
                        <small class="text-muted d-block mb-2">Format: JPG, PNG, WEBP (Maks 8MB)</small>
                        <img id="preview-img" src="" alt="Preview" class="img-fluid rounded border shadow-sm w-100" style="display:none; max-height: 180px; object-fit: cover;">
                    </div>
                </div>

                <div class="col-12 border-top pt-3 d-flex justify-content-end gap-2">
                    <a href="<?= Helper::url('admin/posts') ?>" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-check-circle me-1"></i> Simpan & Terbitkan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
