<!-- Header Halaman Kegiatan -->
<section class="py-5 bg-white border-bottom">
    <div class="container text-center py-4">
        <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">SYIAR & IBADAH</span>
        <h1 class="fw-bold mb-2">Agenda Kegiatan Musholla Ar-rahman</h1>
        <p class="text-muted m-0">Jadwal sholat berjamaah, yasinan malam Jum'at, dan pengajian rutin bulanan warga</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <!-- Tab Filter: Mendatang vs Selesai -->
        <div class="d-flex justify-content-center mb-4">
            <div class="btn-group p-1 bg-white border rounded-pill shadow-sm" role="group">
                <a href="<?= Helper::url('kegiatan?tab=upcoming') ?>" class="btn rounded-pill px-4 fw-bold <?= ($tab === 'upcoming') ? 'btn-success text-white' : 'btn-light text-muted' ?>">
                    <i class="bi bi-calendar-event me-1"></i> Kegiatan Mendatang
                </a>
                <a href="<?= Helper::url('kegiatan?tab=past') ?>" class="btn rounded-pill px-4 fw-bold <?= ($tab === 'past') ? 'btn-success text-white' : 'btn-light text-muted' ?>">
                    <i class="bi bi-archive me-1"></i> Arsip Kegiatan Lampau
                </a>
            </div>
        </div>

        <?php if (!empty($events)): ?>
            <div class="row g-4">
                <?php foreach ($events as $evt): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="custom-card">
                            <img src="<?= Helper::uploadUrl($evt['image']) ?>" alt="<?= htmlspecialchars($evt['title']) ?>" class="custom-card-img">
                            <div class="custom-card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="card-badge card-badge-kegiatan"><?= htmlspecialchars($evt['category'] ?? 'Rutin') ?></span>
                                    <span class="badge <?= $evt['status'] === 'Mendatang' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= htmlspecialchars($evt['status']) ?>
                                    </span>
                                </div>
                                <h5 class="fw-bold fs-6 mb-2">
                                    <a href="<?= Helper::url('kegiatan/' . $evt['slug']) ?>" class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($evt['title']) ?>
                                    </a>
                                </h5>
                                <div class="small text-muted mb-2">
                                    <div class="d-flex align-items-center gap-1 mb-1">
                                        <i class="bi bi-calendar3 text-success"></i>
                                        <span><?= Helper::formatDate($evt['event_date']) ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 mb-1">
                                        <i class="bi bi-clock text-warning"></i>
                                        <span>Pukul <?= htmlspecialchars($evt['start_time']) ?> - <?= htmlspecialchars($evt['end_time']) ?> WIB</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <i class="bi bi-geo-alt text-danger"></i>
                                        <span><?= htmlspecialchars($evt['location'] ?? 'Musholla Ar-rahman') ?></span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3 flex-grow-1">
                                    <?= htmlspecialchars(Helper::limitWords($evt['description'], 18)) ?>
                                </p>
                                <div class="border-top pt-2 text-end">
                                    <a href="<?= Helper::url('kegiatan/' . $evt['slug']) ?>" class="btn btn-sm btn-outline-success fw-bold">
                                        Lihat Rincian <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-light border text-center p-5 rounded-4 shadow-sm">
                <i class="bi bi-calendar-x fs-1 text-muted d-block mb-2"></i>
                <h5 class="fw-bold text-muted">Belum ada kegiatan pada daftar ini</h5>
                <p class="text-muted small m-0">Silakan periksa kembali pada kategori tab lainnya.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
