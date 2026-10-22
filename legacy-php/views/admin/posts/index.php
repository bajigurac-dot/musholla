<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold m-0">Kelola Berita & Pengumuman</h4>
        <small class="text-muted">Kelola seluruh warta dan informasi publik musholla</small>
    </div>
    <a href="<?= Helper::url('admin/posts/create') ?>" class="btn btn-primary-custom">
        <i class="bi bi-plus-circle me-1"></i> Tambah Artikel Baru
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <form action="<?= Helper::url('admin/posts') ?>" method="GET" class="row g-2 w-100 align-items-center">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari judul artikel..." value="<?= htmlspecialchars($search ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <option value="Berita" <?= ($category === 'Berita') ? 'selected' : '' ?>>Berita</option>
                    <option value="Pengumuman" <?= ($category === 'Pengumuman') ? 'selected' : '' ?>>Pengumuman</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Terbit" <?= ($status === 'Terbit') ? 'selected' : '' ?>>Terbit</option>
                    <option value="Draft" <?= ($status === 'Draft') ? 'selected' : '' ?>>Draft</option>
                </select>
            </div>
            <div class="col-md-2 text-end">
                <button type="submit" class="btn btn-sm btn-success w-100"><i class="bi bi-filter me-1"></i> Filter</button>
            </div>
        </form>
    </div>

    <div class="admin-card-body p-0">
        <?php if (!empty($posts)): ?>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th style="width: 70px;">Foto</th>
                            <th>Judul & Ringkasan</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th style="width: 140px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $p): ?>
                            <tr>
                                <td>
                                    <img src="<?= Helper::uploadUrl($p['image']) ?>" alt="Thumb" class="rounded object-fit-cover" width="55" height="42">
                                </td>
                                <td>
                                    <strong class="d-block text-dark"><?= htmlspecialchars($p['title']) ?></strong>
                                    <small class="text-muted"><?= htmlspecialchars(Helper::limitWords($p['excerpt'], 10)) ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?= htmlspecialchars($p['category']) ?></span>
                                </td>
                                <td class="small"><?= htmlspecialchars($p['author'] ?? 'DKM') ?></td>
                                <td>
                                    <span class="badge <?= $p['status'] === 'Terbit' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= htmlspecialchars($p['status']) ?>
                                    </span>
                                </td>
                                <td class="small text-muted"><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <?php if ($p['status'] === 'Terbit'): ?>
                                            <a href="<?= Helper::url('berita/' . $p['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Lihat di Web">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= Helper::url('admin/posts/edit/' . $p['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?= Helper::url('admin/posts/delete/' . $p['id']) ?>" method="POST" class="d-inline">
                                            <?= Csrf::field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm" data-title="<?= htmlspecialchars($p['title']) ?>" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-3">
                <?php require ROOT_PATH . '/views/partials/pagination.php'; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-newspaper fs-1 text-muted d-block mb-2"></i>
                <p class="text-muted m-0">Tidak ada artikel yang sesuai kriteria.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
