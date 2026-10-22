<?php
$musholaName = $globalSettings['mushola_name'] ?? 'Musholla Ar-rahman';
$address = $globalSettings['address'] ?? 'Jl. Anyer RT 007 RW 07, Kelurahan Gembor, Kecamatan Periuk, Kota Tangerang, Banten 15133';
$phone1 = $globalSettings['phone_1'] ?? '0813-8619-8079';
$phone2 = $globalSettings['phone_2'] ?? '0812-9465-6075';
$email = $globalSettings['email'] ?? 'dkm.musholla.arrahman@gmail.com';
$mapsUrl = $globalSettings['maps_url'] ?? 'https://maps.app.goo.gl/JZzSrDEKjCseGwgw7?g_st=aw';
$dkmLead = $globalSettings['dkm_lead'] ?? 'USTADZ TATA A.S';
$dkmTreasurer = $globalSettings['dkm_treasurer'] ?? 'Bapak Suwadi';
$dkmSecretary = $globalSettings['dkm_secretary'] ?? 'Bapak Bakri';
$bankAccount = $globalSettings['donation_account'] ?? '0152632533100';
$bankName = $globalSettings['donation_bank'] ?? 'Bank BJB';
?>

<footer class="footer">
    <div class="container">
        <div class="row g-4">
            <!-- Kolom 1: Profil Musholla -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="<?= Helper::asset('images/default-logo.svg') ?>" alt="Logo" width="38" height="38">
                    <h5 class="m-0 text-white"><?= htmlspecialchars($musholaName) ?></h5>
                </div>
                <p class="text-light-50 small mb-3">
                    Berdiri sejak tahun 1990 atas gotong royong warga RT 007 RW 07 Kelurahan Gembor, Kecamatan Periuk, Kota Tangerang bersama pemerintah setempat sebagai pusat ibadah, ukhuwah islamiyah, dan pembinaan umat.
                </p>
                <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <small class="text-warning d-block fw-bold mb-1"><i class="bi bi-wallet2 me-1"></i> Rekening Donasi Resmi:</small>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="badge bg-light text-dark fw-bold me-1"><?= htmlspecialchars($bankName) ?></span>
                            <span class="text-white fw-bold font-monospace"><?= htmlspecialchars($bankAccount) ?></span>
                        </div>
                        <button class="btn btn-sm btn-outline-light-custom btn-copy-account py-1 px-2" data-account="<?= htmlspecialchars($bankAccount) ?>" title="Salin No. Rekening">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Kolom 2: Navigasi Cepat -->
            <div class="col-lg-2 col-md-6">
                <h5>Menu Utama</h5>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="<?= Helper::url() ?>"><i class="bi bi-chevron-right me-1 text-warning"></i> Beranda</a></li>
                    <li><a href="<?= Helper::url('profil') ?>"><i class="bi bi-chevron-right me-1 text-warning"></i> Profil & Sejarah</a></li>
                    <li><a href="<?= Helper::url('kegiatan') ?>"><i class="bi bi-chevron-right me-1 text-warning"></i> Agenda Kegiatan</a></li>
                    <li><a href="<?= Helper::url('berita') ?>"><i class="bi bi-chevron-right me-1 text-warning"></i> Berita & Info</a></li>
                    <li><a href="<?= Helper::url('galeri') ?>"><i class="bi bi-chevron-right me-1 text-warning"></i> Galeri Dokumentasi</a></li>
                    <li><a href="<?= Helper::url('donasi') ?>"><i class="bi bi-chevron-right me-1 text-warning"></i> Infaq & Donasi</a></li>
                    <li><a href="<?= Helper::url('kontak') ?>"><i class="bi bi-chevron-right me-1 text-warning"></i> Hubungi Kami</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Susunan Pengurus DKM -->
            <div class="col-lg-3 col-md-6">
                <h5>Pengurus DKM</h5>
                <ul class="list-unstyled small d-flex flex-column gap-2">
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-person-check-fill text-warning mt-1"></i>
                        <div>
                            <span class="text-white-50 d-block">Ketua DKM:</span>
                            <strong class="text-white"><?= htmlspecialchars($dkmLead) ?></strong>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-cash-stack text-warning mt-1"></i>
                        <div>
                            <span class="text-white-50 d-block">Bendahara:</span>
                            <strong class="text-white"><?= htmlspecialchars($dkmTreasurer) ?></strong>
                        </div>
                    </li>
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-pen-fill text-warning mt-1"></i>
                        <div>
                            <span class="text-white-50 d-block">Sekretaris:</span>
                            <strong class="text-white"><?= htmlspecialchars($dkmSecretary) ?></strong>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Kolom 4: Alamat & Kontak -->
            <div class="col-lg-3 col-md-6">
                <h5>Alamat & Kontak</h5>
                <p class="small text-light-50 mb-3">
                    <i class="bi bi-geo-alt-fill text-warning me-1"></i>
                    <?= htmlspecialchars($address) ?>
                </p>
                <div class="d-flex flex-column gap-2 small mb-3">
                    <a href="https://wa.me/62<?= preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', $phone1)) ?>" target="_blank" rel="noopener" class="d-inline-flex align-items-center gap-2">
                        <i class="bi bi-whatsapp text-success fs-6"></i> <?= htmlspecialchars($phone1) ?>
                    </a>
                    <a href="https://wa.me/62<?= preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', $phone2)) ?>" target="_blank" rel="noopener" class="d-inline-flex align-items-center gap-2">
                        <i class="bi bi-whatsapp text-success fs-6"></i> <?= htmlspecialchars($phone2) ?>
                    </a>
                    <a href="mailto:<?= htmlspecialchars($email) ?>" class="d-inline-flex align-items-center gap-2">
                        <i class="bi bi-envelope-fill text-warning fs-6"></i> <?= htmlspecialchars($email) ?>
                    </a>
                </div>
                <a href="<?= htmlspecialchars($mapsUrl) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-light-custom w-100">
                    <i class="bi bi-map-fill me-1"></i> Buka di Google Maps
                </a>
            </div>
        </div>

        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div>
                &copy; <?= date('Y') ?> <strong><?= htmlspecialchars($musholaName) ?></strong> Gembor Periuk Tangerang. Hak Cipta Dilindungi.
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="<?= Helper::url('kontak') ?>" class="text-white-50">Privasi & Etika</a>
                <span class="text-white-50">•</span>
                <a href="<?= Helper::url('admin/login') ?>" class="text-warning">
                    <i class="bi bi-shield-lock-fill me-1"></i> Area Pengurus
                </a>
            </div>
        </div>
    </div>
</footer>

<!-- Lightbox Modal untuk Galeri Foto -->
<div class="modal fade" id="lightboxModal" tabindex="-1" aria-labelledby="lightboxCaption" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-0 text-white">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title" id="lightboxCaption">Dokumentasi Musholla</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center p-3">
                <img src="" id="lightboxImage" class="img-fluid rounded-3 shadow" alt="Foto Dokumentasi" style="max-height: 75vh;">
            </div>
        </div>
    </div>
</div>
