<?php
/**
 * Gallery Model
 */

class Gallery extends Model {
    protected string $table = 'galleries';

    public function getGalleries(?string $category = null, int $limit = 50): array {
        $sql = "SELECT * FROM galleries";
        $params = [];

        if (!empty($category) && $category !== 'Semua') {
            $sql .= " WHERE category = :cat";
            $params[':cat'] = $category;
        }

        $sql .= " ORDER BY id DESC LIMIT :lim";
        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCategories(): array {
        $stmt = $this->db->query("SELECT DISTINCT category FROM galleries WHERE category IS NOT NULL AND category != ''");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function create(array $data): int {
        $sql = "INSERT INTO galleries (title, image, category, alt_text, created_at)
                VALUES (:title, :image, :category, :alt_text, :created_at)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':image' => $data['image'],
            ':category' => $data['category'] ?? 'Kegiatan',
            ':alt_text' => $data['alt_text'] ?? $data['title'],
            ':created_at' => date('Y-m-d H:i:s')
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE galleries SET
                title = :title,
                category = :category,
                alt_text = :alt_text
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':category' => $data['category'] ?? 'Kegiatan',
            ':alt_text' => $data['alt_text'] ?? $data['title']
        ]);
    }
}
