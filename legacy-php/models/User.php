<?php
/**
 * User Model
 */

class User extends Model {
    protected string $table = 'users';

    public function allUsers(): array {
        $stmt = $this->db->query("SELECT id, name, username, email, role, is_active, last_login, created_at FROM users ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    public function create(array $data): int {
        $sql = "INSERT INTO users (name, username, email, password_hash, role, is_active, created_at)
                VALUES (:name, :username, :email, :password_hash, :role, :is_active, :created_at)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':password_hash' => password_hash($data['password'], PASSWORD_BCRYPT),
            ':role' => $data['role'] ?? 'editor',
            ':is_active' => $data['is_active'] ?? 1,
            ':created_at' => date('Y-m-d H:i:s')
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $fields = [
            'name = :name',
            'username = :username',
            'email = :email',
            'role = :role',
            'is_active = :is_active',
            'updated_at = :updated_at'
        ];
        $params = [
            ':id' => $id,
            ':name' => $data['name'],
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':role' => $data['role'],
            ':is_active' => $data['is_active'],
            ':updated_at' => date('Y-m-d H:i:s')
        ];

        if (!empty($data['password'])) {
            $fields[] = 'password_hash = :password_hash';
            $params[':password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
