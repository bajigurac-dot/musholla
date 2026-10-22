# Prompt Pengembangan Website Mushola Al-Ikhlas
## Website Profil Mushola + Admin Panel — Hosting Lokal Indonesia

> **Instruksi untuk AI Coding Agent:** Bangun aplikasi web yang benar-benar berfungsi, responsif, aman, mudah dirawat, dan siap diunggah ke layanan shared hosting Indonesia yang mendukung PHP dan MySQL/MariaDB. Gunakan data awal/dummy untuk demonstrasi, tetapi seluruh fitur CRUD harus tersimpan ke database. Jangan hanya membuat mockup statis.

---

## 1. Tujuan Proyek

Buat website resmi mushola dengan tampilan modern, bersih, profesional, dan bernuansa Islami. Website terdiri dari:

1. **Website publik** yang bisa diakses jamaah/pengunjung.
2. **Admin panel** untuk pengurus mengelola konten tanpa mengedit kode.
3. **Database** untuk menyimpan profil, berita, kegiatan, galeri, dan pengaturan.
4. **Panduan instalasi dan deployment** yang sesuai untuk shared hosting lokal Indonesia.

Nama sementara: **Mushola Al-Ikhlas**. Semua identitas, logo, alamat, nomor kontak, rekening, QRIS, dan konten harus bisa diganti melalui admin panel atau konfigurasi yang sesuai. Jangan menganggap data contoh sebagai data asli.

## 2. Teknologi yang Wajib Diprioritaskan

Pilih teknologi yang mudah dipasang, terjangkau, umum didukung provider hosting Indonesia, dan tidak memerlukan server Node.js yang selalu aktif.

### Stack utama
- **Backend:** PHP 8.2+ dengan pola MVC yang sederhana dan terstruktur. Utamakan Laravel versi stabil yang kompatibel dengan PHP hosting target. Jika hosting target tidak mendukung kebutuhan Laravel, gunakan PHP native terstruktur dengan PDO dan routing yang aman—jangan membuat framework sendiri yang rumit.
- **Database:** MySQL 8 atau MariaDB yang umum disediakan oleh shared hosting.
- **Frontend:** Blade template (jika Laravel) atau template PHP, HTML5 semantik, CSS modern, dan JavaScript vanilla.
- **CSS/UI:** Bootstrap 5.3 untuk layout responsif dan komponen yang konsisten. Boleh memakai CSS kustom untuk identitas visual.
- **Ikon:** Bootstrap Icons atau Lucide yang dipasang/di-host lokal bila memungkinkan.
- **Grafik dashboard:** Chart.js hanya jika dibutuhkan; simpan file aset lokal bila memungkinkan.
- **Editor konten:** editor ringan yang mendukung judul, paragraf, daftar, dan tautan. Sanitasi HTML sebelum disimpan/ditampilkan.
- **Penyimpanan gambar:** folder upload lokal di server hosting dengan validasi tipe/ukuran file.
- **Versi PHP, ekstensi, dan framework:** dokumentasikan versi minimum secara eksplisit.

### Batasan hosting
- Jangan mewajibkan Node.js berjalan di server produksi.
- Jangan mewajibkan Docker, Redis, WebSocket, server khusus, atau proses worker selalu aktif.
- Build tool seperti Vite boleh digunakan saat development/build, tetapi hasil build harus dapat diunggah sebagai aset statis. Berikan alternatif deployment yang tidak memerlukan proses Node.js permanen.
- Jangan bergantung pada API berbayar untuk fitur dasar.
- Jadwal salat otomatis, peta, email, dan QRIS harus punya fallback jika API/koneksi eksternal tidak tersedia.
- Jangan menyimpan password dalam bentuk teks biasa.
- Gunakan konfigurasi environment untuk kredensial; jangan commit file `.env` produksi.

## 3. Arahan Desain UI/UX

Gunakan referensi visual desain website mushola yang sudah dibahas: layout bersih, warna hijau tua dan putih, foto mushola yang menonjol, kartu konten sederhana, tipografi mudah dibaca, serta admin panel dengan sidebar hijau gelap.

### Identitas visual
- Warna utama: hijau tua, misalnya `#075B4A`.
- Warna pendukung: hijau lembut, putih, abu-abu muda, dan aksen emas yang hemat.
- Gunakan ruang kosong yang cukup, border tipis, bayangan lembut, radius kartu konsisten.
- Hindari tampilan berlebihan, animasi yang mengganggu, gradien berlebihan, dan ornamen yang memenuhi layar.
- Gunakan foto mushola dan kegiatan yang nyata setelah diberikan pengurus. Untuk data demo, gunakan placeholder yang jelas dan legal digunakan.
- Jangan membuat teks atau gambar penting menjadi tidak terbaca pada layar ponsel.

