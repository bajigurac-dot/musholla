<?php
/**
 * Public Contact Controller
 */

class ContactController extends Controller {
    public function index(): void {
        $this->render('contact/index', [
            'title' => 'Hubungi Kami & Lokasi - Musholla Ar-rahman'
        ]);
    }

    public function send(): void {
        $this->validateCsrf();

        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? 'Pesan Jamaah');
        $message = trim($_POST['message'] ?? '');

        // Honeypot spam protection (field tersembunyi yang hanya diisi robot spam)
        if (!empty($_POST['website_url'])) {
            $this->redirect('kontak');
            return;
        }

        if (empty($name) || empty($message)) {
            Session::setFlash('error', 'Nama dan isi pesan wajib diisi.');
            $this->redirect('kontak');
            return;
        }

        $messageModel = new Message();
        $messageModel->create([
            'name'    => $name,
            'phone'   => $phone,
            'email'   => $email,
            'subject' => $subject,
            'message' => $message
        ]);

        Session::setFlash('success', 'Jazakallahu khairan! Pesan Anda telah berhasil dikirimkan kepada pengurus DKM Musholla Ar-rahman.');
        $this->redirect('kontak');
    }
}
