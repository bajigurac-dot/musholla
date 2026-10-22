<!-- Header Galeri -->
<section class="py-5 bg-white border-bottom">
    <div class="container text-center py-4">
        <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">DOKUMENTASI FOTO</span>
        <h1 class="fw-bold mb-2">Galeri Kegiatan & Fasilitas Musholla Ar-rahman</h1>
        <p class="text-muted m-0">Rekam jejak kebersamaan ibadah jamaah dan pemeliharaan sarana musholla</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <!-- Filter Kategori Galeri -->
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
            <a href="<?= Helper::url('galeri') ?>" class="btn btn-sm rounded-pill px-4 fw-bold <?= ($currentCategory === 'Semua') ? 'btn-success text-white' : 'btn-light border' ?>">
                Semua Foto
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?= Helper::url('galeri?kategori=' . urlencode($cat)) ?>" class="btn btn-sm rounded-pill px-4 fw-bold <?= ($currentCategory === $cat) ? 'btn-success text-white' : 'btn-light border' ?>">
                    <?= htmlspecialchars($cat) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($galleries)): ?>
            <div class="gallery-grid">
                <?php foreach ($galleries as $gal): ?>
                    <div class="gallery-item" data-title="<?= htmlspecialchars($gal['title']) ?>">
                        <img src="<?= Helper::uploadUrl($gal['image']) ?>" alt="<?= htmlspecialchars($gal['alt_text'] ?? $gal['title']) ?>" loading="lazy">
                        <div class="gallery-overlay">
                            <span class="badge bg-warning text-dark mb-1 small"><?= htmlspecialchars($gal['category'] ?? 'Kegiatan') ?></span>
                            <h6 class="m-0 text-white fw-bold small"><?= htmlspecialchars($gal['title']) ?></h6>
                            <small class="text-white-50 d-block mt-1"><i class="bi bi-zoom-in me-1"></i> Klik untuk memperbesar</small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-light border text-center p-5 rounded-4 shadow-sm">
                <i class="bi bi-images fs-1 text-muted d-block mb-2"></i>
                <h5 class="fw-bold text-muted">Belum ada foto dalam kategori ini</h5>
                <p class="text-muted small m-0">Pengurus akan segera mengunggah dokumentasi terbaru.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
