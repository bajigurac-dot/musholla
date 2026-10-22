<?php
$musholaName = $globalSettings['mushola_name'] ?? 'Musholla Ar-rahman';
$tagline = $globalSettings['tagline'] ?? 'Pusat Ibadah, Kebersamaan, dan Pembinaan Umat di Lingkungan Gembor Periuk Tangerang';
$history = $globalSettings['history'] ?? 'Musholla Ar-rahman berdiri sejak tahun 1990 dengan gotong royong warga sekitar dan dibantu oleh pemerintah setempat untuk kegiatan beribadah lingkungan sekitarnya sehingga warga masyarakat semakin taat dan semangat dalam melakukan beribadah.';
$phone1 = $globalSettings['phone_1'] ?? '0813-8619-8079';
$phone2 = $globalSettings['phone_2'] ?? '0812-9465-6075';
$address = $globalSettings['address'] ?? 'Jl. Anyer RT 007 RW 07, Kelurahan Gembor, Kecamatan Periuk, Kota Tangerang, Banten 15133';
$bankAccount = $globalSettings['donation_account'] ?? '0152632533100';
$bankName = $globalSettings['donation_bank'] ?? 'Bank BJB';
$donationActive = ($globalSettings['donation_active'] ?? '1') === '1';
$mapsEmbed = $globalSettings['maps_embed'] ?? '';
$mapsUrl = $globalSettings['maps_url'] ?? 'https://maps.app.goo.gl/JZzSrDEKjCseGwgw7?g_st=aw';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-lg-6">
                <div class="hero-badge">
                    <i class="bi bi-geo-alt-fill text-warning"></i> RT 007 RW 07 Gembor, Periuk - Tangerang
                </div>
                <h1 class="hero-title">
                    Selamat Datang di Website Resmi <br><span><?= htmlspecialchars($musholaName) ?></span>
                </h1>
                <p class="hero-desc">
                    <?= htmlspecialchars($tagline) ?>. Berdiri sejak tahun 1990 atas gotong royong warga untuk membina ukhuwah islamiyah dan generasi Qur'ani.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= Helper::url('profil') ?>" class="btn btn-gold btn-lg">
                        <i class="bi bi-info-circle-fill me-1"></i> Lihat Profil Musholla
                    </a>
                    <a href="<?= Helper::url('kegiatan') ?>" class="btn btn-outline-light-custom btn-lg">
                        <i class="bi bi-calendar3 me-1"></i> Agenda Kegiatan
                    </a>
                    <?php if ($donationActive): ?>
                    <a href="<?= Helper::url('donasi') ?>" class="btn btn-primary-custom btn-lg bg-white text-dark">
                        <i class="bi bi-heart-fill text-danger me-1"></i> Infaq & Donasi
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-5 col-xl-5 offset-xl-1">
                <div class="hero-glass-card shadow-2xl">
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom border-white border-opacity-25 pb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="p-2 bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="bi bi-moon-stars-fill fs-5"></i>
                            </div>
                            <div>
                                <h6 class="m-0 fw-bold text-white"><?= htmlspecialchars($musholaName) ?></h6>
                                <small class="text-white-50"><i class="bi bi-geo-alt-fill text-warning me-1"></i>Gembor, Periuk - Tangerang</small>
                            </div>
                        </div>
                        <span class="badge bg-gold text-dark fw-bold px-3 py-1 rounded-pill">Est. 1990</span>
                    </div>

                    <p class="text-white small mb-3 leading-relaxed" style="opacity: 0.92;">
                        "Berdiri sejak tahun 1990 atas gotong royong warga sekitar dan dibantu pemerintah setempat untuk membina ukhuwah islamiyah dan generasi Qur'ani."
                    </p>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="p-3 rounded-3 text-center border border-white border-opacity-15" style="background: rgba(0,0,0,0.22);">
                                <i class="bi bi-people-fill text-warning fs-3 mb-1 d-block"></i>
                                <strong class="d-block text-white fs-6">Gotong Royong</strong>
                                <span class="text-white-50" style="font-size: 0.72rem;">Warga RT 007 RW 07</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3 text-center border border-white border-opacity-15" style="background: rgba(0,0,0,0.22);">
                                <i class="bi bi-book-half text-success-subtle fs-3 mb-1 d-block"></i>
                                <strong class="d-block text-white fs-6">Kajian & Syiar</strong>
                                <span class="text-white-50" style="font-size: 0.72rem;">Yasinan & Pengajian</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pt-2 border-top border-white border-opacity-25">
                        <div class="text-white small">
                            <span class="d-block fw-semibold" style="font-size: 0.78rem;"><i class="bi bi-person-badge text-warning me-1"></i> Ketua DKM:</span>
                            <span class="text-white-50 small">USTADZ TATA A.S</span>
                        </div>
                        <a href="<?= Helper::url('profil') ?>" class="btn btn-sm btn-outline-light rounded-pill px-3 fw-bold">
                            Profil & Sejarah <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Jadwal Salat Widget -->
