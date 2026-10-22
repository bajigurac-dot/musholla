<div class="mb-4">
    <a href="<?= Helper::url('admin/users') ?>" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Akun
    </a>
    <h4 class="fw-bold m-0 mt-1">Tambah Akun Pengurus Baru</h4>
</div>

<div class="admin-card">
    <div class="admin-card-body p-4">
        <form action="<?= Helper::url('admin/users/store') ?>" method="POST">
            <?= Csrf::field() ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label small fw-bold">Nama Lengkap Pengurus <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Ustadz Ahmad Fauzi" required>
                </div>

                <div class="col-md-6">
                    <label for="username" class="form-label small fw-bold">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="huruf kecil tanpa spasi" required>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label small fw-bold">Alamat Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="nama@email.com" required>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label small fw-bold">Kata Sandi (Password) <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter..." required>
                </div>

                <div class="col-md-6">
                    <label for="role" class="form-label small fw-bold">Hak Akses (Role)</label>
                    <select class="form-select" id="role" name="role">
                        <option value="editor">Editor (Hanya Mengelola Konten: Berita, Kegiatan, Galeri)</option>
                        <option value="super_admin">Super Admin (Akses Penuh Seluruh Modul & Manajemen Akun)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="is_active" class="form-label small fw-bold">Status Akun</label>
                    <select class="form-select" id="is_active" name="is_active">
                        <option value="1">Aktif (Dapat Login)</option>
                        <option value="0">Nonaktif (Diblokir)</option>
                    </select>
                </div>

                <div class="col-12 border-top pt-3 d-flex justify-content-end gap-2">
                    <a href="<?= Helper::url('admin/users') ?>" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-save me-1"></i> Simpan Akun Pengurus
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
