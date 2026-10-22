<?php
/**
 * Admin Message Controller (Inbox Pesan Kontak Masuk)
 */

class AdminMessageController extends Controller {
    public function index(): void {
        Auth::requireAuth();

        $messageModel = new Message();
        $messages = $messageModel->allMessages();

        $this->render('admin/messages/index', [
            'title'    => 'Kotak Masuk Pesan Jamaah',
            'messages' => $messages
        ], 'admin');
    }

    public function markRead(string $id): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $messageModel = new Message();
        $messageModel->markAsRead((int)$id);

        Session::setFlash('success', 'Pesan ditandai telah dibaca.');
        $this->redirect('admin/messages');
    }

    public function delete(string $id): void {
        Auth::requireAuth();
        $this->validateCsrf();

        $messageModel = new Message();
        $messageModel->delete((int)$id);

        Session::setFlash('success', 'Pesan berhasil dihapus.');
        $this->redirect('admin/messages');
    }
}
