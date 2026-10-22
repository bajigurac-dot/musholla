<!-- Detail Kegiatan -->
<section class="py-5 bg-white border-bottom">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="<?= Helper::url() ?>" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::url('kegiatan') ?>" class="text-decoration-none text-muted">Kegiatan</a></li>
                <li class="breadcrumb-item active text-success fw-bold" aria-current="page"><?= htmlspecialchars($event['title']) ?></li>
            </ol>
        </nav>
        <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2"><?= htmlspecialchars($event['category'] ?? 'Rutin') ?></span>
        <h1 class="fw-bold"><?= htmlspecialchars($event['title']) ?></h1>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Kolom Konten Utama -->
            <div class="col-lg-8">
                <div class="bg-white border rounded-4 p-4 shadow-sm mb-4">
                    <img src="<?= Helper::uploadUrl($event['image']) ?>" alt="<?= htmlspecialchars($event['title']) ?>" class="img-fluid rounded-3 mb-4 w-100" style="max-height: 400px; object-fit: cover;">
                    
                    <!-- Info Box Tanggal, Jam, Lokasi -->
                    <div class="p-3 bg-light rounded-3 border mb-4">
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <small class="text-muted d-block"><i class="bi bi-calendar-event text-success me-1"></i> Tanggal Pelaksanaan:</small>
                                <strong class="text-dark"><?= Helper::formatDate($event['event_date']) ?></strong>
                            </div>
                            <div class="col-sm-4">
                                <small class="text-muted d-block"><i class="bi bi-clock text-warning me-1"></i> Waktu / Pukul:</small>
                                <strong class="text-dark"><?= htmlspecialchars($event['start_time']) ?> - <?= htmlspecialchars($event['end_time']) ?> WIB</strong>
                            </div>
                            <div class="col-sm-4">
                                <small class="text-muted d-block"><i class="bi bi-geo-alt text-danger me-1"></i> Tempat / Lokasi:</small>
                                <strong class="text-dark"><?= htmlspecialchars($event['location'] ?? 'Musholla Ar-rahman') ?></strong>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3">Deskripsi Lengkap Kegiatan</h5>
                    <div class="leading-relaxed text-muted mb-4" style="font-size: 1.05rem;">
                        <?= nl2br(htmlspecialchars($event['description'])) ?>
                    </div>

                    <div class="d-flex flex-wrap align-items-center justify-content-between border-top pt-3">
                        <span class="small text-muted">Ajak keluarga dan tetangga memakmurkan musholla kita.</span>
                        <a href="https://api.whatsapp.com/send?text=<?= urlencode("Hadiri kegiatan: " . $event['title'] . " pada " . Helper::formatDate($event['event_date']) . " di Musholla Ar-rahman Gembor Periuk: " . Helper::url('kegiatan/' . $event['slug'])) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-success">
                            <i class="bi bi-whatsapp me-1"></i> Bagikan ke WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar Kegiatan Lainnya -->
            <div class="col-lg-4">
                <div class="bg-white border rounded-4 p-4 shadow-sm mb-4">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Agenda Terdekat Lainnya</h5>
                    <?php if (!empty($upcoming)): ?>
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($upcoming as $up): ?>
                                <?php if ($up['id'] == $event['id']) continue; ?>
                                <div class="d-flex gap-3 align-items-start border-bottom pb-3">
                                    <div class="p-2 bg-success text-white rounded-3 text-center" style="min-width: 50px;">
                                        <small class="d-block fw-bold" style="font-size:0.65rem;"><?= strtoupper(date('M', strtotime($up['event_date']))) ?></small>
                                        <span class="fs-5 fw-bold leading-none"><?= date('d', strtotime($up['event_date'])) ?></span>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 small">
                                            <a href="<?= Helper::url('kegiatan/' . $up['slug']) ?>" class="text-decoration-none text-dark">
                                                <?= htmlspecialchars($up['title']) ?>
                                            </a>
                                        </h6>
                                        <small class="text-muted d-block"><i class="bi bi-clock me-1"></i><?= htmlspecialchars($up['start_time']) ?> WIB</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted small m-0">Tidak ada agenda lain.</p>
                    <?php endif; ?>
                </div>

                <div class="p-4 rounded-4 text-white text-center shadow-sm" style="background: #075B4A;">
                    <i class="bi bi-chat-heart-fill fs-1 text-warning mb-2 d-block"></i>
                    <h5 class="fw-bold text-white mb-2">Ingin Mengadakan Kajian?</h5>
                    <p class="text-white-50 small mb-3">Koordinasikan kegiatan keagamaan Anda dengan pengurus DKM Musholla Ar-rahman.</p>
                    <a href="<?= Helper::url('kontak') ?>" class="btn btn-gold btn-sm fw-bold">Hubungi DKM</a>
                </div>
            </div>
        </div>
    </div>
</section>
