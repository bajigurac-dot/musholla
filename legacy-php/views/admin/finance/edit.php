<div class="mb-4">
    <a href="<?= Helper::url('admin/finance') ?>" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Laporan Kas
    </a>
    <h4 class="fw-bold m-0 mt-1">Edit Laporan Kas Keuangan</h4>
</div>

<div class="admin-card">
    <div class="admin-card-body p-4">
        <form action="<?= Helper::url('admin/finance/update/' . $report['id']) ?>" method="POST">
            <?= Csrf::field() ?>

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="period_month" class="form-label small fw-bold">Bulan Periode <span class="text-danger">*</span></label>
                    <select class="form-select" id="period_month" name="period_month" required>
                        <?php
                        $months = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        foreach ($months as $num => $name):
                        ?>
                            <option value="<?= $num ?>" <?= ((int)$report['period_month'] === $num) ? 'selected' : '' ?>><?= $name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="period_year" class="form-label small fw-bold">Tahun Periode <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="period_year" name="period_year" value="<?= htmlspecialchars($report['period_year']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label for="input-income" class="form-label small fw-bold">Total Pemasukan (Rp) <span class="text-danger">*</span></label>
                    <input type="number" step="1000" class="form-control" id="input-income" name="income" value="<?= (float)$report['income'] ?>" required>
                </div>

                <div class="col-md-6">
                    <label for="input-expense" class="form-label small fw-bold">Total Pengeluaran (Rp) <span class="text-danger">*</span></label>
                    <input type="number" step="1000" class="form-control" id="input-expense" name="expense" value="<?= (float)$report['expense'] ?>" required>
                </div>

                <!-- Preview Saldo Otomatis -->
                <div class="col-12">
                    <div class="p-3 bg-light rounded-3 border d-flex justify-content-between align-items-center">
                        <span class="small fw-bold text-dark">Kalkulasi Saldo Periode Ini:</span>
                        <span id="preview-balance" class="fw-bold fs-5 text-success"><?= Helper::formatRupiah($report['balance']) ?></span>
                    </div>
                </div>

                <div class="col-12">
                    <label for="description" class="form-label small fw-bold">Catatan & Keterangan Alokasi</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($report['description'] ?? '') ?></textarea>
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label small fw-bold">Status Publikasi</label>
                    <select class="form-select form-select-sm" id="status" name="status">
                        <option value="Terbit" <?= ($report['status'] === 'Terbit') ? 'selected' : '' ?>>Terbit (Tampil di Website Publik)</option>
                        <option value="Draft" <?= ($report['status'] === 'Draft') ? 'selected' : '' ?>>Draft (Belum Dipublikasikan)</option>
                    </select>
                </div>

                <div class="col-12 border-top pt-3 d-flex justify-content-end gap-2">
                    <a href="<?= Helper::url('admin/finance') ?>" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
