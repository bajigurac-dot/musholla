<!-- Row Statistik Cepat -->
<div class="row g-3 mb-4">
    <!-- Berita -->
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-newspaper"></i>
            </div>
            <div class="stat-info">
                <h3><?= (int)$stats['published_posts'] ?> <small class="fs-6 text-muted fw-normal">/ <?= (int)$stats['total_posts'] ?></small></h3>
                <p>Warta Terbit / Total</p>
            </div>
        </div>
    </div>

    <!-- Kegiatan Mendatang -->
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon gold">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div class="stat-info">
                <h3><?= (int)$stats['upcoming_events'] ?></h3>
                <p>Agenda Mendatang</p>
            </div>
        </div>
    </div>

    <!-- Foto Galeri -->
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-images"></i>
            </div>
            <div class="stat-info">
                <h3><?= (int)$stats['total_galleries'] ?></h3>
                <p>Dokumentasi Foto</p>
            </div>
        </div>
    </div>

    <!-- Pesan Masuk -->
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="bi bi-chat-dots"></i>
            </div>
            <div class="stat-info">
                <h3><?= (int)$stats['unread_messages'] ?></h3>
                <p>Pesan Jamaah Baru</p>
            </div>
        </div>
    </div>
</div>

<!-- Shortcut Aksi Cepat -->
<div class="admin-card mb-4">
    <div class="admin-card-body p-3">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <span class="fw-bold small text-muted me-2"><i class="bi bi-lightning-charge-fill text-warning"></i> Aksi Cepat:</span>
            <a href="<?= Helper::url('admin/posts/create') ?>" class="btn btn-sm btn-outline-success">
                <i class="bi bi-plus-circle me-1"></i> Tulis Berita
            </a>
            <a href="<?= Helper::url('admin/events/create') ?>" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-calendar-plus me-1"></i> Tambah Kegiatan
            </a>
            <a href="<?= Helper::url('admin/gallery') ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-upload me-1"></i> Unggah Galeri
            </a>
            <a href="<?= Helper::url('admin/finance/create') ?>" class="btn btn-sm btn-outline-warning text-dark">
                <i class="bi bi-cash-stack me-1"></i> Catat Kas
            </a>
            <a href="<?= Helper::url('admin/settings') ?>" class="btn btn-sm btn-light border ms-auto">
                <i class="bi bi-gear me-1"></i> Edit Profil Musholla
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Kolom Kiri: Kegiatan Terdekat -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5 class="fw-bold"><i class="bi bi-calendar3 text-success me-2"></i>Agenda Kegiatan Terdekat</h5>
                <a href="<?= Helper::url('admin/events') ?>" class="btn btn-sm btn-link text-decoration-none">Kelola Semua</a>
            </div>
            <div class="admin-card-body p-0">
                <?php if (!empty($upcomingEvents)): ?>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Kegiatan</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($upcomingEvents as $evt): ?>
                                    <tr>
                                        <td class="fw-bold text-dark"><?= htmlspecialchars($evt['title']) ?></td>
                                        <td><?= date('d M Y', strtotime($evt['event_date'])) ?></td>
                                        <td><?= htmlspecialchars($evt['start_time']) ?> WIB</td>
                                        <td>
                                            <a href="<?= Helper::url('admin/events/edit/' . $evt['id']) ?>" class="btn btn-sm btn-outline-primary py-0 px-2">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4 m-0 small">Belum ada agenda kegiatan mendatang.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Berita Terbaru -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5 class="fw-bold"><i class="bi bi-newspaper text-primary me-2"></i>Warta & Pengumuman Terakhir</h5>
                <a href="<?= Helper::url('admin/posts') ?>" class="btn btn-sm btn-link text-decoration-none">Kelola Semua</a>
            </div>
            <div class="admin-card-body p-0">
                <?php if (!empty($recentPosts)): ?>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Judul Warta</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentPosts as $p): ?>
                                    <tr>
                                        <td class="fw-semibold text-dark"><?= htmlspecialchars(Helper::limitWords($p['title'], 6)) ?></td>
                                        <td>
                                            <span class="badge bg-light text-dark border"><?= htmlspecialchars($p['category']) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge <?= $p['status'] === 'Terbit' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning-emphasis' ?>">
                                                <?= htmlspecialchars($p['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= Helper::url('admin/posts/edit/' . $p['id']) ?>" class="btn btn-sm btn-outline-primary py-0 px-2">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4 m-0 small">Belum ada artikel warta.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
