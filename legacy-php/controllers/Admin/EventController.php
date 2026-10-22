<?php
/**
 * Admin Event Controller (CRUD Kegiatan Musholla)
 */

class AdminEventController extends Controller {
    public function index(): void {
        Auth::requireAuth();

        $eventModel = new Event();
        $filter = $_GET['filter'] ?? 'all';
        $events = $eventModel->getAllAdmin($filter);

        $this->render('admin/events/index', [
            'title'  => 'Manajemen Agenda Kegiatan',
            'events' => $events,
            'filter' => $filter
        ], 'admin');
    }

    public function create(): void {
        Auth::requireAuth();

        $this->render('admin/events/create', [
            'title' => 'Tambah Kegiatan Baru'
        ], 'admin');
    }

    public function store(): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $event_date = $_POST['event_date'] ?? date('Y-m-d');
        $start_time = trim($_POST['start_time'] ?? '18:00');
        $end_time = trim($_POST['end_time'] ?? 'Selesai');
        $location = trim($_POST['location'] ?? 'Musholla Ar-rahman');
        $category = $_POST['category'] ?? 'Rutin';
        $status = $_POST['status'] ?? 'Mendatang';

        if (empty($title) || empty($description)) {
            Session::setFlash('error', 'Nama kegiatan dan deskripsi wajib diisi.');
            $this->redirect('admin/events/create');
            return;
        }

        $slug = Helper::slug($title);
        $eventModel = new Event();
        $baseSlug = $slug;
        $counter = 1;
        while ($eventModel->count("slug = :s", [':s' => $slug]) > 0) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $image = '';
        if (!empty($_FILES['image']['name'])) {
            $uploaded = Uploader::uploadImage($_FILES['image'], 'event');
            if ($uploaded) {
                $image = $uploaded;
            }
        }

        $eventModel->create([
            'title'       => $title,
            'slug'        => $slug,
            'description' => $description,
            'image'       => $image,
            'event_date'  => $event_date,
            'start_time'  => $start_time,
            'end_time'    => $end_time,
            'location'    => $location,
            'category'    => $category,
            'status'      => $status
        ]);

        Session::setFlash('success', 'Kegiatan baru berhasil ditambahkan.');
        $this->redirect('admin/events');
    }

    public function edit(string $id): void {
        Auth::requireAuth();
        $eventModel = new Event();
        $event = $eventModel->find((int)$id);

        if (!$event) {
            Session::setFlash('error', 'Kegiatan tidak ditemukan.');
            $this->redirect('admin/events');
            return;
        }

        $this->render('admin/events/edit', [
            'title' => 'Edit Kegiatan',
            'event' => $event
        ], 'admin');
    }

    public function update(string $id): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $eventModel = new Event();
        $event = $eventModel->find((int)$id);
        if (!$event) {
            Session::setFlash('error', 'Kegiatan tidak ditemukan.');
            $this->redirect('admin/events');
            return;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $event_date = $_POST['event_date'] ?? $event['event_date'];
        $start_time = trim($_POST['start_time'] ?? '18:00');
        $end_time = trim($_POST['end_time'] ?? 'Selesai');
        $location = trim($_POST['location'] ?? 'Musholla Ar-rahman');
        $category = $_POST['category'] ?? 'Rutin';
        $status = $_POST['status'] ?? 'Mendatang';

        if (empty($title) || empty($description)) {
            Session::setFlash('error', 'Nama kegiatan dan deskripsi wajib diisi.');
            $this->redirect('admin/events/edit/' . $id);
            return;
        }

        $slug = Helper::slug($title);
        $baseSlug = $slug;
        $counter = 1;
        while ($eventModel->count("slug = :s AND id != :id", [':s' => $slug, ':id' => $id]) > 0) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $image = $event['image'];
        if (!empty($_FILES['image']['name'])) {
            $uploaded = Uploader::uploadImage($_FILES['image'], 'event');
            if ($uploaded) {
                Uploader::deleteFile($image);
                $image = $uploaded;
            }
        }

        $eventModel->update((int)$id, [
            'title'       => $title,
            'slug'        => $slug,
            'description' => $description,
            'image'       => $image,
            'event_date'  => $event_date,
            'start_time'  => $start_time,
            'end_time'    => $end_time,
            'location'    => $location,
            'category'    => $category,
            'status'      => $status
        ]);

        Session::setFlash('success', 'Kegiatan berhasil diperbarui.');
        $this->redirect('admin/events');
    }

    public function delete(string $id): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $eventModel = new Event();
        $event = $eventModel->find((int)$id);
        if ($event) {
            Uploader::deleteFile($event['image']);
            $eventModel->delete((int)$id);
            Session::setFlash('success', 'Kegiatan berhasil dihapus.');
        }

        $this->redirect('admin/events');
    }
}
