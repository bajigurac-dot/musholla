<?php
/**
 * Admin Finance Controller (CRUD Laporan Kas Keuangan)
 */

class FinanceAdminController extends Controller {
    public function index(): void {
        Auth::requireAuth();

        $financeModel = new Finance();
        $reports = $financeModel->all('period_year DESC, period_month DESC');
        $summary = $financeModel->getLatestSummary();

        $this->render('admin/finance/index', [
            'title'   => 'Laporan Kas Keuangan',
            'reports' => $reports,
            'summary' => $summary
        ], 'admin');
    }

    public function create(): void {
        Auth::requireAuth();

        $this->render('admin/finance/create', [
            'title' => 'Tambah Laporan Kas Baru'
        ], 'admin');
    }

    public function store(): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $month = (int)($_POST['period_month'] ?? date('n'));
        $year = (int)($_POST['period_year'] ?? date('Y'));
        $income = (float)($_POST['income'] ?? 0);
        $expense = (float)($_POST['expense'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'Terbit';

        $financeModel = new Finance();
        $financeModel->create([
            'period_month' => $month,
            'period_year'  => $year,
            'income'       => $income,
            'expense'      => $expense,
            'description'  => $description,
            'status'       => $status
        ]);

        Session::setFlash('success', 'Laporan kas keuangan berhasil ditambahkan.');
        $this->redirect('admin/finance');
    }

    public function edit(string $id): void {
        Auth::requireAuth();

        $financeModel = new Finance();
        $report = $financeModel->find((int)$id);

        if (!$report) {
            Session::setFlash('error', 'Laporan tidak ditemukan.');
            $this->redirect('admin/finance');
            return;
        }

        $this->render('admin/finance/edit', [
            'title'  => 'Edit Laporan Kas',
            'report' => $report
        ], 'admin');
    }

    public function update(string $id): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $month = (int)($_POST['period_month'] ?? date('n'));
        $year = (int)($_POST['period_year'] ?? date('Y'));
        $income = (float)($_POST['income'] ?? 0);
        $expense = (float)($_POST['expense'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'Terbit';

        $financeModel = new Finance();
        $financeModel->update((int)$id, [
            'period_month' => $month,
            'period_year'  => $year,
            'income'       => $income,
            'expense'      => $expense,
            'description'  => $description,
            'status'       => $status
        ]);

        Session::setFlash('success', 'Laporan kas keuangan berhasil diperbarui.');
        $this->redirect('admin/finance');
    }

    public function delete(string $id): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $financeModel = new Finance();
        $financeModel->delete((int)$id);

        Session::setFlash('success', 'Laporan kas keuangan berhasil dihapus.');
        $this->redirect('admin/finance');
    }
}
