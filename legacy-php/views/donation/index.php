<?php
$musholaName = $globalSettings['mushola_name'] ?? 'Musholla Ar-rahman';
$bankName = $globalSettings['donation_bank'] ?? 'Bank BJB';
$bankAccount = $globalSettings['donation_account'] ?? '0152632533100';
$bankHolder = $globalSettings['donation_holder'] ?? 'Musholla Ar-rahman';
$notes = $globalSettings['donation_notes'] ?? 'Donasi dapat ditransfer melalui rekening resmi Bank BJB di atas. Mohon konfirmasi via WhatsApp ke nomor pengurus agar pencatatan infaq/sedekah tertib dan amanah.';
$phone1 = $globalSettings['phone_1'] ?? '0813-8619-8079';
$phone2 = $globalSettings['phone_2'] ?? '0812-9465-6075';
$qrisImage = !empty($globalSettings['qris_image']) ? Helper::uploadUrl($globalSettings['qris_image']) : Helper::asset('images/default-qris.svg');
?>

<!-- Header Donasi -->
<section class="py-5 bg-white border-bottom">
    <div class="container text-center py-4">
        <span class="badge bg-warning-subtle text-warning-emphasis fw-bold px-3 py-2 rounded-pill mb-2">AMAL JARIYAH</span>
        <h1 class="fw-bold mb-2">Infaq, Sedekah & Donasi Musholla Ar-rahman</h1>
        <p class="text-muted m-0">Menabung pahala abadi untuk memakmurkan rumah Allah dan sarana ibadah umat</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <?php if ($isActive): ?>
            <div class="row g-4 align-items-center mb-5">
                <!-- Kolom Rekening Bank -->
                <div class="col-lg-7">
                    <div class="donation-card mb-4">
                        <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill mb-3">REKENING RESMI</span>
                        <h3 class="text-white fw-bold mb-3">Transfer Bank Resmi</h3>
                        <p class="text-white-50 mb-4">
                            Salurkan infaq operasional musholla, santunan yatim/dhuafa, atau wakaf sarana tempat ibadah melalui rekening resmi berikut:
                        </p>

                        <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-25 mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="bank-badge"><?= htmlspecialchars($bankName) ?></span>
                                <small class="text-white-50">KCP Tangerang</small>
                            </div>
                            <div class="mb-2">
                                <small class="text-white-50 d-block">Nomor Rekening:</small>
                                <span class="account-number"><?= htmlspecialchars($bankAccount) ?></span>
                            </div>
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 border-top border-white border-opacity-25 pt-2">
                                <span class="text-white small">Atas Nama: <strong><?= htmlspecialchars($bankHolder) ?></strong></span>
                                <button class="btn btn-gold btn-sm btn-copy-account" data-account="<?= htmlspecialchars($bankAccount) ?>">
                                    <i class="bi bi-clipboard me-1"></i> Salin Nomor Rekening
                                </button>
                            </div>
                        </div>

                        <p class="text-white-50 small m-0">
                            <i class="bi bi-shield-lock-fill text-warning me-1"></i> Pastikan nama pemilik rekening tujuan sesuai sebelum menyelesaikan transaksi transfer.
                        </p>
                    </div>

                    <!-- Petunjuk & Konfirmasi -->
                    <div class="bg-white border rounded-4 p-4 shadow-sm">
                        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle-fill text-success me-2"></i>Tata Cara & Konfirmasi Donasi</h5>
                        <ol class="text-muted leading-relaxed small ps-3 mb-4">
                            <li class="mb-2">Lakukan transfer melalui ATM, Mobile Banking, atau Internet Banking ke rekening <strong><?= htmlspecialchars($bankName) ?> <?= htmlspecialchars($bankAccount) ?></strong> a/n <?= htmlspecialchars($bankHolder) ?>.</li>
                            <li class="mb-2">Simpan bukti transfer / struk pembayaran perbankan Anda.</li>
                            <li class="mb-2">Kirimkan konfirmasi dan bukti transfer kepada bendahara atau pengurus DKM melalui WhatsApp agar dapat dicatat dalam buku kas laporan keuangan musholla.</li>
                        </ol>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="https://wa.me/62<?= preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', $phone1)) ?>?text=<?= urlencode("Assalamu'alaikum Pengurus DKM Musholla Ar-rahman, saya telah menyalurkan donasi/infaq via Bank BJB. Berikut kami lampirkan bukti transfer.") ?>" target="_blank" rel="noopener" class="btn btn-success fw-bold">
                                <i class="bi bi-whatsapp me-1"></i> Konfirmasi ke Pengurus 1 (<?= htmlspecialchars($phone1) ?>)
                            </a>
                            <a href="https://wa.me/62<?= preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', $phone2)) ?>?text=<?= urlencode("Assalamu'alaikum Bendahara DKM Musholla Ar-rahman, saya telah transfer donasi via Bank BJB. Mohon dicatat.") ?>" target="_blank" rel="noopener" class="btn btn-outline-success fw-bold">
                                <i class="bi bi-whatsapp me-1"></i> Konfirmasi ke Pengurus 2 (<?= htmlspecialchars($phone2) ?>)
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Kolom QRIS -->
                <div class="col-lg-5 text-center">
                    <div class="bg-white border rounded-4 p-4 shadow-lg">
                        <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold mb-3">METODE CEPAT QRIS</span>
                        <h5 class="fw-bold mb-2">Scan QRIS Musholla Ar-rahman</h5>
                        <p class="text-muted small mb-3">Mendukung seluruh aplikasi mobile banking (BCA, Mandiri, BRI, BNI, BSI) dan dompet digital (Gopay, OVO, Dana, LinkAja, ShopeePay).</p>
                        
                        <div class="p-2 border rounded-3 bg-light d-inline-block mb-3">
                            <img src="<?= htmlspecialchars($qrisImage) ?>" alt="QRIS Resmi Musholla Ar-rahman" class="img-fluid rounded" style="max-width: 280px;">
                        </div>

                        <div class="p-3 bg-light rounded-3 text-start small border">
                            <span class="fw-bold d-block text-dark mb-1"><i class="bi bi-check2-circle text-success me-1"></i> Keunggulan Donasi Non-Tunai:</span>
                            <span class="text-muted d-block">• Aman, langsung masuk ke rekening kas DKM</span>
                            <span class="text-muted d-block">• Tanpa potongan biaya untuk infaq sosial</span>
                            <span class="text-muted d-block">• Memudahkan sedekah kapan saja dari rumah</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning border text-center p-5 rounded-4 shadow-sm">
                <i class="bi bi-exclamation-circle fs-1 text-warning d-block mb-2"></i>
                <h4 class="fw-bold">Penerimaan Donasi Online Sedang Dinonaktifkan</h4>
                <p class="text-muted mb-3">Saat ini penerimaan donasi melalui website sedang ditutup atau dalam proses pembaharuan rekening pengurus.</p>
                <a href="<?= Helper::url('kontak') ?>" class="btn btn-outline-dark fw-bold">Hubungi Pengurus DKM</a>
            </div>
        <?php endif; ?>
    </div>
</section>
