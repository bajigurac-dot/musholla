-- BACKUP MUSHOLLA AR-RAHMAN
-- Date: 2026-10-19 10:42:46

-- Table: users
CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                username TEXT NOT NULL UNIQUE,
                email TEXT NOT NULL UNIQUE,
                password_hash TEXT NOT NULL,
                role TEXT NOT NULL DEFAULT 'editor',
                is_active INTEGER NOT NULL DEFAULT 1,
                last_login TEXT NULL,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                updated_at TEXT DEFAULT CURRENT_TIMESTAMP
            );
INSERT INTO `users` (`id`, `name`, `username`, `email`, `password_hash`, `role`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('1', 'Super Admin DKM', 'admin', 'dkm.musholla.arrahman@gmail.com', '$2y$10$v.xOKU/RRBlCOUyJ4gwwL.R734Xj/ZpStFdy9r8J8wSH.H6EpntHO', 'super_admin', '1', '2026-10-19 09:12:57', '2026-10-19 15:01:44', '2026-10-19 08:01:44');
INSERT INTO `users` (`id`, `name`, `username`, `email`, `password_hash`, `role`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES ('2', 'Editor Publikasi', 'editor', 'editor@musholla-arrahman.id', '$2y$10$XwBKzJKOFJdiHfGN8UxFSO5i9r4n9grZy1djLp4etRWpSu4g35ZGu', 'editor', '1', NULL, '2026-10-19 15:01:44', '2026-10-19 08:01:44');

-- Table: settings
CREATE TABLE settings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                setting_key TEXT NOT NULL UNIQUE,
                setting_value TEXT NULL,
                description TEXT NULL,
                updated_at TEXT DEFAULT CURRENT_TIMESTAMP
            );
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('1', 'mushola_name', 'Musholla Ar-rahman', 'Nama resmi musholla', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('2', 'tagline', 'Pusat Ibadah, Kebersamaan, dan Pembinaan Umat di Lingkungan Gembor Periuk Tangerang', 'Tagline / Slogan', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('3', 'history', 'Musholla Ar-rahman berdiri sejak tahun 1990 dengan gotong royong warga sekitar dan dibantu oleh pemerintah setempat untuk kegiatan beribadah lingkungan sekitarnya sehingga warga masyarakat semakin taat dan semangat dalam melakukan beribadah.', 'Sejarah berdirinya musholla', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('4', 'vision', 'Terwujudnya Musholla Ar-rahman sebagai pusat ibadah yang makmur, mempererat ukhuwah islamiyah, dan melahirkan generasi Qur''ani yang berakhlak mulia.', 'Visi musholla', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('5', 'mission', '1. Menyelenggarakan sholat berjamaah lima waktu secara istiqomah.
2. Mengadakan kajian keislaman dan yasinan rutin untuk mempererat silaturahmi warga.
3. Mengelola sarana dan prasarana ibadah yang bersih, nyaman, dan ramah jamaah.
4. Membina anak-anak dan generasi muda dalam membaca Al-Qur''an.
5. Menjaga transparansi dan amanah dalam pengelolaan kas musholla.', 'Misi musholla', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('6', 'facilities', 'Ruang Sholat Ber-AC, Tempat Wudhu Pria & Wanita Terpisah, Sound System Berkualitas, Perpustakaan Mini & Al-Qur''an Wakaf, Kamar Mandi Bersih, Area Parkir Motor, Karpet Sholat Nyaman, Genset Cadangan Listrik.', 'Fasilitas musholla', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('7', 'address', 'Jl. Anyer RT 007 RW 07, Kelurahan Gembor, Kecamatan Periuk, Kota Tangerang, Banten 15133', 'Alamat lengkap', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('8', 'phone_1', '0813-8619-8079', 'Kontak pengurus 1 (WhatsApp)', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('9', 'phone_2', '0812-9465-6075', 'Kontak pengurus 2 (WhatsApp)', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('10', 'email', 'dkm.musholla.arrahman@gmail.com', 'Email resmi pengurus', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('11', 'maps_url', 'https://maps.app.goo.gl/JZzSrDEKjCseGwgw7?g_st=aw', 'Tautan Google Maps', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('12', 'maps_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15866.505295982056!2d106.577239!3d-6.180424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f8c6543b5935%3A0x6b4847e9545dc6a9!2sGembor%2C%20Periuk%2C%20Tangerang%20City%2C%20Banten!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid', 'Embed URL Google Maps', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('13', 'dkm_lead', 'USTADZ TATA A.S', 'Ketua DKM', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('14', 'dkm_treasurer', 'Bapak Suwadi', 'Bendahara DKM', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('15', 'dkm_secretary', 'Bapak Bakri', 'Sekretaris DKM', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('16', 'donation_active', '1', 'Status modul donasi (1=aktif, 0=nonaktif)', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('17', 'donation_bank', 'Bank BJB', 'Nama bank rekening donasi', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('18', 'donation_account', '0152632533100', 'Nomor rekening resmi', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('19', 'donation_holder', 'Musholla Ar-rahman', 'Atas nama rekening', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('20', 'donation_notes', 'Donasi dapat disalurkan melalui transfer ke rekening Bank BJB di atas. Mohon sertakan bukti transfer via WhatsApp ke nomor pengurus untuk verifikasi dan pencatatan.', 'Petunjuk donasi', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('21', 'finance_active', '1', 'Status modul laporan kas keuangan (1=aktif, 0=nonaktif)', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('22', 'prayer_mode', 'api', 'Mode jadwal salat (api / manual)', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('23', 'prayer_city', 'Kota Tangerang', 'Kota perhitungan jadwal salat', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('24', 'hero_image', '', 'Foto hero utama', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('25', 'logo_image', '', 'Logo musholla', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('26', 'qris_image', '', 'Gambar QRIS resmi', '2026-10-19 08:01:44');
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES ('27', 'dkm_lead_photo', 'ketua-dkm-ustadz-tata.jpeg', 'Foto Ketua DKM Ustadz Tata A.S', '2026-10-19 08:18:50');

-- Table: posts
CREATE TABLE posts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                slug TEXT NOT NULL UNIQUE,
                category TEXT NOT NULL DEFAULT 'Berita',
                excerpt TEXT NULL,
                content TEXT NOT NULL,
                image TEXT NULL,
                author TEXT DEFAULT 'Pengurus DKM',
                status TEXT NOT NULL DEFAULT 'Terbit',
                views INTEGER DEFAULT 0,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                updated_at TEXT DEFAULT CURRENT_TIMESTAMP
            );
INSERT INTO `posts` (`id`, `title`, `slug`, `category`, `excerpt`, `content`, `image`, `author`, `status`, `views`, `created_at`, `updated_at`) VALUES ('1', 'Jadwal Pengajian Rutin Bulanan dan Kajian Fiqih Ibadah', 'jadwal-pengajian-rutin-bulanan-dan-kajian-fiqih-ibadah', 'Berita', 'DKM Musholla Ar-rahman Gembor Periuk mengundang seluruh warga jamaah dalam pengajian rutin bulanan yang diselenggarakan setiap Ahad pagi pekan pertama.', '<p>Assalamu''alaikum Warahmatullahi Wabarakatuh,</p><p>Segala puji bagi Allah SWT yang senantiasa melimpahkan rahmat dan hidayah-Nya kepada kita semua. DKM Musholla Ar-rahman mengundang bapak, ibu, serta kaum muslimin dan muslimat warga RT 007 RW 07 Kelurahan Gembor dan sekitarnya untuk menghadiri agenda <strong>Pengajian Rutin Bulanan</strong>.</p><p>Agenda pengajian ini membahas kajian Fiqih Ibadah sehari-hari dan Tausiyah pemantapan aqidah yang dibimbing langsung oleh Ustadz Tata A.S. Pengajian ini bertujuan mempererat silaturahmi antarwarga serta menambah wawasan keislaman kita.</p><p>Mari kita ajak keluarga tercinta untuk memakmurkan musholla kita. Semoga setiap langkah kaki kita menuju majelis ilmu bernilai pahala berlipat ganda di sisi Allah SWT. Aamiin ya Rabbal ''Alamin.</p>', 'foto-kegiatan-6.jpeg', 'USTADZ TATA A.S', 'Terbit', '142', '2026-10-19 08:01:44', '2026-10-19 08:01:44');
INSERT INTO `posts` (`id`, `title`, `slug`, `category`, `excerpt`, `content`, `image`, `author`, `status`, `views`, `created_at`, `updated_at`) VALUES ('2', 'Pelaksanaan Yasinan dan Doa Bersama Malam Jum''at Berkah', 'pelaksanaan-yasinan-dan-doa-bersama-malam-jumat-berkah', 'Berita', 'Kegiatan Yasinan rutin setiap malam Jum''at ba''da Maghrib terus berjalan istiqomah dengan dihadiri jamaah warga lingkungan sekitar.', '<p>Alhamdulillah, kegiatan yasinan dan tahlil bersama warga yang dilaksanakan setiap malam Jum''at di Musholla Ar-rahman terus berjalan dengan penuh khidmat dan istiqomah.</p><p>Kegiatan dimulai selepas sholat Maghrib berjamaah, dilanjutkan dengan pembacaan Surat Yasin, tahlil, doa untuk para sesepuh dan warga yang telah mendahului kita, serta ramah tamah setelah sholat Isya berjamaah.</p><p>Kami mengajak segenap pemuda dan bapak-bapak untuk terus hadir dan meramaikan musholla tercinta kita.</p>', 'foto-kegiatan.jpeg', 'Sekretaris DKM', 'Terbit', '98', '2026-10-19 08:01:44', '2026-10-19 08:01:44');
INSERT INTO `posts` (`id`, `title`, `slug`, `category`, `excerpt`, `content`, `image`, `author`, `status`, `views`, `created_at`, `updated_at`) VALUES ('3', 'Pengumuman Kerja Bakti Kebersihan Lingkungan Musholla', 'pengumuman-kerja-bakti-kebersihan-lingkungan-musholla', 'Pengumuman', 'Dalam rangka menjaga kesucian dan kenyamanan tempat ibadah, DKM bersama warga akan mengadakan kerja bakti bersama pada hari Ahad besok.', '<p>Diberitahukan kepada seluruh warga RT 007 RW 07 Kelurahan Gembor, bahwa pengurus DKM Musholla Ar-rahman akan mengadakan kegiatan kerja bakti dan gotong royong membersihkan area dalam musholla, tempat wudhu, serta halaman sekitarnya.</p><p>Hari/Tanggal: Ahad, Pukul 07.30 WIB sampai dengan selesai. Diharapkan bapak-bapak dan remaja membawa peralatan kebersihan seadanya. Konsumsi ringan akan disediakan oleh pengurus.</p><p>Terima kasih atas partisipasi dan kepedulian bersama warga sekalian.</p>', 'foto-kegiatan-9.jpeg', 'Bapak Bakri', 'Terbit', '65', '2026-10-19 08:01:44', '2026-10-19 08:01:44');
INSERT INTO `posts` (`id`, `title`, `slug`, `category`, `excerpt`, `content`, `image`, `author`, `status`, `views`, `created_at`, `updated_at`) VALUES ('4', 'Laporan Penyaluran Infaq dan Pemeliharaan Sarana Ibadah', 'laporan-penyaluran-infaq-dan-pemeliharaan-sarana-ibadah', 'Berita', 'Laporan keterbukaan infaq jamaah yang digunakan untuk pemeliharaan pendingin ruangan (AC) dan kebersihan karpet musholla.', '<p>Sebagai wujud transparansi dan amanah kepengurusan, kami menyampaikan bahwa dana infaq jamaah pada bulan ini sebagian telah dialokasikan untuk pemeliharaan rutin pendingin ruangan (AC) musholla dan pencucian karpet sholat agar jamaah dapat beribadah dengan lebih khusyuk dan nyaman.</p><p>Kami mengucapkan jazakumullah khairan katsiran kepada seluruh donatur dan jamaah yang istiqomah menyisihkan sebagian rezekinya untuk Musholla Ar-rahman.</p>', 'foto-kegiatan-7.jpeg', 'Bapak Suwadi', 'Terbit', '82', '2026-10-19 08:01:44', '2026-10-19 08:01:44');

-- Table: events
CREATE TABLE events (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                slug TEXT NOT NULL UNIQUE,
                description TEXT NOT NULL,
                image TEXT NULL,
                event_date TEXT NOT NULL,
                start_time TEXT DEFAULT '18:00',
                end_time TEXT DEFAULT 'Selesai',
                location TEXT DEFAULT 'Musholla Ar-rahman',
                category TEXT DEFAULT 'Rutin',
                status TEXT NOT NULL DEFAULT 'Mendatang',
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                updated_at TEXT DEFAULT CURRENT_TIMESTAMP
            );
INSERT INTO `events` (`id`, `title`, `slug`, `description`, `image`, `event_date`, `start_time`, `end_time`, `location`, `category`, `status`, `created_at`, `updated_at`) VALUES ('1', 'Sholat 5 Waktu Berjamaah', 'sholat-5-waktu-berjamaah', 'Menunaikan sholat fardhu lima waktu (Subuh, Dzuhur, Ashar, Maghrib, Isya) secara berjamaah tepat waktu dengan kumandang adzan dan iqamah.', 'foto-kegiatan-3.jpeg', '2026-10-20', '04:15', '20:00', 'Ruang Utama Musholla Ar-rahman', 'Ibadah Harian', 'Mendatang', '2026-10-19 08:01:44', '2026-10-19 08:01:44');
INSERT INTO `events` (`id`, `title`, `slug`, `description`, `image`, `event_date`, `start_time`, `end_time`, `location`, `category`, `status`, `created_at`, `updated_at`) VALUES ('2', 'Yasinan & Tahlil Malam Jum''at', 'yasinan-dan-tahlil-malam-jumat', 'Pembacaan Surat Yasin, tahlil, zikir, dan doa bersama untuk keselamatan warga serta mendoakan para sesepuh yang telah berpulang ke rahmatullah.', 'foto-kegiatan.jpeg', '2026-10-23', '18:15', '19:45', 'Musholla Ar-rahman Gembor', 'Mingguan', 'Mendatang', '2026-10-19 08:01:44', '2026-10-19 08:01:44');
INSERT INTO `events` (`id`, `title`, `slug`, `description`, `image`, `event_date`, `start_time`, `end_time`, `location`, `category`, `status`, `created_at`, `updated_at`) VALUES ('3', 'Pengajian Rutin Bulanan Warga', 'pengajian-rutin-bulanan-warga', 'Kajian tafsir tematik dan fiqih ibadah bersama Ustadz Tata A.S untuk seluruh bapak, ibu, dan remaja muslim warga RT 007 RW 07 Gembor Periuk.', 'foto-kegiatan-6.jpeg', '2026-11-01', '08:00', '10:30', 'Musholla Ar-rahman', 'Bulanan', 'Mendatang', '2026-10-19 08:01:44', '2026-10-19 08:01:44');
INSERT INTO `events` (`id`, `title`, `slug`, `description`, `image`, `event_date`, `start_time`, `end_time`, `location`, `category`, `status`, `created_at`, `updated_at`) VALUES ('4', 'Bimbingan Baca Tulis Al-Qur''an Anak-Anak', 'bimbingan-baca-tulis-al-quran-anak-anak', 'Pembelajaran Iqro dan tahsin Al-Qur''an untuk anak-anak dan remaja lingkungan sekitar yang dilaksanakan setiap sore hari Senin hingga Kamis.', 'foto-kegiatan-1.jpeg', '2026-10-26', '16:00', '17:30', 'Serambi Musholla Ar-rahman', 'Pendidikan', 'Mendatang', '2026-10-19 08:01:44', '2026-10-19 08:01:44');

-- Table: galleries
CREATE TABLE galleries (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                image TEXT NOT NULL,
                category TEXT DEFAULT 'Kegiatan',
                alt_text TEXT NULL,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            );
INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `alt_text`, `created_at`) VALUES ('18', 'Tausiyah dan Kajian oleh Ustadz Tata A.S di Mihrab Musholla', 'foto-kegiatan.jpeg', 'Kajian', 'Ustadz Tata A.S menyampaikan tausiyah dan pengajian kepada jamaah di mihrab Musholla Ar-rahman', '2026-10-19 08:32:27');
INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `alt_text`, `created_at`) VALUES ('19', 'Khutbah dan Sambutan Pengurus DKM di Depan Jamaah', 'foto-kegiatan-1.jpeg', 'Kajian', 'Sambutan dan arahan pengurus DKM Musholla Ar-rahman', '2026-10-19 08:32:27');
INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `alt_text`, `created_at`) VALUES ('20', 'Jamaah Memakmurkan Ruang Utama Sholat Musholla', 'foto-kegiatan-2.jpeg', 'Ibadah', 'Suasana jamaah yang tertib dan khusyuk di ruang utama', '2026-10-19 08:32:27');
INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `alt_text`, `created_at`) VALUES ('21', 'Antusiasme Jamaah Menghadiri Pengajian Rutin', 'foto-kegiatan-3.jpeg', 'Kajian', 'Antusiasme warga dari anak-anak hingga orang tua dalam majelis taklim', '2026-10-19 08:32:27');
INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `alt_text`, `created_at`) VALUES ('22', 'Jamaah Khusyuk Mengikuti Acara dari Selasar Musholla', 'foto-kegiatan-4.jpeg', 'Kegiatan', 'Jamaah tetap khusyuk mengikuti rangkaian ibadah dari selasar samping', '2026-10-19 08:32:27');
INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `alt_text`, `created_at`) VALUES ('23', 'Sholat Berjamaah Khusyuk Warga Gembor Periuk', 'foto-kegiatan-5.jpeg', 'Ibadah', 'Jamaah menunaikan sholat fardhu berjamaah dengan tertib', '2026-10-19 08:32:27');
INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `alt_text`, `created_at`) VALUES ('24', 'Suasana Ibadah Khusyuk & Penanda Waktu Salat Digital', 'foto-kegiatan-6.jpeg', 'Ibadah', 'Fasilitas jam digital penanda waktu salat dan jamaah yang khusyuk', '2026-10-19 08:32:27');
INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `alt_text`, `created_at`) VALUES ('25', 'Tampak Depan Musholla Ar-rahman & Pelataran', 'foto-kegiatan-7.jpeg', 'Fasilitas', 'Fasad depan bangunan Musholla Ar-rahman RT 007 RW 07 Gembor Periuk', '2026-10-19 08:32:27');
INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `alt_text`, `created_at`) VALUES ('26', 'Pertemuan Rutin & Doa Bersama Pengurus DKM Warga', 'foto-kegiatan-8.jpeg', 'Kegiatan', 'Pengurus DKM dan tokoh masyarakat dalam musyawarah kemakmuran musholla', '2026-10-19 08:32:27');
INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `alt_text`, `created_at`) VALUES ('27', 'Silaturahmi Malam Jum''at (Yasinan & Tahlil Bersama)', 'foto-kegiatan-9.jpeg', 'Sosial', 'Kebersamaan warga melantunkan Surat Yasin, tahlil, dan doa bersama', '2026-10-19 08:32:27');
INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `alt_text`, `created_at`) VALUES ('28', 'Tim Hadroh & Remaja Musholla (Remus) Ar-rahman', 'foto-kegiatan-10.jpeg', 'Kegiatan', 'Generasi muda santri dan tim hadroh bersama pengurus DKM Ar-rahman', '2026-10-19 08:32:27');
INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `alt_text`, `created_at`) VALUES ('29', 'Jamaah Sholat & Pengajian Akbar di Teras Musholla', 'foto-kegiatan-11.jpeg', 'Ibadah', 'Meluapnya jamaah sholat berjamaah dan pengajian akbar hingga ke teras depan', '2026-10-19 08:32:27');

