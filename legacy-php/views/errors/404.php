<div class="container py-5 my-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="p-5 bg-white border rounded-4 shadow-sm">
                <i class="bi bi-compass fs-1 text-success d-block mb-3"></i>
                <h1 class="display-4 fw-bold text-dark">404</h1>
                <h4 class="fw-bold mb-3">Halaman Tidak Ditemukan</h4>
                <p class="text-muted small mb-4">
                    Mohon maaf, halaman yang Anda cari mungkin telah dipindahkan, dihapus, atau tautan yang Anda masukkan kurang tepat.
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="<?= Helper::url() ?>" class="btn btn-primary-custom">
                        <i class="bi bi-house-door-fill me-1"></i> Kembali ke Beranda
                    </a>
                    <a href="<?= Helper::url('kontak') ?>" class="btn btn-outline-secondary">
                        Hubungi Pengurus
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
