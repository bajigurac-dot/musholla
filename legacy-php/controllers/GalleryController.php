<?php
/**
 * Public Gallery Controller
 */

class GalleryController extends Controller {
    public function index(): void {
        $galleryModel = new Gallery();

        $category = !empty($_GET['kategori']) ? trim($_GET['kategori']) : 'Semua';
        $galleries = $galleryModel->getGalleries($category === 'Semua' ? null : $category, 60);
        $categories = $galleryModel->getCategories();

        $this->render('gallery/index', [
            'title'           => 'Galeri & Dokumentasi Kegiatan - Musholla Ar-rahman',
            'galleries'       => $galleries,
            'categories'      => $categories,
            'currentCategory' => $category
        ]);
    }
}
