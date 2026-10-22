<?php
/**
 * Public Finance Controller (Laporan Keuangan Kas)
 */

class FinanceController extends Controller {
    public function index(): void {
        $active = Setting::get('finance_active', '1');
        $financeModel = new Finance();

        $reports = [];
        $summary = ['total_income' => 0, 'total_expense' => 0, 'current_balance' => 0];

        if ($active === '1') {
            $reports = $financeModel->getPublishedReports();
            $summary = $financeModel->getLatestSummary();
        }

        $this->render('finance/index', [
            'title'    => 'Laporan Kas Keuangan - Musholla Ar-rahman',
            'isActive' => $active === '1',
            'reports'  => $reports,
            'summary'  => $summary
        ]);
    }
}
