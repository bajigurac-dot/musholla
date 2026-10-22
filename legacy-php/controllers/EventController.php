<?php
/**
 * Public Event Controller
 */

class EventController extends Controller {
    public function index(): void {
        $eventModel = new Event();
        $tab = $_GET['tab'] ?? 'upcoming';

        if ($tab === 'past') {
            $events = $eventModel->getPast(12);
        } else {
            $events = $eventModel->getUpcoming(12);
        }

        $this->render('events/index', [
            'title'  => 'Jadwal & Agenda Kegiatan - Musholla Ar-rahman',
            'events' => $events,
            'tab'    => $tab
        ]);
    }

    public function detail(string $slug): void {
        $eventModel = new Event();
        $event = $eventModel->findBySlug($slug);

        if (!$event) {
            $this->redirect('kegiatan');
            return;
        }

        $upcoming = $eventModel->getUpcoming(3);

        $this->render('events/detail', [
            'title'    => e($event['title']) . ' - Musholla Ar-rahman',
            'event'    => $event,
            'upcoming' => $upcoming
        ]);
    }
}
