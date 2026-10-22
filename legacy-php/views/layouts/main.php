<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Website Resmi Musholla Ar-rahman Periuk Tangerang') ?></title>
    
    <!-- Meta SEO & Open Graph -->
    <meta name="description" content="<?= htmlspecialchars($metaDesc ?? 'Website resmi Musholla Ar-rahman RT 007 RW 07 Kelurahan Gembor Kecamatan Periuk Kota Tangerang. Informasi jadwal salat, agenda kegiatan, pengajian, berita, galeri, dan infaq donasi.') ?>">
    <meta name="keywords" content="Musholla Ar-rahman, Musholla Tangerang, Musholla Periuk Gembor, Jadwal Salat Tangerang, DKM Ar-rahman, Pengajian Rutin Tangerang, Donasi Musholla">
    <meta property="og:title" content="<?= htmlspecialchars($title ?? 'Musholla Ar-rahman Periuk Tangerang') ?>">
    <meta property="og:description" content="Pusat ibadah dan ukhuwah warga RT 007 RW 07 Kelurahan Gembor Periuk Tangerang.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?= Helper::uploadUrl('hero-collage-kegiatan.jpeg') ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= Helper::asset('images/default-logo.svg') ?>">

    <!-- Bootstrap 5.3 CSS & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Modern Islamic Design System -->
    <link rel="stylesheet" href="<?= Helper::asset('css/style.css') ?>">
</head>
<body>

    <!-- Header & Navigation -->
    <?php require ROOT_PATH . '/views/partials/navbar.php'; ?>

    <!-- Flash Alerts Container -->
    <div class="container mt-3">
        <?php require ROOT_PATH . '/views/partials/alerts.php'; ?>
    </div>

    <!-- Main Content -->
    <main>
        <?= $content ?>
    </main>

    <!-- Footer -->
    <?php require ROOT_PATH . '/views/partials/footer.php'; ?>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="<?= Helper::asset('js/main.js') ?>"></script>
</body>
</html>
