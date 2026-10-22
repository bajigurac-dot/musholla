<?php
/**
 * Financial Report Model (Laporan Kas Musholla)
 */

class Finance extends Model {
    protected string $table = 'financial_reports';

    public function getPublishedReports(): array {
        $stmt = $this->db->query("SELECT * FROM financial_reports WHERE status = 'Terbit' ORDER BY period_year DESC, period_month DESC");
        return $stmt->fetchAll();
    }

    public function getLatestSummary(): array {
        $stmt = $this->db->query("SELECT SUM(income) as total_income, SUM(expense) as total_expense, (SUM(income) - SUM(expense)) as current_balance FROM financial_reports WHERE status = 'Terbit'");
        $row = $stmt->fetch();
        return [
            'total_income'    => (float)($row['total_income'] ?? 0),
            'total_expense'   => (float)($row['total_expense'] ?? 0),
            'current_balance' => (float)($row['current_balance'] ?? 0)
        ];
    }

    public function create(array $data): int {
        $balance = (float)$data['income'] - (float)$data['expense'];
        $sql = "INSERT INTO financial_reports (period_month, period_year, income, expense, balance, description, status, created_at)
                VALUES (:month, :year, :income, :expense, :balance, :description, :status, :created_at)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':month' => (int)$data['period_month'],
            ':year' => (int)$data['period_year'],
            ':income' => (float)$data['income'],
            ':expense' => (float)$data['expense'],
            ':balance' => $balance,
            ':description' => $data['description'] ?? '',
            ':status' => $data['status'] ?? 'Terbit',
            ':created_at' => date('Y-m-d H:i:s')
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $balance = (float)$data['income'] - (float)$data['expense'];
        $sql = "UPDATE financial_reports SET
                period_month = :month,
                period_year = :year,
                income = :income,
                expense = :expense,
                balance = :balance,
                description = :description,
                status = :status,
                updated_at = :updated_at
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':month' => (int)$data['period_month'],
            ':year' => (int)$data['period_year'],
            ':income' => (float)$data['income'],
            ':expense' => (float)$data['expense'],
            ':balance' => $balance,
            ':description' => $data['description'] ?? '',
            ':status' => $data['status'] ?? 'Terbit',
            ':updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
