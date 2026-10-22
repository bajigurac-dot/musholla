<?php
$musholaName = $globalSettings['mushola_name'] ?? 'Musholla Ar-rahman';
$history = $globalSettings['history'] ?? 'Musholla Ar-rahman berdiri sejak tahun 1990 dengan gotong royong warga sekitar dan dibantu oleh pemerintah setempat untuk kegiatan beribadah lingkungan sekitarnya sehingga warga masyarakat semakin taat dan semangat dalam melakukan beribadah.';
$vision = $globalSettings['vision'] ?? 'Terwujudnya Musholla Ar-rahman sebagai pusat ibadah yang makmur, membina ukhuwah islamiyah, dan melahirkan generasi Qur\'ani yang berakhlakul karimah.';
$mission = $globalSettings['mission'] ?? '';
$facilities = $globalSettings['facilities'] ?? 'Ruang Sholat Ber-AC, Tempat Wudhu Pria & Wanita Terpisah, Sound System Berkualitas, Perpustakaan Mini & Al-Qur\'an Wakaf, Kamar Mandi Bersih, Area Parkir Motor, Karpet Sholat Nyaman, Genset Cadangan Listrik.';
$dkmLead = $globalSettings['dkm_lead'] ?? 'USTADZ TATA A.S';
$dkmTreasurer = $globalSettings['dkm_treasurer'] ?? 'Bapak Suwadi';
$dkmSecretary = $globalSettings['dkm_secretary'] ?? 'Bapak Bakri';
$address = $globalSettings['address'] ?? 'Jl. Anyer RT 007 RW 07, Kelurahan Gembor, Kecamatan Periuk, Kota Tangerang, Banten 15133';
$phone1 = $globalSettings['phone_1'] ?? '0813-8619-8079';
$phone2 = $globalSettings['phone_2'] ?? '0812-9465-6075';
?>

<!-- Page Header Header Section -->
<section class="py-5 bg-white border-bottom">
    <div class="container text-center py-4">
        <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">PROFIL RESMI</span>
        <h1 class="fw-bold mb-2">Profil & Sejarah <?= htmlspecialchars($musholaName) ?></h1>
        <p class="text-muted m-0">Menelusuri jejak perjuangan gotong royong warga sejak tahun 1990 di Gembor, Periuk Tangerang</p>
    </div>
</section>

