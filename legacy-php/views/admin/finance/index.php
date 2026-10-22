<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold m-0">Laporan Kas Keuangan</h4>
        <small class="text-muted">Pencatatan pemasukan, pengeluaran, dan saldo kas musholla</small>
    </div>
    <a href="<?= Helper::url('admin/finance/create') ?>" class="btn btn-primary-custom">
        <i class="bi bi-plus-circle me-1"></i> Catat Laporan Kas Baru
    </a>
</div>

<!-- Ringkasan Saldo -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-arrow-down-left-circle"></i></div>
            <div class="stat-info">
                <h3><?= Helper::formatRupiah($summary['total_income'] ?? 0) ?></h3>
                <p>Total Pemasukan Kas</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon gold"><i class="bi bi-arrow-up-right-circle"></i></div>
            <div class="stat-info">
                <h3><?= Helper::formatRupiah($summary['total_expense'] ?? 0) ?></h3>
                <p>Total Pengeluaran Kas</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-wallet2"></i></div>
            <div class="stat-info">
                <h3 class="text-primary"><?= Helper::formatRupiah($summary['current_balance'] ?? 0) ?></h3>
                <p>Saldo Kas Berjalan</p>
            </div>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="fw-bold m-0"><i class="bi bi-table text-success me-2"></i>Daftar Laporan Per Periode</h5>
    </div>
    <div class="admin-card-body p-0">
        <?php if (!empty($reports)): ?>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th>Pemasukan</th>
                            <th>Pengeluaran</th>
                            <th>Saldo Periode</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th style="width: 120px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $months = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        foreach ($reports as $r):
                            $mName = $months[(int)$r['period_month']] ?? $r['period_month'];
                        ?>
                            <tr>
                                <td>
                                    <strong class="d-block text-dark"><?= htmlspecialchars($mName) ?> <?= (int)$r['period_year'] ?></strong>
                                </td>
                                <td class="text-success fw-bold">+ <?= Helper::formatRupiah($r['income']) ?></td>
                                <td class="text-danger fw-bold">- <?= Helper::formatRupiah($r['expense']) ?></td>
                                <td class="fw-bold <?= $r['balance'] >= 0 ? 'text-primary' : 'text-danger' ?>">
                                    <?= Helper::formatRupiah($r['balance']) ?>
                                </td>
                                <td class="small text-muted"><?= htmlspecialchars($r['description'] ?? '-') ?></td>
                                <td>
                                    <span class="badge <?= $r['status'] === 'Terbit' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= htmlspecialchars($r['status']) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?= Helper::url('admin/finance/edit/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?= Helper::url('admin/finance/delete/' . $r['id']) ?>" method="POST" class="d-inline">
                                            <?= Csrf::field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm" data-title="Laporan Periode <?= htmlspecialchars($mName) ?> <?= (int)$r['period_year'] ?>" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-cash-stack fs-1 text-muted d-block mb-2"></i>
                <p class="text-muted m-0">Belum ada catatan laporan kas.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