<?php require ROOT_PATH . '/views/partials/prayer_banner.php'; ?>

<!-- Ringkasan Profil & Kegiatan Utama -->
<section class="py-5 mt-4">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">SEJARAH & AMANAH</span>
                <h2 class="fw-bold mb-3">Tiga Dekade Melayani Jamaah & Warga Sekitar</h2>
                <p class="text-muted leading-relaxed">
                    <?= htmlspecialchars($history) ?>
                </p>
                
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <div class="p-3 bg-white border rounded-3 text-center h-100 shadow-sm">
                            <i class="bi bi-bell-fill text-success fs-2 mb-2 d-block"></i>
                            <strong class="d-block text-dark small">Sholat 5 Waktu</strong>
                            <span class="text-muted" style="font-size:0.75rem;">Berjamaah Tepat Waktu</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white border rounded-3 text-center h-100 shadow-sm">
                            <i class="bi bi-book-half text-warning fs-2 mb-2 d-block"></i>
                            <strong class="d-block text-dark small">Malam Jum'at</strong>
                            <span class="text-muted" style="font-size:0.75rem;">Yasinan & Tahlil Bersama</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-white border rounded-3 text-center h-100 shadow-sm">
                            <i class="bi bi-people-fill text-primary fs-2 mb-2 d-block"></i>
                            <strong class="d-block text-dark small">Pengajian Rutin</strong>
                            <span class="text-muted" style="font-size:0.75rem;">Kajian Bulanan Warga</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="<?= Helper::url('profil') ?>" class="btn btn-outline-success fw-bold">
                        Pelajari Sejarah & Struktur DKM <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="<?= Helper::uploadUrl('foto-kegiatan-7.jpeg') ?>" alt="Musholla Ar-rahman" class="img-fluid rounded-4 shadow-lg w-100 object-fit-cover" style="min-height: 320px; max-height: 420px;">
                    <div class="position-absolute bottom-0 start-0 m-3 p-3 bg-white rounded-3 shadow-sm border" style="max-width: 320px;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="p-2 bg-success text-white rounded-circle">
                                <i class="bi bi-building-check fs-5"></i>
                            </div>
                            <div>
                                <h6 class="m-0 fw-bold">Musholla Ar-rahman</h6>
                                <small class="text-muted">Jl. Anyer RT 007 RW 07 Periuk</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Agenda Kegiatan Mendatang -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-warning-subtle text-warning-emphasis fw-bold px-3 py-2 rounded-pill mb-2">KEGIATAN & SYIAR</span>
                <h2 class="fw-bold m-0">Agenda Kegiatan Terdekat</h2>
            </div>
            <a href="<?= Helper::url('kegiatan') ?>" class="btn btn-sm btn-outline-success fw-bold">
                Lihat Semua Kegiatan <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <?php if (!empty($upcomingEvents)): ?>
            <div class="row g-4">
                <?php foreach ($upcomingEvents as $evt): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="custom-card">
                            <img src="<?= Helper::uploadUrl($evt['image']) ?>" alt="<?= htmlspecialchars($evt['title']) ?>" class="custom-card-img">
                            <div class="custom-card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="card-badge card-badge-kegiatan"><?= htmlspecialchars($evt['category'] ?? 'Rutin') ?></span>
                                    <small class="text-muted"><i class="bi bi-calendar-event me-1"></i><?= date('d M Y', strtotime($evt['event_date'])) ?></small>
                                </div>
                                <h5 class="fw-bold fs-6 mb-2">
                                    <a href="<?= Helper::url('kegiatan/' . $evt['slug']) ?>" class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($evt['title']) ?>
                                    </a>
                                </h5>
                                <p class="text-muted small mb-3 flex-grow-1">
                                    <?= htmlspecialchars(Helper::limitWords($evt['description'], 14)) ?>
                                </p>
                                <div class="border-top pt-2 small text-muted d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-clock me-1"></i><?= htmlspecialchars($evt['start_time']) ?> WIB</span>
                                    <a href="<?= Helper::url('kegiatan/' . $evt['slug']) ?>" class="text-success fw-bold text-decoration-none">
                                        Detail <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-light border text-center p-4">
                <i class="bi bi-calendar-x fs-2 text-muted d-block mb-2"></i>
                <p class="m-0 text-muted">Belum ada agenda kegiatan mendatang yang dijadwalkan.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Berita & Pengumuman Terbaru -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">WARTA MUSHOLLA</span>
                <h2 class="fw-bold m-0">Berita & Pengumuman Terbaru</h2>
            </div>
            <a href="<?= Helper::url('berita') ?>" class="btn btn-sm btn-outline-success fw-bold">
                Arsip Berita <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <?php if (!empty($recentPosts)): ?>
            <div class="row g-4">
                <?php foreach ($recentPosts as $post): ?>
                    <div class="col-md-4">
                        <div class="custom-card">
                            <img src="<?= Helper::uploadUrl($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="custom-card-img">
                            <div class="custom-card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="card-badge <?= $post['category'] === 'Pengumuman' ? 'card-badge-pengumuman' : 'card-badge-berita' ?>">
                                        <?= htmlspecialchars($post['category']) ?>
                                    </span>
                                    <small class="text-muted"><i class="bi bi-clock me-1"></i><?= Helper::formatDate($post['created_at']) ?></small>
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
                                        Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-light border text-center p-4">
                <i class="bi bi-newspaper fs-2 text-muted d-block mb-2"></i>
                <p class="m-0 text-muted">Belum ada warta berita yang diterbitkan.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Sekilas Cuplikan Galeri Dokumentasi -->
