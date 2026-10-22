<div class="mb-4">
    <a href="<?= Helper::url('admin/events') ?>" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Agenda Kegiatan
    </a>
    <h4 class="fw-bold m-0 mt-1">Tambah Agenda Kegiatan Baru</h4>
</div>

<div class="admin-card">
    <div class="admin-card-body p-4">
        <form action="<?= Helper::url('admin/events/store') ?>" method="POST" enctype="multipart/form-data">
            <?= Csrf::field() ?>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label for="title" class="form-label small fw-bold">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Contoh: Yasinan & Tahlil Malam Jum'at" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label small fw-bold">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="8" placeholder="Jelaskan susunan acara, pemateri, pembimbing kajian, atau hal yang perlu dibawa jamaah..." required></textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="location" class="form-label small fw-bold">Tempat / Lokasi</label>
                            <input type="text" class="form-control" id="location" name="location" value="Musholla Ar-rahman Gembor Periuk">
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label small fw-bold">Kategori Kegiatan</label>
                            <select class="form-select" id="category" name="category">
                                <option value="Ibadah Harian">Ibadah Harian</option>
                                <option value="Mingguan">Mingguan</option>
                                <option value="Bulanan">Bulanan</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Sosial">Sosial & Gotong Royong</option>
                                <option value="PHBI">PHBI (Peringatan Hari Besar Islam)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <h6 class="fw-bold mb-3">Waktu & Jadwal</h6>

                        <div class="mb-3">
                            <label for="event_date" class="form-label small fw-bold">Tanggal Kegiatan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" id="event_date" name="event_date" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label for="start_time" class="form-label small fw-bold">Jam Mulai</label>
                                <input type="text" class="form-control form-control-sm" id="start_time" name="start_time" value="18:15" placeholder="HH:MM">
                            </div>
                            <div class="col-6">
                                <label for="end_time" class="form-label small fw-bold">Jam Selesai</label>
                                <input type="text" class="form-control form-control-sm" id="end_time" name="end_time" value="Selesai" placeholder="HH:MM / Selesai">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label small fw-bold">Status</label>
                            <select class="form-select form-select-sm" id="status" name="status">
                                <option value="Mendatang">Mendatang</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 border">
                        <h6 class="fw-bold mb-2">Foto / Pamflet</h6>
                        <input type="file" class="form-control form-control-sm mb-2" id="image" name="image" accept="image/*" data-preview="preview-evt-img">
                        <small class="text-muted d-block mb-2">Format: JPG, PNG, WEBP (Maks 8MB)</small>
                        <img id="preview-evt-img" src="" alt="Preview" class="img-fluid rounded border shadow-sm w-100" style="display:none; max-height: 180px; object-fit: cover;">
                    </div>
                </div>

                <div class="col-12 border-top pt-3 d-flex justify-content-end gap-2">
                    <a href="<?= Helper::url('admin/events') ?>" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-calendar-check me-1"></i> Simpan Kegiatan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
