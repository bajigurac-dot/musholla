# Panduan Deployment Website Musholla Ar-rahman
## Deployment ke Shared Hosting Indonesia (cPanel / DirectAdmin)

Panduan langkah demi langkah untuk mengunggah dan mengonfigurasi website **Musholla Ar-rahman** di penyedia hosting lokal Indonesia (seperti Niagahoster, DomaiNesia, IDCloudHost, Rumahweb, Jagoan Hosting, dll).

---

## 1. Persyaratan Sistem & Hosting

Pastikan paket hosting Anda memenuhi spesifikasi berikut:
- **Versi PHP:** PHP 8.2 atau PHP 8.3 (Dapat diatur melalui menu *Select PHP Version* atau *MultiPHP Manager* di cPanel).
- **Database:** MySQL 8.0+ atau MariaDB 10.4+.
- **Ekstensi PHP Wajib:**
  - `pdo` & `pdo_mysql` (Koneksi database)
  - `mbstring` (Pemrosesan karakter)
  - `gd` (Pemrosesan gambar)
  - `curl` (Jadwal salat otomatis via API)
  - `fileinfo` (Validasi MIME type keamanan upload)
  - `openssl` (Enkripsi & token keamanan)
  - `session` (Autentikasi admin)
- **Web Server:** Apache atau LiteSpeed Web Server yang mendukung file `.htaccess` dan modul `mod_rewrite`.

---

## 2. Membuat Database & Pengguna MySQL di cPanel

1. Masuk ke **cPanel** hosting Anda.
2. Cari dan klik menu **MySQL® Database Wizard** (atau **MySQL Databases**).
3. **Langkah 1: Buat Nama Database**
   - Masukkan nama database, misalnya: `cpaneluser_mushola`.
   - Klik **Next Step**.
4. **Langkah 2: Buat Pengguna Database (Database User)**
   - Masukkan username, misalnya: `cpaneluser_dkm`.
   - Buat password yang kuat (gunakan *Password Generator*). Catat password ini.
   - Klik **Create User**.
5. **Langkah 3: Berikan Hak Akses (Privileges)**
   - Centang **ALL PRIVILEGES**.
   - Klik **Make Changes**.

---

## 3. Mengimpor Struktur Tabel & Data Awal (phpMyAdmin)

1. Kembali ke beranda cPanel, klik menu **phpMyAdmin**.
2. Pilih nama database yang baru saja dibuat di sidebar kiri (`cpaneluser_mushola`).
3. Klik tab **Import** di bagian atas.
4. Klik **Choose File** / **Pilih File**, lalu pilih file:
   - `database/schema.sql` (untuk membuat tabel)
   - Klik tombol **Import** di bagian bawah.
5. Setelah berhasil, ulangi tab **Import** dan pilih file:
   - `database/seeds.sql` (untuk memasukkan data awal Musholla Ar-rahman & akun admin default).
   - Klik tombol **Import**.

---

## 4. Mengunggah Berkas Website ke Hosting

Terdapat dua metode tergantung pengaturan paket hosting Anda:

### Metode A: Jika Document Root Dapat Diarahkan ke Folder `public` (Sangat Direkomendasikan)
1. Masuk ke cPanel > **File Manager**.
2. Buat folder baru di luar `public_html`, misalnya `/home/username/mushola_app/`.
3. Kompres seluruh proyek ke dalam format `.zip` (tanpa folder `.git`).
4. Unggah file `.zip` tersebut dan ekstrak di dalam folder `/home/username/mushola_app/`.
5. Di cPanel > **Domains**, ubah **Document Root** domain Anda menjadi:
   `/home/username/mushola_app/public`

### Metode B: Jika Document Root Terkunci di `public_html` (Shared Hosting Standar)
Website Musholla Ar-rahman telah dilengkapi dengan file **`index.php`** dan **`.htaccess`** di tingkat root yang secara otomatis mengamankan folder sensitif dan meneruskan permintaan ke folder `public`:
1. Masuk ke cPanel > **File Manager** > buka folder **`public_html`**.
2. Unggah file `.zip` proyek dan ekstrak langsung di dalam **`public_html`**.
3. Pastikan file `.htaccess` di dalam `public_html` terunggah (aktifkan *Show Hidden Files* pada pengaturan File Manager).
4. File `.htaccess` bawaan secara otomatis memblokir akses langsung ke folder `/config`, `/core`, `/models`, `/views`, `/database`, dan `.env`.

