<?php
/**
 * Definisi Route Aplikasi Musholla Ar-rahman
 */

// Route Publik
App::get('/', 'HomeController@index');
App::get('/profil', 'ProfileController@index');
App::get('/kegiatan', 'EventController@index');
App::get('/kegiatan/{slug}', 'EventController@detail');
App::get('/berita', 'PostController@index');
App::get('/berita/{slug}', 'PostController@detail');
App::get('/galeri', 'GalleryController@index');
App::get('/donasi', 'DonationController@index');
App::get('/laporan-keuangan', 'FinanceController@index');
App::get('/kontak', 'ContactController@index');
App::post('/kontak/kirim', 'ContactController@send');

// Route Admin Autentikasi
App::get('/admin/login', 'Admin/AuthController@login');
App::post('/admin/login', 'Admin/AuthController@doLogin');
App::get('/admin/logout', 'Admin/AuthController@logout');
App::post('/admin/logout', 'Admin/AuthController@logout');

// Route Admin Dashboard
App::get('/admin', 'Admin/DashboardController@index');
App::get('/admin/dashboard', 'Admin/DashboardController@index');

// Route Admin Berita & Pengumuman
App::get('/admin/posts', 'Admin/PostController@index');
App::get('/admin/posts/create', 'Admin/PostController@create');
App::post('/admin/posts/store', 'Admin/PostController@store');
App::get('/admin/posts/edit/{id}', 'Admin/PostController@edit');
App::post('/admin/posts/update/{id}', 'Admin/PostController@update');
App::post('/admin/posts/delete/{id}', 'Admin/PostController@delete');

// Route Admin Kegiatan
App::get('/admin/events', 'Admin/EventController@index');
App::get('/admin/events/create', 'Admin/EventController@create');
App::post('/admin/events/store', 'Admin/EventController@store');
App::get('/admin/events/edit/{id}', 'Admin/EventController@edit');
App::post('/admin/events/update/{id}', 'Admin/EventController@update');
App::post('/admin/events/delete/{id}', 'Admin/EventController@delete');

// Route Admin Galeri Foto
App::get('/admin/gallery', 'Admin/GalleryController@index');
App::post('/admin/gallery/upload', 'Admin/GalleryController@upload');
App::post('/admin/gallery/update/{id}', 'Admin/GalleryController@update');
App::post('/admin/gallery/delete/{id}', 'Admin/GalleryController@delete');

// Route Admin Pengaturan Profil Website
App::get('/admin/settings', 'Admin/SettingsController@index');
App::post('/admin/settings/update', 'Admin/SettingsController@update');

// Route Admin Jadwal Salat
App::get('/admin/prayer', 'Admin/PrayerController@index');
App::post('/admin/prayer/update', 'Admin/PrayerController@update');

// Route Admin Donasi & Rekening
App::get('/admin/donation', 'Admin/DonationAdminController@index');
App::post('/admin/donation/update', 'Admin/DonationAdminController@update');

// Route Admin Laporan Kas Keuangan
App::get('/admin/finance', 'Admin/FinanceAdminController@index');
App::get('/admin/finance/create', 'Admin/FinanceAdminController@create');
App::post('/admin/finance/store', 'Admin/FinanceAdminController@store');
App::get('/admin/finance/edit/{id}', 'Admin/FinanceAdminController@edit');
App::post('/admin/finance/update/{id}', 'Admin/FinanceAdminController@update');
App::post('/admin/finance/delete/{id}', 'Admin/FinanceAdminController@delete');

// Route Admin Manajemen Akun & Hak Akses
App::get('/admin/users', 'Admin/UserController@index');
App::get('/admin/users/create', 'Admin/UserController@create');
App::post('/admin/users/store', 'Admin/UserController@store');
App::get('/admin/users/edit/{id}', 'Admin/UserController@edit');
App::post('/admin/users/update/{id}', 'Admin/UserController@update');
App::post('/admin/users/delete/{id}', 'Admin/UserController@delete');

// Route Admin Kotak Masuk Pesan
App::get('/admin/messages', 'Admin/MessageController@index');
App::post('/admin/messages/read/{id}', 'Admin/MessageController@markRead');
App::post('/admin/messages/delete/{id}', 'Admin/MessageController@delete');
