<div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="max-width: 420px; width: 100%;">
    <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #053E32 0%, #075B4A 100%);">
        <img src="<?= Helper::asset('images/default-logo.svg') ?>" alt="Logo" width="70" height="70" class="mb-2">
        <h5 class="fw-bold m-0 text-white">Admin Panel Musholla</h5>
        <small class="text-white-50">Musholla Ar-rahman Gembor Periuk Tangerang</small>
    </div>

    <div class="card-body p-4 p-md-4">
        <?php require ROOT_PATH . '/views/partials/alerts.php'; ?>

        <form action="<?= Helper::url('admin/login') ?>" method="POST">
            <?= Csrf::field() ?>

            <div class="mb-3">
                <label for="username" class="form-label small fw-bold text-dark">Nama Pengguna / Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" id="username" name="username" placeholder="admin / editor" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label small fw-bold text-dark">Kata Sandi (Password)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary-custom w-100 py-2 fw-bold">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Panel Pengurus
            </button>
        </form>

        <div class="mt-4 pt-3 border-top text-center">
            <a href="<?= Helper::url() ?>" class="text-decoration-none small text-muted">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Website Publik
            </a>
        </div>
    </div>
</div>