-- Table: financial_reports
CREATE TABLE financial_reports (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                period_month INTEGER NOT NULL,
                period_year INTEGER NOT NULL,
                income REAL NOT NULL DEFAULT 0.00,
                expense REAL NOT NULL DEFAULT 0.00,
                balance REAL NOT NULL DEFAULT 0.00,
                description TEXT NULL,
                status TEXT NOT NULL DEFAULT 'Terbit',
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                updated_at TEXT DEFAULT CURRENT_TIMESTAMP
            );
INSERT INTO `financial_reports` (`id`, `period_month`, `period_year`, `income`, `expense`, `balance`, `description`, `status`, `created_at`, `updated_at`) VALUES ('1', '9', '2026', '4850000', '3120000', '1730000', 'Laporan Kas Bulan September 2026. Pemasukan dari kotak infaq Jumat dan donatur. Pengeluaran untuk listrik PLN, honor kebersihan, dan perlengkapan ibadah.', 'Terbit', '2026-10-19 08:01:44', '2026-10-19 08:01:44');
INSERT INTO `financial_reports` (`id`, `period_month`, `period_year`, `income`, `expense`, `balance`, `description`, `status`, `created_at`, `updated_at`) VALUES ('2', '10', '2026', '5200000', '2850000', '2350000', 'Laporan Kas Bulan Oktober 2026. Pemasukan dari infaq jamaah, sedekah subuh, dan transfer Bank BJB. Pengeluaran untuk operasional rutin dan servis AC.', 'Terbit', '2026-10-19 08:01:44', '2026-10-19 08:01:44');

-- Table: contact_messages
CREATE TABLE contact_messages (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                phone TEXT NULL,
                email TEXT NULL,
                subject TEXT NOT NULL,
                message TEXT NOT NULL,
                is_read INTEGER NOT NULL DEFAULT 0,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            );
INSERT INTO `contact_messages` (`id`, `name`, `phone`, `email`, `subject`, `message`, `is_read`, `created_at`) VALUES ('1', 'Haji Ridwan', '081298765432', 'ridwan@example.com', 'Izin Koordinasi Kajian', 'Assalamu''alaikum, kami bermaksud silaturahmi dan berkoordinasi mengenai jadwal kajian warga RT 07 pada pekan depan. Terima kasih.', '0', '2026-10-19 15:08:29');
INSERT INTO `contact_messages` (`id`, `name`, `phone`, `email`, `subject`, `message`, `is_read`, `created_at`) VALUES ('2', 'Haji Ridwan', '081298765432', 'ridwan@example.com', 'Izin Koordinasi Kajian', 'Assalamu''alaikum ustadz, kami ingin koordinasi kajian pekan depan.', '0', '2026-10-19 15:09:26');

