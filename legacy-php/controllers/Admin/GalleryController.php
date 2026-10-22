<?php
/**
 * Admin Gallery Controller
 */

class AdminGalleryController extends Controller {
    public function index(): void {
        Auth::requireAuth();

        $galleryModel = new Gallery();
        $galleries = $galleryModel->getGalleries(null, 100);

        $this->render('admin/gallery/index', [
            'title'     => 'Manajemen Galeri & Foto Dokumentasi',
            'galleries' => $galleries
        ], 'admin');
    }

    public function upload(): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $title = trim($_POST['title'] ?? 'Dokumentasi Musholla');
        $category = $_POST['category'] ?? 'Kegiatan';
        $alt_text = trim($_POST['alt_text'] ?? $title);

        if (empty($_FILES['image']['name'])) {
            Session::setFlash('error', 'Pilih file foto terlebih dahulu.');
            $this->redirect('admin/gallery');
            return;
        }

        $uploaded = Uploader::uploadImage($_FILES['image'], 'gallery');
        if (!$uploaded) {
            $this->redirect('admin/gallery');
            return;
        }

        $galleryModel = new Gallery();
        $galleryModel->create([
            'title'    => $title,
            'image'    => $uploaded,
            'category' => $category,
            'alt_text' => $alt_text
        ]);

        Session::setFlash('success', 'Foto dokumentasi berhasil diunggah.');
        $this->redirect('admin/gallery');
    }

    public function update(string $id): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $title = trim($_POST['title'] ?? '');
        $category = $_POST['category'] ?? 'Kegiatan';
        $alt_text = trim($_POST['alt_text'] ?? $title);

        if (empty($title)) {
            Session::setFlash('error', 'Keterangan foto tidak boleh kosong.');
            $this->redirect('admin/gallery');
            return;
        }

        $galleryModel = new Gallery();
        $galleryModel->update((int)$id, [
            'title'    => $title,
            'category' => $category,
            'alt_text' => $alt_text
        ]);

        Session::setFlash('success', 'Keterangan foto berhasil diperbarui.');
        $this->redirect('admin/gallery');
    }

    public function delete(string $id): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $galleryModel = new Gallery();
        $item = $galleryModel->find((int)$id);
        if ($item) {
            Uploader::deleteFile($item['image']);
            $galleryModel->delete((int)$id);
            Session::setFlash('success', 'Foto berhasil dihapus.');
        }

        $this->redirect('admin/gallery');
    }
}