### Responsif dan aksesibilitas
- Mobile-first; nyaman digunakan di HP, tablet, laptop, dan desktop.
- Navigasi keyboard, label formulir jelas, kontras warna memadai, fokus input terlihat.
- Semua tombol dan tautan harus punya fungsi nyata.
- Tampilkan status loading, sukses, error, kosong, dan konfirmasi untuk tindakan penting.
- Gunakan bahasa Indonesia yang konsisten dan mudah dipahami.

---

## 4. Struktur Website Publik

Buat halaman berikut dengan navigasi konsisten dan SEO dasar.

### 4.1 Beranda (`/`)
Elemen:
- Header: logo, nama mushola, menu, tombol donasi bila fitur diaktifkan.
- Hero: foto utama mushola, judul sambutan, deskripsi singkat, tombol “Lihat Profil” dan “Jadwal Kegiatan”.
- Ringkasan jadwal salat hari ini (jika jadwal salat diaktifkan).
- Kegiatan mendatang.
- Berita/pengumuman terbaru.
- Cuplikan galeri.
- Ajakan donasi/infak jika fitur donasi diaktifkan.
- Alamat, kontak, tautan Google Maps, dan footer.

### 4.2 Profil Mushola (`/profil`)
- Sejarah.
- Visi dan misi bila tersedia.
- Informasi fasilitas.
- Foto mushola.
- Informasi pengurus bila disetujui untuk dipublikasikan.
- Alamat dan kontak.

### 4.3 Kegiatan (`/kegiatan`)
- Daftar kegiatan dengan judul, gambar, tanggal, jam, lokasi, deskripsi, dan status.
- Filter kegiatan mendatang dan kegiatan sebelumnya.
- Halaman detail kegiatan.
- Kegiatan yang sudah lewat tetap dapat diarsipkan.

### 4.4 Berita dan Pengumuman (`/berita`)
- Daftar artikel dengan gambar, judul, tanggal, kategori, ringkasan.
- Filter kategori: Berita dan Pengumuman.
- Pencarian sederhana dan pagination.
- Halaman detail artikel dengan URL slug yang ramah SEO.
- Hanya konten berstatus “Terbit” yang tampil di publik.

### 4.5 Galeri (`/galeri`)
- Galeri foto kegiatan, fasilitas, dan dokumentasi.
- Filter kategori.
- Tampilan grid responsif dan pembesaran gambar/lightbox yang mudah diakses.
- Teks alternatif gambar.

### 4.6 Donasi/Infak (`/donasi`)
Fitur opsional yang bisa diaktifkan/nonaktifkan dari pengaturan:
- Tujuan donasi.
- Informasi rekening resmi dan tombol salin nomor rekening.
- QRIS resmi yang diunggah pengurus, bila tersedia.
- Petunjuk konfirmasi donasi.
- Penjelasan bahwa transfer harus diverifikasi oleh pengurus.
- Jangan membuat pembayaran online otomatis atau menyatakan transaksi berhasil tanpa integrasi payment gateway yang benar.
- Jangan menampilkan informasi sensitif atau rekening sebelum disetujui pengurus.

### 4.7 Laporan Keuangan (`/laporan-keuangan`)
Opsional:
- Tampilkan laporan kas yang telah disetujui untuk publikasi.
- Kolom periode, pemasukan, pengeluaran, saldo, catatan, dan lampiran jika ada.
- Jangan tampilkan data pribadi donatur tanpa persetujuan.
- Hanya laporan berstatus “Dipublikasikan” yang dapat dilihat umum.

### 4.8 Kontak (`/kontak`)
- Alamat lengkap.
- Nomor WhatsApp dengan tautan yang valid.
- Email dan media sosial jika tersedia.
- Link Google Maps atau embed peta opsional.
- Formulir pesan sederhana dengan validasi dan proteksi spam dasar. Jika email tidak tersedia di hosting, tampilkan opsi kontak WhatsApp sebagai fallback.

### 4.9 Halaman sistem
- 404 tidak ditemukan.
- 403 akses ditolak.
- 500 kesalahan server dengan pesan aman.
- Halaman pemeliharaan opsional.

---

## 5. Struktur Admin Panel

URL admin dapat menggunakan `/admin`. Semua halaman admin wajib memerlukan autentikasi dan otorisasi.

