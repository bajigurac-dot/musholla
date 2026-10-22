<?php
/**
 * Public Post Controller (Berita & Pengumuman)
 */

class PostController extends Controller {
    public function index(): void {
        $postModel = new Post();

        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 6;
        $offset = ($page - 1) * $limit;

        $category = !empty($_GET['kategori']) ? trim($_GET['kategori']) : null;
        $search = !empty($_GET['q']) ? trim($_GET['q']) : null;

        $posts = $postModel->getPublished($limit, $offset, $category, $search);
        $total = $postModel->countPublished($category, $search);
        $totalPages = ceil($total / $limit);

        $this->render('posts/index', [
            'title'       => 'Berita & Pengumuman - Musholla Ar-rahman',
            'posts'       => $posts,
            'page'        => $page,
            'totalPages'  => $totalPages,
            'category'    => $category,
            'search'      => $search,
            'total'       => $total
        ]);
    }

    public function detail(string $slug): void {
        $postModel = new Post();
        $post = $postModel->findPublishedBySlug($slug);

        if (!$post) {
            $this->redirect('berita');
            return;
        }

        // Increment hit counter
        $postModel->incrementViews($post['id']);

        $recent = $postModel->getRecent(4);

        $this->render('posts/detail', [
            'title'  => e($post['title']) . ' - Musholla Ar-rahman',
            'post'   => $post,
            'recent' => $recent
        ]);
    }
}
