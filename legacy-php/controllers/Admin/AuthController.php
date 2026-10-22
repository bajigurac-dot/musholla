<?php
/**
 * Admin Authentication Controller
 */

class AuthController extends Controller {
    public function login(): void {
        if (Auth::check()) {
            $this->redirect('admin');
            return;
        }

        $this->render('admin/auth/login', [
            'title' => 'Login Pengurus - Admin Panel Musholla Ar-rahman'
        ], 'blank');
    }

    public function doLogin(): void {
        $this->validateCsrf();

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            Session::setFlash('error', 'Silakan masukkan nama pengguna/email dan kata sandi.');
            $this->redirect('admin/login');
            return;
        }

        if (Auth::attempt($username, $password)) {
            Session::setFlash('success', 'Selamat datang kembali, ' . htmlspecialchars(Auth::user()['name']) . '!');
            $this->redirect('admin');
            return;
        }

        $this->redirect('admin/login');
    }

    public function logout(): void {
        Auth::logout();
        Session::setFlash('success', 'Anda telah berhasil keluar dari Admin Panel.');
        $this->redirect('admin/login');
    }
}
