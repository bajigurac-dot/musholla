<?php
/**
 * Post Model (Berita & Pengumuman)
 */

class Post extends Model {
    protected string $table = 'posts';

    public function findPublishedBySlug(string $slug): ?array {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE slug = :slug AND status = 'Terbit' LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getPublished(int $limit = 6, int $offset = 0, ?string $category = null, ?string $search = null): array {
        $where = "status = 'Terbit'";
        $params = [];

        if (!empty($category)) {
            $where .= " AND category = :cat";
            $params[':cat'] = $category;
        }

        if (!empty($search)) {
            $where .= " AND (title LIKE :s1 OR content LIKE :s2)";
            $params[':s1'] = "%{$search}%";
            $params[':s2'] = "%{$search}%";
        }

        $sql = "SELECT * FROM posts WHERE {$where} ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function countPublished(?string $category = null, ?string $search = null): int {
        $where = "status = 'Terbit'";
        $params = [];

        if (!empty($category)) {
            $where .= " AND category = :cat";
            $params[':cat'] = $category;
        }

        if (!empty($search)) {
            $where .= " AND (title LIKE :s1 OR content LIKE :s2)";
            $params[':s1'] = "%{$search}%";
            $params[':s2'] = "%{$search}%";
        }

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM posts WHERE {$where}");
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    public function getRecent(int $limit = 3): array {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE status = 'Terbit' ORDER BY created_at DESC LIMIT :lim");
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllAdmin(int $limit = 10, int $offset = 0, ?string $status = null, ?string $category = null, ?string $search = null): array {
        $where = "1=1";
        $params = [];

        if (!empty($status)) {
            $where .= " AND status = :st";
            $params[':st'] = $status;
        }
        if (!empty($category)) {
            $where .= " AND category = :cat";
            $params[':cat'] = $category;
        }
        if (!empty($search)) {
            $where .= " AND (title LIKE :s1 OR excerpt LIKE :s2)";
            $params[':s1'] = "%{$search}%";
            $params[':s2'] = "%{$search}%";
        }

        $sql = "SELECT * FROM posts WHERE {$where} ORDER BY id DESC LIMIT {$limit} OFFSET {$offset}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function countAllAdmin(?string $status = null, ?string $category = null, ?string $search = null): int {
        $where = "1=1";
        $params = [];

        if (!empty($status)) {
            $where .= " AND status = :st";
            $params[':st'] = $status;
        }
        if (!empty($category)) {
            $where .= " AND category = :cat";
            $params[':cat'] = $category;
        }
        if (!empty($search)) {
            $where .= " AND (title LIKE :s1 OR excerpt LIKE :s2)";
            $params[':s1'] = "%{$search}%";
            $params[':s2'] = "%{$search}%";
        }

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM posts WHERE {$where}");
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    public function create(array $data): int {
        $sql = "INSERT INTO posts (title, slug, category, excerpt, content, image, author, status, views, created_at)
                VALUES (:title, :slug, :category, :excerpt, :content, :image, :author, :status, 0, :created_at)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':slug' => $data['slug'],
            ':category' => $data['category'],
            ':excerpt' => $data['excerpt'],
            ':content' => $data['content'],
            ':image' => $data['image'] ?? '',
            ':author' => $data['author'] ?? 'Pengurus DKM',
            ':status' => $data['status'] ?? 'Terbit',
            ':created_at' => date('Y-m-d H:i:s')
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE posts SET
                title = :title,
                slug = :slug,
                category = :category,
                excerpt = :excerpt,
                content = :content,
                image = :image,
                author = :author,
                status = :status,
                updated_at = :updated_at
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':slug' => $data['slug'],
            ':category' => $data['category'],
            ':excerpt' => $data['excerpt'],
            ':content' => $data['content'],
            ':image' => $data['image'],
            ':author' => $data['author'],
            ':status' => $data['status'],
            ':updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function incrementViews(int $id): void {
        $stmt = $this->db->prepare("UPDATE posts SET views = views + 1 WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
