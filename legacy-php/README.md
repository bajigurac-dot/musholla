# Website Profil Resmi Musholla Ar-rahman & Admin Panel

Aplikasi website resmi **Musholla Ar-rahman** (Jl. Anyer RT 007 RW 07, Kelurahan Gembor, Kecamatan Periuk, Kota Tangerang, Banten 15133) yang dibangun dengan arsitektur **PHP 8.2+ MVC Native terstruktur, PDO, Bootstrap 5.3, dan Desain Islami Modern**.

Website ini siap dijalankan secara lokal (zero-dependency / plug-and-play) maupun langsung diunggah ke layanan **shared hosting cPanel / DirectAdmin Indonesia** (Niagahoster, DomaiNesia, IDCloudHost, Rumahweb, dll) tanpa memerlukan proses server Node.js permanen.

---

## Fitur Utama

### 1. Website Publik (Jamaah & Pengunjung)
- **Beranda (`/`)**: Hero sambutan berdirinya musholla sejak 1990 atas gotong royong warga, jadwal salat real-time Tangerang, agenda kegiatan terdekat, warta berita terbaru, cuplikan galeri foto, modul infaq Bank BJB, dan peta lokasi.
- **Profil & Sejarah (`/profil`)**: Sejarah 1990 gotong royong warga & pemerintah, visi misi, daftar sarana fasilitas ber-AC & tempat wudhu bersih, serta susunan pengurus DKM (Ketua: Ustadz Tata A.S, Bendahara: Bapak Suwadi, Sekretaris: Bapak Bakri).
- **Agenda Kegiatan (`/kegiatan`)**: Sholat 5 waktu berjamaah, yasinan malam Jum'at, pengajian rutin bulanan warga, filter kegiatan mendatang vs lampau, serta halaman detail.
- **Berita & Pengumuman (`/berita`)**: Filter kategori Berita/Pengumuman, pencarian judul, pagination, URL slug SEO, dan hit counter.
- **Galeri Foto (`/galeri`)**: Grid dokumentasi kegiatan & fasilitas dengan popup lightbox pembesar gambar.
- **Donasi & Infaq (`/donasi`)**: Informasi rekening resmi **Bank BJB 0152632533100**, tombol 1-klik salin nomor rekening, scan barcode QRIS resmi, dan tombol konfirmasi otomatis via WhatsApp ke nomor pengurus (0813-8619-8079 / 0812-9465-6075).
- **Laporan Kas Keuangan (`/laporan-keuangan`)**: Transparansi kas bulanan yang disetujui pengurus (pemasukan, pengeluaran, saldo, catatan alokasi).
- **Kontak & Navigasi (`/kontak`)**: Alamat lengkap, kontak WhatsApp pengurus, form kirim pesan langsung tersimpan ke database dengan proteksi spam honeypot, dan embed peta Google Maps.

### 2. Admin Panel Pengurus (`/admin`)
- **Autentikasi Aman (`/admin/login`)**: CSRF token, hashing bcrypt, proteksi brute-force rate-limiting, generic error message.
- **Dashboard (`/admin`)**: Statistik ringkas konten terbit, agenda terdekat, rekap warta, dan pesan jamaah masuk.
- **CRUD Berita & Pengumuman (`/admin/posts`)**: Tambah, edit, hapus warta, upload foto utama, status Draft/Terbit.
- **CRUD Kegiatan (`/admin/events`)**: Kelola jadwal, jam mulai/selesai, tempat, pamflet foto, status kegiatan.
- **Manajemen Galeri (`/admin/gallery`)**: Unggah foto dokumentasi dengan validasi MIME & ekstensi aman.
- **Pengaturan Profil (`/admin/settings`)**: Edit nama, sejarah 1990, visi misi, fasilitas, kontak WhatsApp, email, dan Google Maps tanpa sentuh kode.
- **Pengaturan Jadwal Salat (`/admin/prayer`)**: Pilih mode otomatis API Kemenag RI / Aladhan untuk Kota Tangerang (WIB) dengan offline cache fallback atau mode manual.
- **Pengaturan Donasi & QRIS (`/admin/donation`)**: Ubah nomor rekening Bank BJB, upload gambar QRIS baru, dan toggle modul.
- **Laporan Kas Keuangan (`/admin/finance`)**: Catat pemasukan, pengeluaran, kalkulasi saldo otomatis real-time, status publikasi.
- **Manajemen Admin (`/admin/users`)**: Hak akses bertingkat: `Super Admin` dan `Editor Konten`.
- **Kotak Masuk Pesan (`/admin/messages`)**: Tinjau pesan masuk jamaah, tandai dibaca, dan 1-klik balas langsung via WhatsApp.