### 5.1 Login Admin (`/admin/login`)
- Logo dan nama mushola.
- Email/username dan password.
- Validasi input.
- CSRF protection.
- Pembatasan percobaan login/rate limiting jika tersedia.
- Pesan kesalahan generik agar tidak membocorkan apakah akun terdaftar.
- Logout yang mengakhiri session.
- Tidak menyediakan pendaftaran admin publik.

### 5.2 Dashboard (`/admin`)
Tampilkan kartu ringkasan:
- Total berita terbit dan draft.
- Total kegiatan mendatang.
- Total foto galeri.
- Jumlah laporan kas yang dipublikasikan jika modul aktif.
- Daftar kegiatan terdekat.
- Berita terakhir.
- Shortcut tambah berita, kegiatan, dan galeri.
- Grafik hanya jika benar-benar membantu; jangan memenuhi dashboard dengan grafik dekoratif.

### 5.3 Manajemen Berita dan Pengumuman
CRUD lengkap:
- Tambah, lihat, edit, hapus.
- Judul, slug, kategori, ringkasan, isi, gambar utama, penulis, tanggal publikasi, status Draft/Terbit.
- Preview sebelum terbit.
- Validasi slug unik.
- Konfirmasi sebelum menghapus.
- Pencarian, filter status/kategori, pagination.
- Pastikan konten draft tidak bisa dibuka publik melalui URL.

### 5.4 Manajemen Kegiatan
CRUD lengkap:
- Nama kegiatan, slug, deskripsi, gambar, tanggal, jam mulai/selesai, lokasi, kategori, status.
- Filter kegiatan mendatang dan lampau.
- Validasi tanggal dan jam.
- Tombol aktif/nonaktif atau arsip sesuai kebutuhan.

### 5.5 Manajemen Galeri
- Unggah beberapa foto sesuai batas hosting.
- Judul/caption, kategori, tanggal, teks alternatif.
- Edit dan hapus.
- Validasi ekstensi dan MIME type; batasi ukuran file.
- Buat nama file acak dan cegah eksekusi file di direktori upload.
- Jangan menerima file executable atau SVG tanpa sanitasi.

### 5.6 Pengaturan Profil Website
Admin dapat mengubah:
- Nama dan tagline mushola.
- Logo dan favicon.
- Foto hero.
- Sejarah, visi, misi, fasilitas.
- Alamat, nomor WhatsApp, email, media sosial.
- Link Google Maps.
- Footer dan informasi hak cipta.
- Metadata SEO dasar.
- Jam layanan bila diperlukan.

### 5.7 Pengaturan Jadwal Salat
- Mode manual sebagai default/fallback: admin mengisi jadwal atau mengatur jadwal salat yang ditampilkan.
- Jika menggunakan API eksternal, dokumentasikan sumber, metode konfigurasi lokasi, zona waktu `Asia/Jakarta`, penanganan kegagalan, dan cache.
- Jangan menampilkan jadwal otomatis seolah-olah akurat jika API gagal atau tanggal tidak valid.
- Sediakan opsi menyembunyikan modul jadwal salat.

### 5.8 Manajemen Donasi dan Laporan Kas (opsional)
- Kelola rekening, QRIS, tujuan donasi, dan instruksi.
- Tambah/edit/hapus laporan kas.
- Kolom periode, pemasukan, pengeluaran, saldo, catatan, lampiran, status draft/publikasi.
- Validasi angka dan perhitungan saldo.
- Laporan baru tidak otomatis tampil di publik sebelum disetujui.
- Jangan menyimpan data kartu pembayaran.
- Modul ini adalah publikasi informasi/laporan, bukan sistem akuntansi penuh atau payment gateway.

### 5.9 Manajemen Admin
- Daftar admin, tambah, edit, nonaktifkan, reset password.
- Role minimal: `Super Admin` dan `Editor`.
- Super Admin mengelola akun dan pengaturan sensitif.
- Editor mengelola konten tetapi tidak mengelola akun atau kredensial.
- Admin pertama dibuat melalui proses instalasi/CLI atau prosedur setup aman, bukan pendaftaran terbuka.
- Catat waktu login dan tindakan penting secara proporsional, tanpa menyimpan password atau token.

### 5.10 Media dan SEO
- Kelola gambar/logo.
- Judul halaman dan meta description.
- Slug ramah SEO.
- Sitemap XML dan robots.txt bila sesuai.
- Open Graph untuk berbagi tautan.
- Jangan mempublikasikan konten draft dalam sitemap.

---

## 6. Database

Buat migrasi/schema database dan seeder data demo. Sesuaikan nama tabel dengan framework yang dipilih. Minimal entitas:

