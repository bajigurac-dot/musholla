<?php
/**
 * Admin Settings Controller (Pengaturan Profil & Website)
 */

class AdminSettingsController extends Controller {
    public function index(): void {
        Auth::requireAuth();

        $this->render('admin/settings/index', [
            'title'    => 'Pengaturan Profil Musholla & Website',
            'settings' => Setting::getAllAssoc()
        ], 'admin');
    }

    public function update(): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $fields = [
            'mushola_name', 'tagline', 'history', 'vision', 'mission',
            'facilities', 'address', 'phone_1', 'phone_2', 'email',
            'maps_url', 'maps_embed', 'dkm_lead', 'dkm_treasurer', 'dkm_secretary',
            'donation_active', 'donation_bank', 'donation_account', 'donation_holder', 'donation_notes',
            'finance_active'
        ];

        $data = [];
        foreach ($fields as $f) {
            $data[$f] = trim($_POST[$f] ?? '');
        }

        // Upload Logo Baru jika ada
        if (!empty($_FILES['logo_image']['name'])) {
            $logo = Uploader::uploadImage($_FILES['logo_image'], 'logo');
            if ($logo) {
                $oldLogo = Setting::get('logo_image');
                Uploader::deleteFile($oldLogo);
                $data['logo_image'] = $logo;
            }
        }

        // Upload Hero Banner Baru jika ada
        if (!empty($_FILES['hero_image']['name'])) {
            $hero = Uploader::uploadImage($_FILES['hero_image'], 'hero');
            if ($hero) {
                $oldHero = Setting::get('hero_image');
                Uploader::deleteFile($oldHero);
                $data['hero_image'] = $hero;
            }
        }

        // Upload QRIS Baru jika ada
        if (!empty($_FILES['qris_image']['name'])) {
            $qris = Uploader::uploadImage($_FILES['qris_image'], 'qris');
            if ($qris) {
                $oldQris = Setting::get('qris_image');
                Uploader::deleteFile($oldQris);
                $data['qris_image'] = $qris;
            }
        }

        Setting::updateMany($data);

        Session::setFlash('success', 'Pengaturan profil musholla berhasil disimpan.');
        $this->redirect('admin/settings');
    }
}