<?php if (!empty($recentGalleries)): ?>
<section class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-info-subtle text-info-emphasis fw-bold px-3 py-2 rounded-pill mb-2">DOKUMENTASI</span>
                <h2 class="fw-bold m-0">Galeri Foto Kegiatan & Fasilitas</h2>
            </div>
            <a href="<?= Helper::url('galeri') ?>" class="btn btn-sm btn-outline-success fw-bold">
                Lihat Seluruh Galeri <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="gallery-grid">
            <?php foreach ($recentGalleries as $gal): ?>
                <div class="gallery-item" data-title="<?= htmlspecialchars($gal['title']) ?>">
                    <img src="<?= Helper::uploadUrl($gal['image']) ?>" alt="<?= htmlspecialchars($gal['alt_text'] ?? $gal['title']) ?>" loading="lazy">
                    <div class="gallery-overlay">
                        <span class="badge bg-warning text-dark mb-1"><?= htmlspecialchars($gal['category'] ?? 'Kegiatan') ?></span>
                        <h6 class="m-0 text-white fw-bold small"><?= htmlspecialchars($gal['title']) ?></h6>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Modul Donasi & Rekening Bank BJB -->
<?php if ($donationActive): ?>
<section class="py-5">
    <div class="container">
        <div class="donation-card">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill mb-3">INFAQ & SEDEKAH JARIYAH</span>
                    <h2 class="text-white fw-bold mb-3">Salurkan Infaq Terbaik Anda untuk Kemakmuran Musholla Ar-rahman</h2>
                    <p class="text-white-50 mb-4">
                        Setiap rupiah infaq dan sedekah yang Anda salurkan digunakan untuk operasional harian, pemeliharaan sarana ibadah, dan kegiatan keagamaan jamaah lingkungan Gembor Periuk Tangerang.
                    </p>

                    <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-25 mb-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="bank-badge"><?= htmlspecialchars($bankName) ?></span>
                            <span class="text-white-50 small">Atas Nama: <strong>Musholla Ar-rahman</strong></span>
                        </div>
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <span class="account-number"><?= htmlspecialchars($bankAccount) ?></span>
                            <button class="btn btn-gold btn-copy-account" data-account="<?= htmlspecialchars($bankAccount) ?>">
                                <i class="bi bi-clipboard me-1"></i> Salin No. Rekening
                            </button>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="https://wa.me/62<?= preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', $phone1)) ?>?text=<?= urlencode("Assalamu'alaikum Pengurus DKM Musholla Ar-rahman, saya telah menyalurkan donasi via Bank BJB. Mohon konfirmasinya.") ?>" target="_blank" rel="noopener" class="btn btn-outline-light-custom">
                            <i class="bi bi-whatsapp me-1 text-success"></i> Konfirmasi via WhatsApp
                        </a>
                        <a href="<?= Helper::url('donasi') ?>" class="btn btn-link text-white text-decoration-none">
                            Lihat QRIS & Petunjuk Donasi <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-5 text-center">
                    <div class="bg-white p-4 rounded-4 shadow-lg d-inline-block text-dark" style="max-width: 320px;">
                        <img src="<?= Helper::asset('images/default-qris.svg') ?>" alt="QRIS Musholla Ar-rahman" class="img-fluid rounded-3 mb-3">
                        <h6 class="fw-bold mb-1">Scan QRIS Infaq Resmi</h6>
                        <small class="text-muted d-block">BCA, Mandiri, BRI, BSI, Gopay, OVO, Dana, dll</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Lokasi & Peta Google Maps -->
