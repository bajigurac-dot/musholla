# Panduan Lengkap Backup & Deployment ke Vercel (Next.js + SQLite)
**Musholla Ar-rahman - Gembor, Periuk, Kota Tangerang**

Dokumen ini memuat panduan lengkap mengenai backup data yang telah diamankan serta petunjuk langkah demi langkah mendeploy website ke **Vercel**.

---

## 1. Lokasi & Bukti Backup Data Lama

Sebelum proses migrasi dilakukan, seluruh data website dan source code telah diamankan 100% ke dalam folder `backups/`:

| Nama File Backup | Ukuran | Keterangan |
| :--- | :--- | :--- |
| `backups/mushola_complete_source_backup.zip` | ~6.0 MB | **Arsip ZIP lengkap** berisi seluruh source code PHP MVC, gambar asli di `gambar/`, file upload di `public/uploads/`, dan database. |
| `backups/mushola_data_export.json` | ~22 KB | Ekspor data lengkap semua tabel (users, settings, posts, events, galleries, financial_reports, contact_messages) dalam format JSON standar. |
| `backups/mushola_database_dump.sql` | ~22 KB | Dump database SQL lengkap (CREATE TABLE dan INSERT statements). |
| `backups/mushola.sqlite` | ~57 KB | Salinan biner database SQLite asli. |

> **Catatan:** Data Anda tersimpan aman dan dapat dipulihkan atau diimpor kapan pun diperlukan.

---

## 2. Arsitektur Baru yang Optimal di Vercel

Aplikasi baru dibuat di folder `mushola-web/` menggunakan:
- **Framework**: **Next.js 16 (App Router)** + **React 19** + **TypeScript**
- **Styling**: **Tailwind CSS v4** (Modern, Mobile-First, Responsive)
- **Database Engine**: **SQLite via `@libsql/client`**
  - **Lokal**: Membaca & menulis langsung ke `database/mushola.sqlite`.
  - **Di Vercel**: Kompatibel langsung dengan **Turso (Serverless Cloud SQLite)** yang 100% gratis permanen.
- **Email Resmi**: `dkm.musholla.arrahman@gmail.com`
- **Rekening Resmi**: Bank BJB `0152632533100` a.n. Musholla Ar-rahman
- **Autentikasi Admin**: `admin` / `admin123` dengan proteksi JWT cookie.

---

## 3. Langkah-Langkah Deploy ke Vercel

### Cara A: Deploy via GitHub & Vercel Dashboard (Paling Direkomendasikan)

1. **Upload folder `mushola-web` ke GitHub**:
   ```bash
   cd mushola-web
   git init
   git add .
   git commit -m "Initial commit Musholla Ar-rahman Next.js App"
   git branch -M main
   git remote add origin https://github.com/USERNAME/mushola-arrahman.git
   git push -u origin main
   ```

2. **Buka Vercel Dashboard** ([vercel.com](https://vercel.com)):
   - Klik **"Add New..."** -> **"Project"**.
   - Pilih repositori GitHub `mushola-arrahman` yang baru Anda buat.
   - Pada bagian **Root Directory**, jika Anda mengupload seluruh folder repo, arahkan ke `mushola-web` (atau langsung root jika repo hanya berisi isi `mushola-web`).
   - Framework Preset: **Next.js** (terdeteksi otomatis).

3. **(Opsional & Sangat Direkomendasikan) Hubungkan ke Cloud SQLite Gratis (Turso)**:
   Karena filesystem di Vercel Serverless bersifat *ephemeral* (read-only), gunakan Turso agar fitur admin (tambah berita, edit kas, upload foto) tersimpan permanen di cloud:
   - Buat akun gratis di [turso.tech](https://turso.tech).
   - Buat database: `mushola-db`.
   - Di dashboard Vercel pada bagian **Environment Variables**, tambahkan:
     - `TURSO_DATABASE_URL`: `libsql://mushola-db-xxxx.turso.io`
     - `TURSO_AUTH_TOKEN`: `eyJhbGciOi...`
   - *Aplikasi telah dilengkapi auto-seeder: Begitu terhubung ke database baru, seluruh data profil, pengurus, email `dkm.musholla.arrahman@gmail.com`, 12 foto kegiatan, berita, dan jadwal sholat akan otomatis terisi!*

4. **Klik "Deploy"**:
   - Vercel akan mem-build aplikasi dalam waktu ~30 detik.
   - Website Musholla Ar-rahman Anda langsung online dengan domain gratis seperti `mushola-arrahman.vercel.app` + SSL HTTPS aktif!

---

### Cara B: Deploy Langsung via Vercel CLI

Jika Anda memiliki Vercel CLI di komputer:
```powershell
cd d:\AWS_QDEV\mushola\mushola-web
npx vercel
```
Ikuti petunjuk di terminal, lalu jalankan `npx vercel --prod` untuk merilis ke production.

---

## 4. Cara Menjalankan Secara Lokal di Komputer

Jika ingin menguji atau mengedit web di komputer:
1. Buka PowerShell di folder `mushola-web`:
   ```powershell
   cd d:\AWS_QDEV\mushola\mushola-web
   npm run dev
   ```
2. Buka browser di [http://localhost:3000](http://localhost:3000).
3. Halaman Admin: [http://localhost:3000/admin/login](http://localhost:3000/admin/login)
   - **Username**: `admin`
   - **Password**: `admin123`
