<?php
$user = Auth::user();
$unreadMessages = (new Message())->unreadCount();
$musholaName = $globalSettings['mushola_name'] ?? 'Musholla Ar-rahman';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Panel - Musholla Ar-rahman') ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= Helper::asset('images/default-logo.svg') ?>">

    <!-- Bootstrap 5.3 CSS & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Admin Panel CSS -->
    <link rel="stylesheet" href="<?= Helper::asset('css/admin.css') ?>">
</head>
<body class="admin-body">

    <!-- Sidebar Hijau Gelap -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <img src="<?= Helper::asset('images/default-logo.svg') ?>" alt="Logo">
            <div class="sidebar-brand">
                <h6><?= htmlspecialchars(substr($musholaName, 0, 18)) ?></h6>
                <span>PANEL PENGURUS</span>
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="menu-label">Utama</div>
            <a href="<?= Helper::url('admin') ?>" class="sidebar-link <?= Helper::isActive('admin') && !Helper::isActive('admin/') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="menu-label">Konten & Publikasi</div>
            <a href="<?= Helper::url('admin/posts') ?>" class="sidebar-link <?= Helper::isActive('admin/posts') ?>">
                <i class="bi bi-newspaper"></i> Berita & Info
            </a>
            <a href="<?= Helper::url('admin/events') ?>" class="sidebar-link <?= Helper::isActive('admin/events') ?>">
                <i class="bi bi-calendar-check"></i> Agenda Kegiatan
            </a>
            <a href="<?= Helper::url('admin/gallery') ?>" class="sidebar-link <?= Helper::isActive('admin/gallery') ?>">
                <i class="bi bi-images"></i> Galeri Foto
            </a>

            <div class="menu-label">Pengaturan & Modul</div>
            <a href="<?= Helper::url('admin/settings') ?>" class="sidebar-link <?= Helper::isActive('admin/settings') ?>">
                <i class="bi bi-sliders"></i> Profil & Identitas
            </a>
            <a href="<?= Helper::url('admin/prayer') ?>" class="sidebar-link <?= Helper::isActive('admin/prayer') ?>">
                <i class="bi bi-clock-history"></i> Jadwal Salat
            </a>
            <a href="<?= Helper::url('admin/donation') ?>" class="sidebar-link <?= Helper::isActive('admin/donation') ?>">
                <i class="bi bi-wallet2"></i> Donasi & Rekening
            </a>
            <a href="<?= Helper::url('admin/finance') ?>" class="sidebar-link <?= Helper::isActive('admin/finance') ?>">
                <i class="bi bi-cash-coin"></i> Laporan Kas
            </a>

            <div class="menu-label">Interaksi & Sistem</div>
            <a href="<?= Helper::url('admin/messages') ?>" class="sidebar-link <?= Helper::isActive('admin/messages') ?>">
                <i class="bi bi-chat-left-dots"></i> Pesan Masuk
                <?php if ($unreadMessages > 0): ?>
                    <span class="badge bg-danger rounded-pill ms-auto"><?= $unreadMessages ?></span>
                <?php endif; ?>
            </a>

            <?php if (Auth::isSuperAdmin()): ?>
            <a href="<?= Helper::url('admin/users') ?>" class="sidebar-link <?= Helper::isActive('admin/users') ?>">
                <i class="bi bi-people"></i> Kelola Admin
            </a>
            <?php endif; ?>

            <div class="menu-label">Tautan Luar</div>
            <a href="<?= Helper::url() ?>" target="_blank" class="sidebar-link text-warning">
                <i class="bi bi-box-arrow-up-right"></i> Buka Website Publik
            </a>
            <a href="<?= Helper::url('admin/logout') ?>" class="sidebar-link text-danger mt-3">
                <i class="bi bi-box-arrow-right"></i> Keluar (Logout)
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
        <!-- Topbar -->
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle" aria-label="Toggle Sidebar">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <h1 class="admin-topbar-title"><?= htmlspecialchars($title ?? 'Dashboard') ?></h1>
            </div>

            <div class="admin-user-badge">
                <div class="text-end d-none d-sm-block">
                    <div class="fw-bold small"><?= htmlspecialchars($user['name'] ?? 'Pengurus') ?></div>
                    <span class="badge bg-success-subtle text-success small">
                        <?= ($user['role'] ?? '') === 'super_admin' ? 'Super Admin' : 'Editor Konten' ?>
                    </span>
                </div>
                <div class="user-avatar">
                    <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="admin-content">
            <?php require ROOT_PATH . '/views/partials/alerts.php'; ?>
            <?= $content ?>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Admin JS -->
    <script src="<?= Helper::asset('js/admin.js') ?>"></script>
</body>
</html>