<section class="py-5 bg-white border-top">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">LOKASI KAMI</span>
                <h2 class="fw-bold mb-3">Kunjungi Musholla Ar-rahman</h2>
                <p class="text-muted mb-4">
                    Musholla Ar-rahman terletak di tengah lingkungan masyarakat yang asri dan guyub di Kelurahan Gembor, Periuk Kota Tangerang.
                </p>

                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex align-items-start gap-3">
                        <div class="p-2 bg-success-subtle text-success rounded-3">
                            <i class="bi bi-geo-alt-fill fs-5"></i>
                        </div>
                        <div>
                            <strong class="d-block text-dark">Alamat Lengkap:</strong>
                            <span class="text-muted small"><?= htmlspecialchars($address) ?></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="p-2 bg-success-subtle text-success rounded-3">
                            <i class="bi bi-telephone-fill fs-5"></i>
                        </div>
                        <div>
                            <strong class="d-block text-dark">Kontak Pengurus DKM:</strong>
                            <span class="text-muted small"><?= htmlspecialchars($phone1) ?> / <?= htmlspecialchars($phone2) ?></span>
                        </div>
                    </div>
                </div>

                <a href="<?= htmlspecialchars($mapsUrl) ?>" target="_blank" rel="noopener" class="btn btn-primary-custom">
                    <i class="bi bi-pin-map-fill me-1"></i> Buka Rute di Google Maps
                </a>
            </div>

            <div class="col-lg-7">
                <div class="rounded-4 overflow-hidden shadow-sm border" style="min-height: 350px;">
                    <iframe src="<?= htmlspecialchars($mapsEmbed) ?>" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Peta Lokasi Musholla Ar-rahman"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
