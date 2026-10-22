<?php if (Session::hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill fs-5 me-2"></i>
        <div><?= htmlspecialchars(Session::getFlash('success')) ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>

<?php if (Session::hasFlash('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
        <div><?= htmlspecialchars(Session::getFlash('error')) ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>

<?php if (Session::hasFlash('info')): ?>
    <div class="alert alert-info alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-info-circle-fill fs-5 me-2"></i>
        <div><?= htmlspecialchars(Session::getFlash('info')) ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>