- `users` / `admins`: akun admin, password hash, role, status.
- `settings`: konfigurasi website yang dapat diedit.
- `posts`: berita dan pengumuman.
- `categories`: kategori konten.
- `events`: kegiatan.
- `galleries`: metadata foto.
- `donation_settings`: informasi donasi resmi.
- `financial_reports`: laporan kas yang dipublikasikan.
- `contact_messages`: pesan dari formulir kontak, jika formulir diaktifkan.
- `activity_logs`: log tindakan penting jika dibutuhkan.

Gunakan primary key, foreign key bila sesuai, indeks untuk pencarian, timestamps, dan status publikasi. Terapkan soft delete jika berguna. Hindari menyimpan data berulang yang tidak diperlukan.

### Data demo
Sediakan konten demo yang mudah dikenali sebagai contoh, misalnya:
- 4 berita.
- 4 kegiatan.
- 6 foto galeri.
- Profil dan kontak placeholder.
- Beberapa laporan kas contoh hanya jika modul laporan diaktifkan.

Beri label jelas bahwa data adalah data dummy dan harus diganti sebelum produksi. Jangan menggunakan rekening, nomor WhatsApp, alamat, atau QRIS palsu yang tampak seperti data asli.

---

## 7. Keamanan Wajib

- Password di-hash dengan mekanisme bawaan framework (`password_hash`/bcrypt/Argon2 sesuai dukungan).
- Proteksi CSRF pada semua form yang mengubah data.
- Validasi server-side untuk seluruh input; validasi browser hanya pelengkap.
- Gunakan prepared statements/ORM, jangan menggabungkan input mentah ke query SQL.
- Escape output untuk mencegah XSS; sanitasi konten rich text.
- Session cookie aman; gunakan HTTPS saat tersedia, `HttpOnly`, `SameSite`, dan `Secure` di produksi HTTPS.
- Otorisasi per role untuk setiap route admin.
- Validasi unggahan file berdasarkan MIME, ekstensi, ukuran, dan nama file.
- Jangan izinkan file PHP dieksekusi di folder upload.
- Lindungi file konfigurasi, backup, log, dan file `.env` agar tidak dapat diakses publik.
- Sediakan prosedur reset password yang aman. Jika email tidak tersedia, dokumentasikan reset melalui pengelola hosting/CLI.
- Jangan menaruh kredensial di repository, source JavaScript, atau dokumentasi publik.
- Buat backup database dan media serta panduan restore.
- Tampilkan error detail hanya di lingkungan development; produksi harus memakai pesan aman.
- Terapkan prinsip least privilege pada akun database.

---

## 8. Struktur Kode dan Kualitas

- Pisahkan controller, model, view, route, validasi, dan layanan sesuai framework.
- Gunakan layout publik dan layout admin terpisah.
- Hindari satu file sangat besar yang berisi semua logika.
- Buat komponen berulang: header, footer, breadcrumb, alert, pagination, form field, sidebar, dan konfirmasi hapus.
- Gunakan pagination server-side untuk daftar yang panjang.
- Gunakan query database, bukan array hardcoded, untuk konten utama.
- Sediakan empty state jika belum ada data.
- Gunakan transaksi database pada operasi yang perlu konsistensi.
- Jangan menyisakan tombol mati, link `#`, form tanpa handler, atau menu yang sekadar dekorasi.
- Jika fitur eksternal tidak dikonfigurasi, tampilkan fallback yang wajar dan jelaskan di dokumentasi.
- Gunakan bahasa Indonesia untuk UI.

---

## 9. Deployment ke Shared Hosting Indonesia

Buat dokumentasi `DEPLOYMENT.md` yang menjelaskan:

1. Persyaratan versi PHP dan ekstensi yang dibutuhkan.
2. Cara membuat database MySQL/MariaDB dan user database melalui panel hosting.
3. Cara mengatur file environment dengan aman.
4. Cara menjalankan migrasi dan seeder melalui SSH/terminal jika tersedia.
5. Alternatif bila hosting tidak menyediakan SSH/Composer: jalankan dependency install dan build di komputer lokal, lalu unggah hasil yang diperlukan sesuai dokumentasi framework. Jangan meminta pengguna mengunggah `vendor` yang tidak lengkap.
6. Cara mengarahkan document root ke folder `public` jika menggunakan Laravel.
7. Jika document root tidak bisa diubah, berikan solusi deployment yang aman dan spesifik—jangan sekadar memindahkan seluruh file sensitif ke folder publik.
8. Cara mengatur permission folder storage/cache dan upload.
9. Cara memasang SSL/HTTPS dan domain.
10. Cara mengatur cron job hanya jika fitur memang membutuhkannya.
11. Cara menguji login admin, unggah gambar, CRUD, dan halaman publik.
12. Cara backup dan restore database serta media.
13. Cara update aplikasi dengan downtime minimal.
14. Troubleshooting umum: error 500, koneksi database, permission, batas upload, versi PHP, dan rewrite URL.

