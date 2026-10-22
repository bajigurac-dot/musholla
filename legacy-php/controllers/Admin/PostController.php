<?php
/**
 * Admin Post Controller (CRUD Berita & Pengumuman)
 */

class AdminPostController extends Controller {
    public function index(): void {
        Auth::requireAuth();

        $postModel = new Post();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $status = !empty($_GET['status']) ? trim($_GET['status']) : null;
        $category = !empty($_GET['kategori']) ? trim($_GET['kategori']) : null;
        $search = !empty($_GET['q']) ? trim($_GET['q']) : null;

        $posts = $postModel->getAllAdmin($limit, $offset, $status, $category, $search);
        $total = $postModel->countAllAdmin($status, $category, $search);
        $totalPages = ceil($total / $limit);

        $this->render('admin/posts/index', [
            'title'      => 'Manajemen Berita & Pengumuman',
            'posts'      => $posts,
            'page'       => $page,
            'totalPages' => $totalPages,
            'status'     => $status,
            'category'   => $category,
            'search'     => $search,
            'total'      => $total
        ], 'admin');
    }

    public function create(): void {
        Auth::requireAuth();

        $this->render('admin/posts/create', [
            'title' => 'Tulis Berita / Pengumuman Baru'
        ], 'admin');
    }

    public function store(): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $title = trim($_POST['title'] ?? '');
        $category = $_POST['category'] ?? 'Berita';
        $excerpt = trim($_POST['excerpt'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $status = $_POST['status'] ?? 'Terbit';
        $author = trim($_POST['author'] ?? Auth::user()['name']);

        if (empty($title) || empty($content)) {
            Session::setFlash('error', 'Judul dan isi artikel wajib diisi.');
            $this->redirect('admin/posts/create');
            return;
        }

        $slug = Helper::slug($title);
        // Pastikan slug unik
        $postModel = new Post();
        $baseSlug = $slug;
        $counter = 1;
        while ($postModel->count("slug = :s", [':s' => $slug]) > 0) {
            $slug = $baseSlug . '-' . $counter++;
        }

        // Upload gambar utama jika ada
        $image = '';
        if (!empty($_FILES['image']['name'])) {
            $uploaded = Uploader::uploadImage($_FILES['image'], 'post');
            if ($uploaded) {
                $image = $uploaded;
            }
        }

        if (empty($excerpt)) {
            $excerpt = Helper::limitWords($content, 30);
        }

        $postModel->create([
            'title'    => $title,
            'slug'     => $slug,
            'category' => $category,
            'excerpt'  => $excerpt,
            'content'  => $content,
            'image'    => $image,
            'author'   => $author,
            'status'   => $status
        ]);

        Session::setFlash('success', 'Berita/Pengumuman berhasil diterbitkan.');
        $this->redirect('admin/posts');
    }

    public function edit(string $id): void {
        Auth::requireAuth();
        $postModel = new Post();
        $post = $postModel->find((int)$id);

        if (!$post) {
            Session::setFlash('error', 'Artikel tidak ditemukan.');
            $this->redirect('admin/posts');
            return;
        }

        $this->render('admin/posts/edit', [
            'title' => 'Edit Berita / Pengumuman',
            'post'  => $post
        ], 'admin');
    }

    public function update(string $id): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $postModel = new Post();
        $post = $postModel->find((int)$id);
        if (!$post) {
            Session::setFlash('error', 'Artikel tidak ditemukan.');
            $this->redirect('admin/posts');
            return;
        }

        $title = trim($_POST['title'] ?? '');
        $category = $_POST['category'] ?? 'Berita';
        $excerpt = trim($_POST['excerpt'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $status = $_POST['status'] ?? 'Terbit';
        $author = trim($_POST['author'] ?? $post['author']);

        if (empty($title) || empty($content)) {
            Session::setFlash('error', 'Judul dan isi artikel wajib diisi.');
            $this->redirect('admin/posts/edit/' . $id);
            return;
        }

        $slug = Helper::slug($title);
        // Pastikan slug unik selain ID ini
        $baseSlug = $slug;
        $counter = 1;
        while ($postModel->count("slug = :s AND id != :id", [':s' => $slug, ':id' => $id]) > 0) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $image = $post['image'];
        if (!empty($_FILES['image']['name'])) {
            $uploaded = Uploader::uploadImage($_FILES['image'], 'post');
            if ($uploaded) {
                // Hapus gambar lama jika ada
                Uploader::deleteFile($image);
                $image = $uploaded;
            }
        }

        if (empty($excerpt)) {
            $excerpt = Helper::limitWords($content, 30);
        }

        $postModel->update((int)$id, [
            'title'    => $title,
            'slug'     => $slug,
            'category' => $category,
            'excerpt'  => $excerpt,
            'content'  => $content,
            'image'    => $image,
            'author'   => $author,
            'status'   => $status
        ]);

        Session::setFlash('success', 'Perubahan artikel berhasil disimpan.');
        $this->redirect('admin/posts');
    }

    public function delete(string $id): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $postModel = new Post();
        $post = $postModel->find((int)$id);
        if ($post) {
            Uploader::deleteFile($post['image']);
            $postModel->delete((int)$id);
            Session::setFlash('success', 'Artikel berhasil dihapus.');
        }

        $this->redirect('admin/posts');
    }
}
