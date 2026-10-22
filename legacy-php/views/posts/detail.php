<!-- Detail Berita / Pengumuman -->
<section class="py-5 bg-white border-bottom">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="<?= Helper::url() ?>" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::url('berita') ?>" class="text-decoration-none text-muted">Berita</a></li>
                <li class="breadcrumb-item active text-success fw-bold" aria-current="page"><?= htmlspecialchars(Helper::limitWords($post['title'], 6)) ?></li>
            </ol>
        </nav>
        <span class="badge <?= $post['category'] === 'Pengumuman' ? 'bg-warning-subtle text-warning-emphasis' : 'bg-success-subtle text-success' ?> fw-bold px-3 py-2 rounded-pill mb-2">
            <?= htmlspecialchars($post['category']) ?>
        </span>
        <h1 class="fw-bold mb-3"><?= htmlspecialchars($post['title']) ?></h1>
        <div class="d-flex flex-wrap align-items-center gap-3 text-muted small">
            <span><i class="bi bi-person-circle text-success me-1"></i> Ditulis oleh: <strong><?= htmlspecialchars($post['author'] ?? 'Pengurus DKM') ?></strong></span>
            <span>•</span>
            <span><i class="bi bi-calendar3 me-1"></i> <?= Helper::formatDate($post['created_at'], true) ?></span>
            <span>•</span>
            <span><i class="bi bi-eye me-1"></i> <?= (int)$post['views'] ?> kali dibaca</span>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Kolom Isi Berita -->
            <div class="col-lg-8">
                <article class="bg-white border rounded-4 p-4 shadow-sm mb-4">
                    <?php if (!empty($post['image'])): ?>
                        <img src="<?= Helper::uploadUrl($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="img-fluid rounded-3 mb-4 w-100" style="max-height: 420px; object-fit: cover;">
                    <?php endif; ?>

                    <div class="article-content leading-relaxed text-dark" style="font-size: 1.08rem; line-height: 1.8;">
                        <?= $post['content'] ?>
                    </div>

                    <!-- Bagikan Artikel -->
                    <div class="border-top mt-5 pt-4">
                        <span class="fw-bold d-block mb-2 small text-muted">Bagikan warta ini kepada sesama jamaah:</span>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="https://api.whatsapp.com/send?text=<?= urlencode($post['title'] . " - " . Helper::url('berita/' . $post['slug'])) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-success">
                                <i class="bi bi-whatsapp me-1"></i> WhatsApp
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(Helper::url('berita/' . $post['slug'])) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-primary">
                                <i class="bi bi-facebook me-1"></i> Facebook
                            </a>
                            <button class="btn btn-sm btn-outline-secondary" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan artikel tersalin ke clipboard!');">
                                <i class="bi bi-link-45deg me-1"></i> Salin Tautan
                            </button>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar Berita Terbaru -->
            <div class="col-lg-4">
                <div class="bg-white border rounded-4 p-4 shadow-sm mb-4">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Warta Terbaru Lainnya</h5>
                    <?php if (!empty($recent)): ?>
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($recent as $rec): ?>
                                <?php if ($rec['id'] == $post['id']) continue; ?>
                                <div class="border-bottom pb-3">
                                    <span class="badge <?= $rec['category'] === 'Pengumuman' ? 'bg-warning-subtle text-warning-emphasis' : 'bg-success-subtle text-success' ?> small mb-1" style="font-size:0.7rem;">
                                        <?= htmlspecialchars($rec['category']) ?>
                                    </span>
                                    <h6 class="fw-bold mb-1 small">
                                        <a href="<?= Helper::url('berita/' . $rec['slug']) ?>" class="text-decoration-none text-dark">
                                            <?= htmlspecialchars($rec['title']) ?>
                                        </a>
                                    </h6>
                                    <small class="text-muted"><i class="bi bi-clock me-1"></i><?= date('d M Y', strtotime($rec['created_at'])) ?></small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted small m-0">Belum ada warta lainnya.</p>
                    <?php endif; ?>
                </div>

                <!-- Banner Donasi Singkat di Sidebar -->
                <div class="p-4 rounded-4 text-white text-center shadow-sm" style="background: linear-gradient(135deg, #075B4A 0%, #053E32 100%);">
                    <i class="bi bi-heart-fill fs-2 text-warning mb-2 d-block"></i>
                    <h6 class="fw-bold text-white mb-2">Infaq Operasional Musholla</h6>
                    <p class="text-white-50 small mb-3">Bank BJB: <strong>0152632533100</strong> a/n Musholla Ar-rahman</p>
                    <a href="<?= Helper::url('donasi') ?>" class="btn btn-gold btn-sm fw-bold">Donasi Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</section>
