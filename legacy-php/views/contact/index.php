<?php
$musholaName = $globalSettings['mushola_name'] ?? 'Musholla Ar-rahman';
$address = $globalSettings['address'] ?? 'Jl. Anyer RT 007 RW 07, Kelurahan Gembor, Kecamatan Periuk, Kota Tangerang, Banten 15133';
$phone1 = $globalSettings['phone_1'] ?? '0813-8619-8079';
$phone2 = $globalSettings['phone_2'] ?? '0812-9465-6075';
$email = $globalSettings['email'] ?? 'dkm.musholla.arrahman@gmail.com';
$mapsUrl = $globalSettings['maps_url'] ?? 'https://maps.app.goo.gl/JZzSrDEKjCseGwgw7?g_st=aw';
$mapsEmbed = $globalSettings['maps_embed'] ?? '';
?>

<!-- Header Kontak -->
<section class="py-5 bg-white border-bottom">
    <div class="container text-center py-4">
        <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">SILATURAHMI</span>
        <h1 class="fw-bold mb-2">Hubungi Pengurus <?= htmlspecialchars($musholaName) ?></h1>
        <p class="text-muted m-0">Kami menyambut baik setiap pertanyaan, saran, maupun permohonan koordinasi ibadah warga</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Kolom Informasi Kontak & Pengurus -->
            <div class="col-lg-5">
                <div class="bg-white border rounded-4 p-4 shadow-sm mb-4">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Informasi Kontak & Sekretariat</h5>
                    
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="p-2 bg-success text-white rounded-3">
                            <i class="bi bi-geo-alt-fill fs-5"></i>
                        </div>
                        <div>
                            <strong class="d-block text-dark">Alamat Musholla:</strong>
                            <p class="text-muted small m-0 leading-relaxed"><?= htmlspecialchars($address) ?></p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="p-2 bg-success text-white rounded-3">
                            <i class="bi bi-whatsapp fs-5"></i>
                        </div>
                        <div>
                            <strong class="d-block text-dark">WhatsApp Pengurus DKM:</strong>
                            <div class="d-flex flex-column gap-1 mt-1">
                                <a href="https://wa.me/62<?= preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', $phone1)) ?>" target="_blank" rel="noopener" class="text-success small fw-bold text-decoration-none">
                                    <i class="bi bi-chat-dots-fill me-1"></i> Kontak 1: <?= htmlspecialchars($phone1) ?>
                                </a>
                                <a href="https://wa.me/62<?= preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', $phone2)) ?>" target="_blank" rel="noopener" class="text-success small fw-bold text-decoration-none">
                                    <i class="bi bi-chat-dots-fill me-1"></i> Kontak 2: <?= htmlspecialchars($phone2) ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="p-2 bg-success text-white rounded-3">
                            <i class="bi bi-envelope-fill fs-5"></i>
                        </div>
                        <div>
                            <strong class="d-block text-dark">Surat Elektronik (Email):</strong>
                            <span class="text-muted small"><?= htmlspecialchars($email) ?></span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="p-2 bg-success text-white rounded-3">
                            <i class="bi bi-clock-fill fs-5"></i>
                        </div>
                        <div>
                            <strong class="d-block text-dark">Waktu Pelayanan:</strong>
                            <span class="text-muted small">Terbuka setiap saat waktu sholat berjamaah & Ba'da Maghrib/Isya</span>
                        </div>
                    </div>
                </div>

                <!-- Petunjuk Rute Maps -->
                <div class="p-4 rounded-4 text-white shadow-sm" style="background: linear-gradient(135deg, #075B4A 0%, #053E32 100%);">
                    <h6 class="fw-bold mb-2"><i class="bi bi-pin-map text-warning me-1"></i> Navigasi Menuju Musholla</h6>
                    <p class="text-white-50 small mb-3">Klik tombol berikut untuk membuka panduan arah jalan melalui aplikasi Google Maps di ponsel Anda.</p>
                    <a href="<?= htmlspecialchars($mapsUrl) ?>" target="_blank" rel="noopener" class="btn btn-gold btn-sm fw-bold w-100">
                        <i class="bi bi-compass-fill me-1"></i> Buka Google Maps Navigasi
                    </a>
                </div>
            </div>

            <!-- Kolom Form Kirim Pesan -->
            <div class="col-lg-7">
                <div class="bg-white border rounded-4 p-4 p-md-5 shadow-sm">
                    <h4 class="fw-bold mb-1">Kirim Pesan ke Pengurus</h4>
                    <p class="text-muted small mb-4">Silakan tinggalkan pesan, masukan, atau pertanyaan. Pengurus DKM akan merespon melalui WhatsApp atau telepon.</p>

                    <form action="<?= Helper::url('kontak/kirim') ?>" method="POST">
                        <?= Csrf::field() ?>

                        <!-- Spam Bot Honeypot -->
                        <div style="display:none;">
                            <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="input-name" class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="input-name" name="name" placeholder="Nama Anda..." required>
                            </div>

                            <div class="col-md-6">
                                <label for="input-phone" class="form-label small fw-bold">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="input-phone" name="phone" placeholder="Contoh: 08123456789" required>
                            </div>

                            <div class="col-md-6">
                                <label for="input-email" class="form-label small fw-bold">Alamat Email (Opsional)</label>
                                <input type="email" class="form-control" id="input-email" name="email" placeholder="nama@email.com">
                            </div>

                            <div class="col-md-6">
                                <label for="input-subject" class="form-label small fw-bold">Perihal / Topik Pesan</label>
                                <select class="form-select" id="input-subject" name="subject">
                                    <option value="Pertanyaan Umum">Pertanyaan Umum</option>
                                    <option value="Konfirmasi Donasi/Infaq">Konfirmasi Donasi/Infaq</option>
                                    <option value="Izin Koordinasi Kajian">Izin Koordinasi Kajian</option>
                                    <option value="Saran & Masukan">Saran & Masukan</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="input-message" class="form-label small fw-bold">Isi Pesan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="input-message" name="message" rows="5" placeholder="Tuliskan pesan Anda secara jelas di sini..." required></textarea>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary-custom w-100 py-2">
                                    <i class="bi bi-send-fill me-1"></i> Kirim Pesan Sekarang
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Google Maps Full Width Embed -->
        <div class="mt-5 rounded-4 overflow-hidden border shadow-sm">
            <iframe src="<?= htmlspecialchars($mapsEmbed) ?>" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Google Maps Musholla Ar-rahman"></iframe>
        </div>
    </div>
</section>
