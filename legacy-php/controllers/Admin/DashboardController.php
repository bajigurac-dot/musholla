<?php
/**
 * Admin Dashboard Controller
 */

class DashboardController extends Controller {
    public function index(): void {
        Auth::requireAuth();

        $postModel = new Post();
        $eventModel = new Event();
        $galleryModel = new Gallery();
        $financeModel = new Finance();
        $messageModel = new Message();

        $stats = [
            'total_posts'       => $postModel->countAllAdmin(),
            'published_posts'   => $postModel->count("status = 'Terbit'"),
            'upcoming_events'   => $eventModel->count("event_date >= :td AND status != 'Dibatalkan'", [':td' => date('Y-m-d')]),
            'total_galleries'   => $galleryModel->count(),
            'published_finance' => $financeModel->count("status = 'Terbit'"),
            'unread_messages'   => $messageModel->unreadCount()
        ];

        $recentPosts = $postModel->getRecent(5);
        $upcomingEvents = $eventModel->getUpcoming(5);
        $recentMessages = array_slice($messageModel->allMessages(), 0, 5);

        $this->render('admin/dashboard/index', [
            'title'          => 'Dashboard Pengurus - Musholla Ar-rahman',
            'stats'          => $stats,
            'recentPosts'    => $recentPosts,
            'upcomingEvents' => $upcomingEvents,
            'recentMessages' => $recentMessages
        ], 'admin');
    }
}
