<!-- Header Berita & Pengumuman -->
<section class="py-5 bg-white border-bottom">
    <div class="container text-center py-4">
        <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">WARTA & INFORMASI</span>
        <h1 class="fw-bold mb-2">Berita & Pengumuman Musholla Ar-rahman</h1>
        <p class="text-muted m-0">Informasi terpercaya seputar kegiatan keumatan, kajian, dan pengumuman DKM</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <!-- Pencarian & Filter Kategori -->
        <div class="row g-3 align-items-center mb-4">
            <div class="col-md-6">
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?= Helper::url('berita') ?>" class="btn btn-sm rounded-pill px-3 fw-bold <?= empty($category) ? 'btn-success' : 'btn-light border' ?>">
                        Semua Kategori
                    </a>
                    <a href="<?= Helper::url('berita?kategori=Berita' . (!empty($search) ? '&q=' . urlencode($search) : '')) ?>" class="btn btn-sm rounded-pill px-3 fw-bold <?= ($category === 'Berita') ? 'btn-success' : 'btn-light border' ?>">
                        Berita
                    </a>
                    <a href="<?= Helper::url('berita?kategori=Pengumuman' . (!empty($search) ? '&q=' . urlencode($search) : '')) ?>" class="btn btn-sm rounded-pill px-3 fw-bold <?= ($category === 'Pengumuman') ? 'btn-success' : 'btn-light border' ?>">
                        Pengumuman
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <form action="<?= Helper::url('berita') ?>" method="GET" class="d-flex gap-2">
                    <?php if (!empty($category)): ?>
                        <input type="hidden" name="kategori" value="<?= htmlspecialchars($category) ?>">
                    <?php endif; ?>
                    <input type="text" name="q" class="form-control form-control-sm rounded-pill px-3" placeholder="Cari berita atau pengumuman..." value="<?= htmlspecialchars($search ?? '') ?>">
                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                        <i class="bi bi-search"></i>
                    </button>
                    <?php if (!empty($search)): ?>
                        <a href="<?= Helper::url('berita' . (!empty($category) ? '?kategori=' . urlencode($category) : '')) ?>" class="btn btn-sm btn-outline-secondary rounded-pill">
                            Reset
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Daftar Berita -->
        <?php if (!empty($posts)): ?>
            <div class="row g-4">
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="custom-card">
                            <img src="<?= Helper::uploadUrl($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="custom-card-img">
                            <div class="custom-card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="card-badge <?= $post['category'] === 'Pengumuman' ? 'card-badge-pengumuman' : 'card-badge-berita' ?>">
                                        <?= htmlspecialchars($post['category']) ?>
                                    </span>
                                    <small class="text-muted"><i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($post['created_at'])) ?></small>
                                </div>
                                <h5 class="fw-bold fs-6 mb-2">
                                    <a href="<?= Helper::url('berita/' . $post['slug']) ?>" class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($post['title']) ?>
                                    </a>
                                </h5>
                                <p class="text-muted small mb-3 flex-grow-1">
                                    <?= htmlspecialchars($post['excerpt'] ?? Helper::limitWords($post['content'], 20)) ?>
                                </p>
                                <div class="border-top pt-2 d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><i class="bi bi-person me-1"></i><?= htmlspecialchars($post['author'] ?? 'DKM') ?></small>
                                    <a href="<?= Helper::url('berita/' . $post['slug']) ?>" class="text-success fw-bold small text-decoration-none">
                                        Baca <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Navigasi Halaman -->
            <?php require ROOT_PATH . '/views/partials/pagination.php'; ?>
        <?php else: ?>
            <div class="alert alert-light border text-center p-5 rounded-4 shadow-sm">
                <i class="bi bi-search fs-1 text-muted d-block mb-2"></i>
                <h5 class="fw-bold text-muted">Tidak ada artikel yang ditemukan</h5>
                <p class="text-muted small m-0">Coba gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
