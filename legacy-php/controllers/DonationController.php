<?php
/**
 * Public Donation Controller (Infaq & Sedekah)
 */

class DonationController extends Controller {
    public function index(): void {
        $active = Setting::get('donation_active', '1');

        $this->render('donation/index', [
            'title'    => 'Infaq & Donasi - Musholla Ar-rahman',
            'isActive' => $active === '1'
        ]);
    }
}