Sertakan juga:
- `README.md`: ringkasan proyek dan langkah menjalankan secara lokal.
- `.env.example`: hanya nama variabel dan placeholder, tanpa rahasia.
- File migrasi/schema dan seeder.
- Akun demo hanya untuk development lokal. Jangan aktifkan password demo di produksi.
- Instruksi mengganti seluruh data demo sebelum website dipublikasikan.

### Development lokal
Utamakan cara pengembangan yang mudah di Windows menggunakan PHP, Composer, dan MySQL/MariaDB, atau XAMPP/Laragon bila sesuai. Dokumentasikan perintah persis yang diperlukan. Pastikan konfigurasi lokal tidak tertukar dengan konfigurasi produksi.

---

## 10. SEO, Performa, dan Privasi

- Setiap halaman memiliki title dan meta description yang relevan.
- Gunakan URL yang bersih dan slug.
- Kompres dan optimalkan gambar; gunakan ukuran thumbnail yang sesuai.
- Lazy-load gambar di bawah lipatan halaman.
- Minimalkan library pihak ketiga dan request eksternal.
- Jangan memuat font atau script eksternal yang tidak diperlukan.
- Sediakan kebijakan privasi sederhana jika formulir kontak atau data pengguna dikumpulkan.
- Jangan mengumpulkan data jamaah yang tidak dibutuhkan.
- Minta persetujuan sebelum mempublikasikan foto individu, terutama anak-anak, atau informasi pribadi.

---

## 11. Kriteria Penerimaan / Definition of Done

Proyek dianggap selesai jika:

- [ ] Seluruh halaman publik tersedia dan responsif.
- [ ] Login, logout, dan role admin berfungsi.
- [ ] CRUD berita/pengumuman berfungsi dan tersimpan di database.
- [ ] CRUD kegiatan berfungsi dan tersimpan di database.
- [ ] CRUD galeri dan unggah foto berfungsi.
- [ ] Pengaturan profil, logo, kontak, dan footer dapat diubah lewat admin.
- [ ] Draft tidak muncul di halaman publik.
- [ ] Modul donasi/laporan kas dapat diaktifkan atau dinonaktifkan.
- [ ] Semua tombol, filter, pencarian, pagination, dan form yang ditampilkan bekerja.
- [ ] Validasi server-side, CSRF, proteksi akses, dan keamanan upload diterapkan.
- [ ] Tidak ada kredensial rahasia atau akun demo aktif di produksi.
- [ ] Ada seeder data demo untuk development.
- [ ] Dokumentasi instalasi, deployment, backup, dan restore tersedia.
- [ ] Website dapat dijalankan di lingkungan hosting yang memenuhi persyaratan tanpa proses Node.js permanen.
- [ ] Tidak ada error kritis di console atau log aplikasi pada alur utama.

---

## 12. Tahapan Pengerjaan

Kerjakan bertahap dan pastikan tiap tahap dapat diuji.

1. **Analisis & fondasi:** struktur proyek, routing, database, migrasi, autentikasi.
2. **Desain publik:** layout, header/footer, beranda, profil, kegiatan, berita, galeri, donasi, kontak.
3. **Admin panel:** login, dashboard, CRUD, pengaturan, manajemen akun.
4. **Integrasi data:** seluruh halaman mengambil konten dari database.
5. **Keamanan & validasi:** role, CSRF, upload, sanitasi, error handling.
6. **Responsif & aksesibilitas:** uji ponsel hingga desktop.
7. **Deployment & dokumentasi:** panduan shared hosting, backup, restore, dan checklist produksi.

Sebelum menulis banyak kode, tampilkan terlebih dahulu:
- struktur folder yang diusulkan,
- daftar route publik dan admin,
- rancangan tabel database,
- daftar halaman dan komponen UI,
- asumsi versi PHP/framework,
- daftar fitur yang termasuk dan yang opsional.

Setelah itu implementasikan seluruh aplikasi. Jangan berhenti setelah membuat desain halaman depan. Jika ada keputusan yang belum diberikan customer, gunakan pilihan default yang aman dan dokumentasikan sebagai asumsi; jangan mengarang data asli mushola.
