<?php
$musholaName = $globalSettings['mushola_name'] ?? 'Musholla Ar-rahman';
$phone1 = $globalSettings['phone_1'] ?? '0813-8619-8079';
$phone2 = $globalSettings['phone_2'] ?? '0812-9465-6075';
$address = $globalSettings['address'] ?? 'Jl. Anyer RT 007 RW 07 Gembor Periuk Tangerang';
$mapsUrl = $globalSettings['maps_url'] ?? 'https://maps.app.goo.gl/JZzSrDEKjCseGwgw7?g_st=aw';
$logoImg = !empty($globalSettings['logo_image']) ? Helper::uploadUrl($globalSettings['logo_image']) : Helper::asset('images/default-logo.svg');
$donationActive = ($globalSettings['donation_active'] ?? '1') === '1';
$financeActive = ($globalSettings['finance_active'] ?? '1') === '1';
?>

<!-- Topbar Informasi -->
<div class="topbar d-none d-md-block">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-4">
                <span><i class="bi bi-geo-alt-fill text-warning me-1"></i> <?= htmlspecialchars(substr($address, 0, 58)) ?>...</span>
                <span><i class="bi bi-clock-fill text-warning me-1"></i> <span id="live-clock">--:--:-- WIB</span></span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="https://wa.me/62<?= preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', $phone1)) ?>" target="_blank" rel="noopener">
                    <i class="bi bi-whatsapp text-success me-1"></i> <?= htmlspecialchars($phone1) ?>
                </a>
                <span class="text-white-50">|</span>
                <a href="<?= htmlspecialchars($mapsUrl) ?>" target="_blank" rel="noopener">
                    <i class="bi bi-pin-map text-warning me-1"></i> Peta Lokasi
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Navbar Utama -->
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand navbar-brand-wrapper" href="<?= Helper::url() ?>">
            <img src="<?= htmlspecialchars($logoImg) ?>" alt="Logo <?= htmlspecialchars($musholaName) ?>" class="navbar-brand-logo">
            <div class="navbar-brand-text">
                <h1><?= htmlspecialchars($musholaName) ?></h1>
                <p>Gembor • Periuk • Kota Tangerang</p>
            </div>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-1 text-success"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1 mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= Helper::isActive('/') ?>" href="<?= Helper::url() ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= Helper::isActive('profil') ?>" href="<?= Helper::url('profil') ?>">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= Helper::isActive('kegiatan') ?>" href="<?= Helper::url('kegiatan') ?>">Kegiatan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= Helper::isActive('berita') ?>" href="<?= Helper::url('berita') ?>">Berita</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= Helper::isActive('galeri') ?>" href="<?= Helper::url('galeri') ?>">Galeri</a>
                </li>
                <?php if ($financeActive): ?>
                <li class="nav-item">
                    <a class="nav-link <?= Helper::isActive('laporan-keuangan') ?>" href="<?= Helper::url('laporan-keuangan') ?>">Laporan Kas</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link <?= Helper::isActive('kontak') ?>" href="<?= Helper::url('kontak') ?>">Kontak</a>
                </li>
                
                <?php if ($donationActive): ?>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-gold w-100 d-inline-flex align-items-center justify-content-center gap-2" href="<?= Helper::url('donasi') ?>">
                        <i class="bi bi-heart-fill text-danger"></i> Infaq & Donasi
                    </a>
                </li>
                <?php endif; ?>

                <?php if (Auth::check()): ?>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-sm btn-outline-success w-100" href="<?= Helper::url('admin') ?>">
                        <i class="bi bi-speedometer2 me-1"></i> Admin
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
