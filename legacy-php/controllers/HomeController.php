<?php
/**
 * Public Home Controller
 */

class HomeController extends Controller {
    public function index(): void {
        $eventModel = new Event();
        $postModel = new Post();
        $galleryModel = new Gallery();
        $financeModel = new Finance();

        $prayer = PrayerSchedule::getTodaySchedule();
        $upcomingEvents = $eventModel->getUpcoming(4);
        $recentPosts = $postModel->getRecent(3);
        $recentGalleries = $galleryModel->getGalleries(null, 6);
        $financeSummary = $financeModel->getLatestSummary();

        $this->render('home/index', [
            'title'           => 'Beranda - Website Resmi Musholla Ar-rahman',
            'prayer'          => $prayer,
            'upcomingEvents'  => $upcomingEvents,
            'recentPosts'     => $recentPosts,
            'recentGalleries' => $recentGalleries,
            'financeSummary'  => $financeSummary
        ]);
    }

    public function notFound(): void {
        $this->render('errors/404', [
            'title' => '404 - Halaman Tidak Ditemukan'
        ]);
    }
}
