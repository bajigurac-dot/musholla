<?php
/**
 * Public Profile Controller
 */

class ProfileController extends Controller {
    public function index(): void {
        $this->render('profile/index', [
            'title' => 'Profil & Sejarah - Musholla Ar-rahman Gembor Periuk'
        ]);
    }
}
