<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold m-0">Kelola Agenda Kegiatan</h4>
        <small class="text-muted">Jadwal sholat berjamaah, yasinan malam Jum'at, dan pengajian rutin</small>
    </div>
    <a href="<?= Helper::url('admin/events/create') ?>" class="btn btn-primary-custom">
        <i class="bi bi-calendar-plus me-1"></i> Tambah Kegiatan Baru
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <div class="d-flex gap-2">
            <a href="<?= Helper::url('admin/events') ?>" class="btn btn-sm <?= ($filter === 'all') ? 'btn-success' : 'btn-light border' ?>">
                Semua Kegiatan
            </a>
            <a href="<?= Helper::url('admin/events?filter=upcoming') ?>" class="btn btn-sm <?= ($filter === 'upcoming') ? 'btn-success' : 'btn-light border' ?>">
                Mendatang
            </a>
            <a href="<?= Helper::url('admin/events?filter=past') ?>" class="btn btn-sm <?= ($filter === 'past') ? 'btn-success' : 'btn-light border' ?>">
                Selesai / Lampau
            </a>
        </div>
    </div>

    <div class="admin-card-body p-0">
        <?php if (!empty($events)): ?>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th style="width: 70px;">Foto</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal & Waktu</th>
                            <th>Lokasi</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th style="width: 130px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $evt): ?>
                            <tr>
                                <td>
                                    <img src="<?= Helper::uploadUrl($evt['image']) ?>" alt="Thumb" class="rounded object-fit-cover" width="55" height="42">
                                </td>
                                <td>
                                    <strong class="d-block text-dark"><?= htmlspecialchars($evt['title']) ?></strong>
                                    <small class="text-muted"><?= htmlspecialchars(Helper::limitWords($evt['description'], 8)) ?></small>
                                </td>
                                <td class="small">
                                    <strong class="text-dark d-block"><?= date('d/m/Y', strtotime($evt['event_date'])) ?></strong>
                                    <span class="text-muted"><?= htmlspecialchars($evt['start_time']) ?> - <?= htmlspecialchars($evt['end_time']) ?> WIB</span>
                                </td>
                                <td class="small text-muted"><?= htmlspecialchars($evt['location'] ?? '-') ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?= htmlspecialchars($evt['category'] ?? 'Rutin') ?></span>
                                </td>
                                <td>
                                    <span class="badge <?= $evt['status'] === 'Mendatang' ? 'bg-success' : ($evt['status'] === 'Selesai' ? 'bg-secondary' : 'bg-danger') ?>">
                                        <?= htmlspecialchars($evt['status']) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?= Helper::url('kegiatan/' . $evt['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Lihat di Web">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= Helper::url('admin/events/edit/' . $evt['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?= Helper::url('admin/events/delete/' . $evt['id']) ?>" method="POST" class="d-inline">
                                            <?= Csrf::field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm" data-title="<?= htmlspecialchars($evt['title']) ?>" title="Hapus">
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
                <i class="bi bi-calendar-x fs-1 text-muted d-block mb-2"></i>
                <p class="text-muted m-0">Tidak ada agenda kegiatan ditemukan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
