<!-- Header Laporan Keuangan -->
<section class="py-5 bg-white border-bottom">
    <div class="container text-center py-4">
        <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">TRANSPARANSI KAS</span>
        <h1 class="fw-bold mb-2">Laporan Kas Keuangan Musholla Ar-rahman</h1>
        <p class="text-muted m-0">Keterbukaan informasi pengelolaan infaq dan sedekah jamaah secara amanah dan bertanggung jawab</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <?php if ($isActive): ?>
            <!-- Ringkasan Saldo Berjalan -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="p-3 bg-white border rounded-4 shadow-sm text-center">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.75rem;">Total Pemasukan Kas</small>
                        <h4 class="fw-bold text-success m-0 mt-1"><?= Helper::formatRupiah($summary['total_income'] ?? 0) ?></h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-white border rounded-4 shadow-sm text-center">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.75rem;">Total Pengeluaran Kas</small>
                        <h4 class="fw-bold text-danger m-0 mt-1"><?= Helper::formatRupiah($summary['total_expense'] ?? 0) ?></h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded-4 shadow-sm text-center text-white" style="background: linear-gradient(135deg, #075B4A 0%, #053E32 100%);">
                        <small class="text-white-50 d-block text-uppercase fw-bold" style="font-size:0.75rem;">Saldo Kas Saat Ini</small>
                        <h4 class="fw-bold text-warning m-0 mt-1"><?= Helper::formatRupiah($summary['current_balance'] ?? 0) ?></h4>
                    </div>
                </div>
            </div>

            <!-- Tabel Laporan Bulanan -->
            <div class="bg-white border rounded-4 p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold m-0"><i class="bi bi-file-earmark-spreadsheet-fill text-success me-2"></i>Rekap Laporan Per Periode</h5>
                    <small class="text-muted"><i class="bi bi-check-circle-fill text-success me-1"></i> Disetujui Bendahara DKM</small>
                </div>

                <?php if (!empty($reports)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 140px;">Periode</th>
                                    <th scope="col">Pemasukan</th>
                                    <th scope="col">Pengeluaran</th>
                                    <th scope="col">Saldo Periode</th>
                                    <th scope="col">Keterangan / Catatan Alokasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $months = [
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                ];
                                foreach ($reports as $rep):
                                    $mName = $months[(int)$rep['period_month']] ?? $rep['period_month'];
                                ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-light text-dark border fw-bold px-2 py-1">
                                                <?= htmlspecialchars($mName) ?> <?= (int)$rep['period_year'] ?>
                                            </span>
                                        </td>
                                        <td class="text-success fw-bold">
                                            + <?= Helper::formatRupiah($rep['income']) ?>
                                        </td>
                                        <td class="text-danger fw-bold">
                                            - <?= Helper::formatRupiah($rep['expense']) ?>
                                        </td>
                                        <td>
                                            <strong class="<?= $rep['balance'] >= 0 ? 'text-primary' : 'text-danger' ?>">
                                                <?= Helper::formatRupiah($rep['balance']) ?>
                                            </strong>
                                        </td>
                                        <td class="small text-muted">
                                            <?= htmlspecialchars($rep['description'] ?? '-') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4 m-0">Belum ada laporan kas periode yang dipublikasikan.</p>
                <?php endif; ?>
            </div>

            <div class="mt-4 p-3 bg-light rounded-3 border small text-muted">
                <i class="bi bi-shield-check text-success me-1"></i>
                <strong>Catatan Transparansi:</strong> Seluruh laporan kas di atas telah diverifikasi oleh Bendahara <em>(Bapak Suwadi)</em> dan disetujui oleh Ketua DKM <em>(Ustadz Tata A.S)</em>. Rincian nota fisik dan buku kas dapat diperiksa langsung di kantor sekretariat musholla oleh warga jamaah.
            </div>
        <?php else: ?>
            <div class="alert alert-light border text-center p-5 rounded-4 shadow-sm">
                <i class="bi bi-lock-fill fs-1 text-muted d-block mb-2"></i>
                <h4 class="fw-bold text-muted">Modul Laporan Kas Sedang Ditutup</h4>
                <p class="text-muted small m-0">Laporan kas hanya dipublikasikan pada periode tertentu sesuai persetujuan rapat DKM.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
