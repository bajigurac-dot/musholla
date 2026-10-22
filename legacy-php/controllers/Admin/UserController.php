<?php
/**
 * Admin User Controller (Manajemen Pengguna & Hak Akses)
 */

class AdminUserController extends Controller {
    public function index(): void {
        Auth::requireSuperAdmin();

        $userModel = new User();
        $users = $userModel->allUsers();

        $this->render('admin/users/index', [
            'title' => 'Manajemen Akun Admin & Editor',
            'users' => $users
        ], 'admin');
    }

    public function create(): void {
        Auth::requireSuperAdmin();

        $this->render('admin/users/create', [
            'title' => 'Tambah Akun Pengurus Baru'
        ], 'admin');
    }

    public function store(): void {
        Auth::requireSuperAdmin();
        $this->validateCsrf();

        $name = trim($_POST['name'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'editor';
        $is_active = (int)($_POST['is_active'] ?? 1);

        if (empty($name) || empty($username) || empty($email) || empty($password)) {
            Session::setFlash('error', 'Semua kolom wajib diisi.');
            $this->redirect('admin/users/create');
            return;
        }

        $userModel = new User();
        if ($userModel->count("username = :u OR email = :e", [':u' => $username, ':e' => $email]) > 0) {
            Session::setFlash('error', 'Username atau email sudah digunakan oleh akun lain.');
            $this->redirect('admin/users/create');
            return;
        }

        $userModel->create([
            'name'      => $name,
            'username'  => $username,
            'email'     => $email,
            'password'  => $password,
            'role'      => $role,
            'is_active' => $is_active
        ]);

        Session::setFlash('success', 'Akun pengurus baru berhasil ditambahkan.');
        $this->redirect('admin/users');
    }

    public function edit(string $id): void {
        Auth::requireSuperAdmin();

        $userModel = new User();
        $user = $userModel->find((int)$id);

        if (!$user) {
            Session::setFlash('error', 'Akun tidak ditemukan.');
            $this->redirect('admin/users');
            return;
        }

        $this->render('admin/users/edit', [
            'title' => 'Edit Akun Pengurus',
            'user'  => $user
        ], 'admin');
    }

    public function update(string $id): void {
        Auth::requireSuperAdmin();
        $this->validateCsrf();

        $userModel = new User();
        $user = $userModel->find((int)$id);
        if (!$user) {
            Session::setFlash('error', 'Akun tidak ditemukan.');
            $this->redirect('admin/users');
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'editor';
        $is_active = (int)($_POST['is_active'] ?? 1);

        // Jangan biarkan akun sendiri dinonaktifkan atau diturunkan jika satu-satunya super_admin
        if ($user['id'] === Auth::id() && $is_active === 0) {
            Session::setFlash('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
            $this->redirect('admin/users/edit/' . $id);
            return;
        }

        $userModel->update((int)$id, [
            'name'      => $name,
            'username'  => $username,
            'email'     => $email,
            'password'  => $password,
            'role'      => $role,
            'is_active' => $is_active
        ]);

        Session::setFlash('success', 'Perubahan akun pengurus berhasil disimpan.');
        $this->redirect('admin/users');
    }

    public function delete(string $id): void {
        Auth::requireSuperAdmin();
        $this->validateCsrf();

        if ((int)$id === Auth::id()) {
            Session::setFlash('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
            $this->redirect('admin/users');
            return;
        }

        $userModel = new User();
        $userModel->delete((int)$id);

        Session::setFlash('success', 'Akun pengurus berhasil dihapus.');
        $this->redirect('admin/users');
    }
}
