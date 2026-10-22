<?php
/**
 * Message Model (Pesan Kontak Masuk)
 */

class Message extends Model {
    protected string $table = 'contact_messages';

    public function allMessages(): array {
        $stmt = $this->db->query("SELECT * FROM contact_messages ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function unreadCount(): int {
        return $this->count('is_read = 0');
    }

    public function create(array $data): int {
        $sql = "INSERT INTO contact_messages (name, phone, email, subject, message, is_read, created_at)
                VALUES (:name, :phone, :email, :subject, :message, 0, :created_at)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':phone' => $data['phone'] ?? '',
            ':email' => $data['email'] ?? '',
            ':subject' => $data['subject'] ?? 'Pesan dari Website',
            ':message' => $data['message'],
            ':created_at' => date('Y-m-d H:i:s')
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function markAsRead(int $id): bool {
        $stmt = $this->db->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