---

## Akun Demo Pengurus (Development Lokal)

| Role | Username | Password Default | Hak Akses |
|---|---|---|---|
| **Super Admin** | `admin` | `admin123` | Akses penuh seluruh modul & kelola akun |
| **Editor** | `editor` | `editor123` | Mengelola konten berita, kegiatan, dan galeri |

> **PERINGATAN KEAMANAN:** Segera ganti kata sandi akun di atas melalui menu **Kelola Admin** sebelum website dipublikasikan ke server online!

---

## Cara Menjalankan Secara Lokal (Windows)

### Opsi 1: Menggunakan Script 1-Klik `serve.bat`
Cukup klik dua kali (double click) file `serve.bat` di folder proyek ini. Script akan otomatis mendeteksi PHP dari Laragon, XAMPP, atau sistem PATH dan membuka server lokal pada:
```
http://localhost:8000
```

### Opsi 2: Menggunakan Terminal / Command Prompt
Jalankan perintah built-in web server PHP:
```bash
php -S localhost:8000 -t public
```
atau jika menggunakan PHP dari Laragon:
```powershell
C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe -S 127.0.0.1:8000 -t public
```
Buka browser dan akses `http://localhost:8000`.

---

## Struktur Folder Proyek

```
mushola/
├── config/             # Konfigurasi app, database (PDO MySQL & SQLite), routes
├── core/               # App Router, Controller, Model, Auth, Csrf, Session, Uploader, Helper
├── controllers/        # Controller publik (Home, Profile, Event, Post, Gallery, Donation, Contact)
│   └── Admin/          # Controller admin (Auth, Dashboard, Post, Event, Gallery, Settings, etc.)
├── models/             # Model data (Setting, User, Post, Event, Gallery, Finance, Message, Prayer)
├── views/              # Template tampilan PHP
│   ├── layouts/        # Layout publik (main.php) & Layout admin (admin.php)
│   ├── partials/       # Navbar, footer, prayer widget, alerts, pagination
│   ├── home/, profile/, events/, posts/, gallery/, donation/, finance/, contact/
│   └── admin/          # Tampilan modul CRUD admin panel
├── public/             # Document root publik
│   ├── index.php       # Front controller utama
│   ├── .htaccess       # Rewrite rule Apache/LiteSpeed
│   ├── assets/         # CSS kustom, JavaScript vanilla, logo & banner SVG
│   └── uploads/        # Folder penyimpanan foto (dilindungi .htaccess larangan eksekusi skrip)
├── database/
│   ├── schema.sql      # Skrip struktur tabel MySQL 8 / MariaDB
│   └── seeds.sql       # Data awal Musholla Ar-rahman, DKM, Bank BJB
├── .env.example        # Contoh variabel konfigurasi server
├── DEPLOYMENT.md       # Panduan lengkap upload ke cPanel / Shared Hosting Indonesia
├── README.md           # Panduan ini
└── serve.bat           # Script jalan otomatis di Windows
```

---

## Panduan Deployment ke Hosting
Untuk panduan detail mengenai cara upload ke cPanel, pembuatan database di phpMyAdmin, dan pengaturan domain, silakan baca dokumentasi lengkap di file **[DEPLOYMENT.md](file:///d:/AWS_QDEV/mushola/DEPLOYMENT.md)**.
