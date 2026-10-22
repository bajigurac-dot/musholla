<?php
/**
 * Event Model (Kegiatan Musholla)
 */

class Event extends Model {
    protected string $table = 'events';

    public function getUpcoming(int $limit = 6): array {
        $today = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT * FROM events WHERE event_date >= :td AND status != 'Dibatalkan' ORDER BY event_date ASC, start_time ASC LIMIT :lim");
        $stmt->bindValue(':td', $today);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPast(int $limit = 6): array {
        $today = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT * FROM events WHERE event_date < :td OR status = 'Selesai' ORDER BY event_date DESC LIMIT :lim");
        $stmt->bindValue(':td', $today);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array {
        $stmt = $this->db->prepare("SELECT * FROM events WHERE slug = :slug LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getAllAdmin(string $filter = 'all'): array {
        $sql = "SELECT * FROM events";
        $params = [];
        $today = date('Y-m-d');

        if ($filter === 'upcoming') {
            $sql .= " WHERE event_date >= :td AND status != 'Dibatalkan'";
            $params[':td'] = $today;
        } elseif ($filter === 'past') {
            $sql .= " WHERE event_date < :td OR status = 'Selesai'";
            $params[':td'] = $today;
        }

        $sql .= " ORDER BY event_date DESC, start_time ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function create(array $data): int {
        $sql = "INSERT INTO events (title, slug, description, image, event_date, start_time, end_time, location, category, status, created_at)
                VALUES (:title, :slug, :description, :image, :event_date, :start_time, :end_time, :location, :category, :status, :created_at)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':slug' => $data['slug'],
            ':description' => $data['description'],
            ':image' => $data['image'] ?? '',
            ':event_date' => $data['event_date'],
            ':start_time' => $data['start_time'] ?? '18:00',
            ':end_time' => $data['end_time'] ?? 'Selesai',
            ':location' => $data['location'] ?? 'Musholla Ar-rahman',
            ':category' => $data['category'] ?? 'Rutin',
            ':status' => $data['status'] ?? 'Mendatang',
            ':created_at' => date('Y-m-d H:i:s')
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE events SET
                title = :title,
                slug = :slug,
                description = :description,
                image = :image,
                event_date = :event_date,
                start_time = :start_time,
                end_time = :end_time,
                location = :location,
                category = :category,
                status = :status,
                updated_at = :updated_at
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':slug' => $data['slug'],
            ':description' => $data['description'],
            ':image' => $data['image'],
            ':event_date' => $data['event_date'],
            ':start_time' => $data['start_time'],
            ':end_time' => $data['end_time'],
            ':location' => $data['location'],
            ':category' => $data['category'],
            ':status' => $data['status'],
            ':updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