---

## 5. Konfigurasi File Lingkungan (`.env`)

1. Pada File Manager di hosting, buat file baru bernama **`.env`** di direktori utama proyek (atau ubah nama dari `.env.example`).
2. Isi kredensial database yang telah dibuat pada Langkah 2:
   ```ini
   APP_ENV=production
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=cpaneluser_mushola
   DB_USERNAME=cpaneluser_dkm
   DB_PASSWORD=PasswordDatabaseAndaYangKuat
   ```
3. Simpan file `.env`. Pastikan permission file `.env` diatur ke **0600** atau **0640**.

---

## 6. Mengatur Izin Folder (Permissions)

Pastikan izin folder media / upload diatur agar PHP dapat menyimpan foto yang diunggah pengurus:
- Folder **`public/uploads`** : Atur permission ke **0755** (atau **0775**).
- File **`public/uploads/.htaccess`** wajib ada untuk mencegah eksekusi skrip berbahaya di direktori unggahan.

---

## 7. Memasang Sertifikat SSL (HTTPS)

1. Di cPanel, cari menu **SSL/TLS Status** atau **Let's Encrypt SSL**.
2. Pilih nama domain website musholla Anda.
3. Klik tombol **Run AutoSSL** atau **Issue SSL**.
4. Website akan otomatis dapat diakses dengan protokol aman `https://domain-musholla.id`.

---

## 8. Verifikasi & Pengujian Pasca-Deployment

Lakukan pengujian berikut di browser:
1. **Halaman Publik:** Buka `https://domain-musholla.id/` dan pastikan nama Musholla Ar-rahman, jadwal salat, kegiatan, dan tombol Bank BJB muncul sempurna.
2. **Login Admin:** Buka `https://domain-musholla.id/admin/login`.
   - Username: `admin`
   - Password: `admin123`
3. **Ganti Kata Sandi (WAJIB):**
   - Masuk ke menu **Kelola Admin**.
   - Edit akun `admin` dan ubah kata sandi menjadi kata sandi baru yang kuat dan hanya diketahui oleh DKM resmi.
   - Nonaktifkan atau ubah password akun `editor`.
4. **Uji CRUD:**
   - Coba unggah satu foto di menu **Galeri Foto**.
   - Coba buat satu berita warta baru di menu **Berita & Info**.
   - Buka menu **Pengaturan Profil** dan sesuaikan kontak atau Google Maps bila ada perubahan.

---

## 9. Prosedur Backup & Restore

### Cara Backup Berkala
1. **Backup Database:**
   - Buka cPanel > **phpMyAdmin**.
   - Pilih database `cpaneluser_mushola` > klik tab **Export** > Format **SQL** > klik **Export**.
   - Simpan file `.sql` di Google Drive atau komputer aman DKM.
2. **Backup Foto Dokumentasi:**
   - Buka File Manager > tandai folder `public/uploads` > klik **Compress** menjadi `uploads_backup.zip`.
   - Unduh file zip tersebut.

### Cara Restore
- Untuk mengembalikan database: Buka phpMyAdmin, kosongkan tabel, lalu klik **Import** file `.sql` backup.
- Untuk mengembalikan foto: Ekstrak kembali file zip foto ke dalam folder `public/uploads/`.

---

## 10. Troubleshooting Masalah Umum

| Masalah | Penyebab Umum | Solusi |
|---|---|---|
| **Error 500 (Internal Server Error)** | Versi PHP di bawah 8.2 atau ekstensi belum aktif | Buka cPanel > *Select PHP Version*, pastikan memilih **PHP 8.2** atau **PHP 8.3** dan centang `pdo_mysql`, `mbstring`, `gd`, `fileinfo`. |
| **Koneksi Database Gagal** | Nama database, username, atau password di `.env` salah | Buka kembali file `.env` di File Manager dan periksa kecocokan kredensial dengan database di cPanel. |
| **Halaman 404 saat klik menu** | Modul `mod_rewrite` atau file `.htaccess` tidak terunggah | Pastikan file `public/.htaccess` ada di hosting dan tidak terhapus. |
| **Gagal Unggah Gambar (Ukuran Terlalu Besar)** | Batasan `upload_max_filesize` di PHP cPanel | Buka cPanel > *MultiPHP INI Editor*, naikkan `upload_max_filesize` menjadi `10M` dan `post_max_size` menjadi `12M`. |