<!-- Konten Profil Utama -->
<section class="py-5">
    <div class="container">
        <!-- Bagian Sejarah -->
        <div class="row g-4 align-items-center mb-5">
            <div class="col-lg-6">
                <span class="text-success fw-bold text-uppercase small">SEJARAH BERDIRINYA</span>
                <h2 class="fw-bold mb-3">Gotong Royong Sejak Tahun 1990</h2>
                <div class="p-4 bg-white border rounded-4 shadow-sm mb-3">
                    <p class="text-muted leading-relaxed m-0" style="font-size: 1.05rem;">
                        <i class="bi bi-quote fs-2 text-success me-1"></i>
                        <?= nl2br(htmlspecialchars($history)) ?>
                    </p>
                </div>
                <p class="text-muted small">
                    Melalui keteladanan para sesepuh dan tokoh masyarakat terdahulu, Musholla Ar-rahman hingga saat ini terus dirawat dan dimakmurkan oleh generasi penerus warga RT 007 RW 07 Kelurahan Gembor Periuk Tangerang secara istiqomah.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="<?= Helper::uploadUrl('foto-kegiatan-8.jpeg') ?>" alt="Bangunan Musholla Ar-rahman" class="img-fluid rounded-4 shadow-md w-100 object-fit-cover" style="min-height: 340px; max-height: 420px;">
                    <div class="position-absolute top-0 end-0 m-3 badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-award-fill me-1"></i> Didirikan Tahun 1990
                    </div>
                </div>
            </div>
        </div>

        <!-- Visi dan Misi -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="p-4 bg-white border rounded-4 shadow-sm h-100">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="p-2 bg-success text-white rounded-3">
                            <i class="bi bi-compass-fill fs-5"></i>
                        </div>
                        <h4 class="fw-bold m-0 text-success">Visi Musholla</h4>
                    </div>
                    <p class="text-muted leading-relaxed" style="font-size: 1.02rem;">
                        "<?= htmlspecialchars($vision) ?>"
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-4 bg-white border rounded-4 shadow-sm h-100">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="p-2 bg-warning text-dark rounded-3">
                            <i class="bi bi-card-checklist fs-5"></i>
                        </div>
                        <h4 class="fw-bold m-0 text-dark">Misi Musholla</h4>
                    </div>
                    <div class="text-muted small leading-relaxed">
                        <?= nl2br(htmlspecialchars($mission)) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fasilitas Musholla -->
        <div class="p-4 bg-white border rounded-4 shadow-sm mb-5">
            <div class="d-flex align-items-center gap-2 mb-4">
                <div class="p-2 bg-success-subtle text-success rounded-3">
                    <i class="bi bi-grid-fill fs-5"></i>
                </div>
                <h4 class="fw-bold m-0">Fasilitas Tempat Ibadah</h4>
            </div>
            <div class="row g-3">
                <?php
                $facilityList = explode(',', $facilities);
                foreach ($facilityList as $fac):
                    $facTrim = trim($fac);
                    if (empty($facTrim)) continue;
                ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="p-3 bg-light rounded-3 d-flex align-items-center gap-2 border">
                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            <span class="small fw-semibold text-dark"><?= htmlspecialchars($facTrim) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Struktur Pengurus DKM -->
        <div class="mb-5">
            <div class="text-center mb-4">
                <span class="text-success fw-bold text-uppercase small">AMANAH KEPENGURUSAN</span>
                <h3 class="fw-bold">Susunan Pengurus DKM Musholla Ar-rahman</h3>
                <p class="text-muted small">Para pengurus yang diamanahkan warga melayani kebutuhan jamaah dan memelihara musholla</p>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Ketua DKM -->
                <div class="col-md-4">
                    <div class="p-4 bg-white border rounded-4 text-center shadow-sm h-100 border-top border-4 border-success">
                        <img src="<?= Helper::uploadUrl('ketua-dkm-ustadz-tata.jpeg') ?>" alt="Ustadz Tata A.S" class="mx-auto mb-3 rounded-circle object-fit-cover shadow-sm border border-3 border-success d-block" style="width: 100px; height: 100px;">
                        <span class="badge bg-success-subtle text-success mb-2 px-3 py-1 rounded-pill">Ketua DKM</span>
                        <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($dkmLead) ?></h5>
                        <p class="text-muted small m-0">Memimpin syiar, kajian, dan arah pembinaan kemakmuran musholla.</p>
                    </div>
                </div>

                <!-- Bendahara -->
                <div class="col-md-4">
                    <div class="p-4 bg-white border rounded-4 text-center shadow-sm h-100 border-top border-4 border-warning">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center text-dark bg-warning" style="width: 100px; height: 100px;">
                            <i class="bi bi-person-fill fs-1"></i>
                        </div>
                        <span class="badge bg-warning-subtle text-warning-emphasis mb-2 px-3 py-1 rounded-pill">Bendahara</span>
                        <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($dkmTreasurer) ?></h5>
                        <small class="text-muted d-block mb-1">(Foto menyusul)</small>
                        <p class="text-muted small m-0">Mengelola keuangan kas musholla secara transparan, amanah, dan akuntabel.</p>
                    </div>
                </div>

                <!-- Sekretaris -->
                <div class="col-md-4">
                    <div class="p-4 bg-white border rounded-4 text-center shadow-sm h-100 border-top border-4 border-primary">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center text-white bg-primary" style="width: 100px; height: 100px;">
                            <i class="bi bi-person-fill fs-1"></i>
                        </div>
                        <span class="badge bg-primary-subtle text-primary mb-2 px-3 py-1 rounded-pill">Sekretaris</span>
                        <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($dkmSecretary) ?></h5>
                        <small class="text-muted d-block mb-1">(Foto menyusul)</small>
                        <p class="text-muted small m-0">Mengurus administrasi, persuratan, warta kegiatan, dan kehumasan warga.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alamat & Kontak Callout -->
        <div class="p-4 rounded-4 text-white" style="background: linear-gradient(135deg, #075B4A 0%, #053E32 100%);">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <h4 class="fw-bold text-white mb-2">Ingin Bersilaturahmi atau Berkegiatan di Musholla?</h4>
                    <p class="text-white-50 small m-0">
                        Kami senantiasa terbuka menerima saran, koordinasi kegiatan keislaman, maupun silaturahmi warga jamaah. Hubungi kami via WhatsApp: <strong><?= htmlspecialchars($phone1) ?></strong> / <strong><?= htmlspecialchars($phone2) ?></strong>.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?= Helper::url('kontak') ?>" class="btn btn-gold fw-bold">
                        <i class="bi bi-envelope-fill me-1"></i> Hubungi Pengurus
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
