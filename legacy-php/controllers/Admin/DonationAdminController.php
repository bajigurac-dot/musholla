<?php
/**
 * Admin Donation Controller (Manajemen Donasi & Rekening)
 */

class DonationAdminController extends Controller {
    public function index(): void {
        Auth::requireAuth();

        $this->render('admin/donation/index', [
            'title'    => 'Pengaturan Donasi & Infaq',
            'settings' => Setting::getAllAssoc()
        ], 'admin');
    }

    public function update(): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $data = [
            'donation_active'  => $_POST['donation_active'] ?? '0',
            'donation_bank'    => trim($_POST['donation_bank'] ?? 'Bank BJB'),
            'donation_account' => trim($_POST['donation_account'] ?? '0152632533100'),
            'donation_holder'  => trim($_POST['donation_holder'] ?? 'Musholla Ar-rahman'),
            'donation_notes'   => trim($_POST['donation_notes'] ?? '')
        ];

        // Upload QRIS jika ada file baru
        if (!empty($_FILES['qris_image']['name'])) {
            $qris = Uploader::uploadImage($_FILES['qris_image'], 'qris');
            if ($qris) {
                $oldQris = Setting::get('qris_image');
                Uploader::deleteFile($oldQris);
                $data['qris_image'] = $qris;
            }
        }

        Setting::updateMany($data);

        Session::setFlash('success', 'Pengaturan rekening dan donasi berhasil disimpan.');
        $this->redirect('admin/donation');
    }
}
