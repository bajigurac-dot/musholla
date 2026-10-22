<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold m-0">Kotak Masuk Pesan Jamaah</h4>
        <small class="text-muted">Pesan, masukan, dan konfirmasi yang dikirimkan melalui formulir kontak website</small>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <?php if (!empty($messages)): ?>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">Status</th>
                            <th>Pengirim</th>
                            <th>Kontak</th>
                            <th>Perihal & Isi Pesan</th>
                            <th>Waktu Kirim</th>
                            <th style="width: 140px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                            <tr class="<?= empty($msg['is_read']) ? 'table-warning bg-opacity-25' : '' ?>">
                                <td class="text-center">
                                    <?php if (empty($msg['is_read'])): ?>
                                        <i class="bi bi-envelope-fill text-danger" title="Pesan Baru"></i>
                                    <?php else: ?>
                                        <i class="bi bi-envelope-open text-muted" title="Sudah Dibaca"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong class="d-block text-dark"><?= htmlspecialchars($msg['name']) ?></strong>
                                </td>
                                <td class="small">
                                    <?php if (!empty($msg['phone'])): ?>
                                        <a href="https://wa.me/62<?= preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', $msg['phone'])) ?>" target="_blank" rel="noopener" class="text-success text-decoration-none d-block fw-bold mb-1">
                                            <i class="bi bi-whatsapp"></i> <?= htmlspecialchars($msg['phone']) ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($msg['email'])): ?>
                                        <span class="text-muted d-block"><?= htmlspecialchars($msg['email']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border mb-1"><?= htmlspecialchars($msg['subject'] ?? 'Pesan') ?></span>
                                    <p class="text-dark small m-0 leading-relaxed"><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                                </td>
                                <td class="small text-muted"><?= Helper::formatDate($msg['created_at'], true) ?></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <?php if (!empty($msg['phone'])): ?>
                                            <a href="https://wa.me/62<?= preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', $msg['phone'])) ?>?text=<?= urlencode("Assalamu'alaikum wr wb Bapak/Ibu " . $msg['name'] . ", kami dari Pengurus DKM Musholla Ar-rahman menindaklanjuti pesan Anda mengenai: " . $msg['subject']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-success" title="Balas via WhatsApp">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (empty($msg['is_read'])): ?>
                                            <form action="<?= Helper::url('admin/messages/read/' . $msg['id']) ?>" method="POST" class="d-inline">
                                                <?= Csrf::field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Tandai Sudah Dibaca">
                                                    <i class="bi bi-check2"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <form action="<?= Helper::url('admin/messages/delete/' . $msg['id']) ?>" method="POST" class="d-inline">
                                            <?= Csrf::field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm" data-title="Pesan dari <?= htmlspecialchars($msg['name']) ?>" title="Hapus">
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
                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                <p class="text-muted m-0">Belum ada pesan yang masuk dari pengunjung.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
