<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold m-0">Manajemen Akun Admin & Editor</h4>
        <small class="text-muted">Kelola kredensial pengurus dan hak akses modul</small>
    </div>
    <a href="<?= Helper::url('admin/users/create') ?>" class="btn btn-primary-custom">
        <i class="bi bi-person-plus-fill me-1"></i> Tambah Akun Pengurus
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        <?php if (!empty($users)): ?>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Hak Akses (Role)</th>
                            <th>Status</th>
                            <th>Login Terakhir</th>
                            <th style="width: 120px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td>
                                    <strong class="text-dark"><?= htmlspecialchars($u['name']) ?></strong>
                                    <?php if ($u['id'] == Auth::id()): ?>
                                        <span class="badge bg-primary-subtle text-primary ms-1 small">Anda</span>
                                    <?php endif; ?>
                                </td>
                                <td><code class="text-dark"><?= htmlspecialchars($u['username']) ?></code></td>
                                <td class="small text-muted"><?= htmlspecialchars($u['email']) ?></td>
                                <td>
                                    <span class="badge <?= $u['role'] === 'super_admin' ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-success-subtle text-success border border-success-subtle' ?>">
                                        <?= $u['role'] === 'super_admin' ? 'Super Admin' : 'Editor Konten' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $u['is_active'] ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $u['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </td>
                                <td class="small text-muted">
                                    <?= !empty($u['last_login']) ? Helper::formatDate($u['last_login'], true) : 'Belum pernah' ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?= Helper::url('admin/users/edit/' . $u['id']) ?>" class="btn btn-sm btn-outline-primary" title="Edit Akun">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if ($u['id'] != Auth::id()): ?>
                                            <form action="<?= Helper::url('admin/users/delete/' . $u['id']) ?>" method="POST" class="d-inline">
                                                <?= Csrf::field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm" data-title="Akun <?= htmlspecialchars($u['name']) ?>" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-people fs-1 text-muted d-block mb-2"></i>
                <p class="text-muted m-0">Belum ada akun pengurus terdaftar.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
