import Link from "next/link";
import PrayerBanner from "@/components/PrayerBanner";
import {
  getSettings,
  getPosts,
  getEvents,
  getGalleries,
} from "@/lib/data";
import { getPrayerTimes } from "@/lib/prayer";
import { uploadUrl, limitWords, formatDate } from "@/lib/helper";

export default async function HomePage() {
  const [settings, posts, events, galleries, prayerTimes] = await Promise.all([
    getSettings(),
    getPosts(3),
    getEvents(4),
    getGalleries(),
    getPrayerTimes(),
  ]);

  const recentGalleries = galleries.slice(0, 8);
  const musholaName = settings.mushola_name || "Musholla Ar-rahman";
  const tagline = settings.tagline || "Pusat Ibadah, Kebersamaan, dan Pembinaan Umat di Lingkungan Gembor Periuk Tangerang";
  const history = settings.history || "Musholla Ar-rahman berdiri sejak tahun 1990 dengan gotong royong warga sekitar dan dibantu oleh pemerintah setempat untuk kegiatan beribadah lingkungan sekitarnya sehingga warga masyarakat semakin taat dan semangat dalam melakukan beribadah.";
  const phone1 = settings.phone_1 || "0813-8619-8079";
  const phone2 = settings.phone_2 || "0812-9465-6075";
  const address = settings.address || "Jl. Anyer RT 007 RW 07, Kelurahan Gembor, Kecamatan Periuk, Kota Tangerang, Banten 15133";
  const bankAccount = settings.donation_account || "0152632533100";
  const bankName = settings.donation_bank || "Bank BJB";
  const mapsEmbed = settings.maps_embed || "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15866.505295982056!2d106.577239!3d-6.180424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f8c6543b5935%3A0x6b4847e9545dc6a9!2sGembor%2C%20Periuk%2C%20Tangerang%20City%2C%20Banten!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid";
  const mapsUrl = settings.maps_url || "https://maps.app.goo.gl/JZzSrDEKjCseGwgw7?g_st=aw";
  const phone1Clean = phone1.replace(/[^0-9]/g, "").replace(/^0/, "");

  return (
    <>
      {/* 1. Hero Section - SAMA PERSIS SEPERTI PHP ORIGINAL */}
      <section className="hero-section">
        <div className="container">
          <div className="row align-items-center g-4 g-lg-5">
            {/* Kolom Kiri Hero */}
            <div className="col-lg-6">
              <div className="hero-badge">
                <i className="bi bi-geo-alt-fill text-warning"></i> RT 007 RW 07 Gembor, Periuk - Tangerang
              </div>
              <h1 className="hero-title">
                Selamat Datang di Website Resmi <br />
                <span>{musholaName}</span>
              </h1>
              <p className="hero-desc">
                {tagline}. Berdiri sejak tahun 1990 atas gotong royong warga untuk membina ukhuwah islamiyah dan generasi Qur&apos;ani.
              </p>
              <div className="d-flex flex-wrap gap-3">
                <Link href="/profil" className="btn btn-gold btn-lg">
                  <i className="bi bi-info-circle-fill me-1"></i> Lihat Profil Musholla
                </Link>
                <Link href="/kegiatan" className="btn btn-outline-light-custom btn-lg">
                  <i className="bi bi-calendar3 me-1"></i> Agenda Kegiatan
                </Link>
                <Link href="/keuangan#donasi" className="btn btn-primary-custom btn-lg bg-white text-dark">
                  <i className="bi bi-heart-fill text-danger me-1"></i> Infaq & Donasi
                </Link>
              </div>
            </div>

            {/* Kolom Kanan: Glassmorphism Card Showcase */}
            <div className="col-lg-5 col-xl-5 offset-xl-1">
              <div className="hero-glass-card shadow-2xl">
                <div className="d-flex align-items-center justify-content-between mb-3 border-bottom border-white border-opacity-25 pb-3">
                  <div className="d-flex align-items-center gap-2">
                    <div
                      className="p-2 bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center"
                      style={{ width: 42, height: 42 }}
                    >
                      <i className="bi bi-moon-stars-fill fs-5"></i>
                    </div>
                    <div>
                      <h6 className="m-0 fw-bold text-white">{musholaName}</h6>
                      <small className="text-white-50">
                        <i className="bi bi-geo-alt-fill text-warning me-1"></i>Gembor, Periuk - Tangerang
                      </small>
                    </div>
                  </div>
                  <span
                    className="badge bg-gold fw-bold px-3 py-1 rounded-pill shadow-sm"
                    style={{
                      background: "linear-gradient(135deg, #D4AF37 0%, #F3D068 100%)",
                      color: "#032820",
                      fontWeight: 700,
                      fontSize: "0.82rem",
                      boxShadow: "0 2px 8px rgba(212, 175, 55, 0.4)",
                      border: "1px solid rgba(255, 255, 255, 0.3)",
                    }}
                  >
                    Est. 1990
                  </span>
                </div>

                <p className="text-white small mb-3 leading-relaxed" style={{ opacity: 0.92 }}>
                  &ldquo;Berdiri sejak tahun 1990 atas gotong royong warga sekitar dan dibantu pemerintah setempat untuk membina ukhuwah islamiyah dan generasi Qur&apos;ani.&rdquo;
                </p>

                <div className="row g-2 mb-3">
                  <div className="col-6">
                    <div
                      className="p-3 rounded-3 text-center border border-white border-opacity-15"
                      style={{ background: "rgba(0,0,0,0.22)" }}
                    >
                      <i className="bi bi-people-fill text-warning fs-3 mb-1 d-block"></i>
                      <strong className="d-block text-white fs-6">Gotong Royong</strong>
                      <span className="text-white-50" style={{ fontSize: "0.72rem" }}>
                        Warga RT 007 RW 07
                      </span>
                    </div>
                  </div>
                  <div className="col-6">
                    <div
                      className="p-3 rounded-3 text-center border border-white border-opacity-15"
                      style={{ background: "rgba(0,0,0,0.22)" }}
                    >
                      <i className="bi bi-book-half text-success-subtle fs-3 mb-1 d-block"></i>
                      <strong className="d-block text-white fs-6">Kajian & Syiar</strong>
                      <span className="text-white-50" style={{ fontSize: "0.72rem" }}>
                        Yasinan & Pengajian
                      </span>
                    </div>
                  </div>
                </div>

                <div className="d-flex align-items-center justify-content-between pt-2 border-top border-white border-opacity-25">
                  <div className="text-white small">
                    <span className="d-block fw-semibold" style={{ fontSize: "0.78rem" }}>
                      <i className="bi bi-person-badge text-warning me-1"></i> Ketua DKM:
                    </span>
                    <span className="text-white-50 small">{settings.dkm_lead || "USTADZ TATA A.S"}</span>
                  </div>
                  <Link
                    href="/profil"
                    className="btn btn-sm btn-outline-light rounded-pill px-3 fw-bold"
                  >
                    Profil & Sejarah <i className="bi bi-arrow-right ms-1"></i>
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* 2. Jadwal Salat Widget - Floating Prayer Card */}
      <PrayerBanner initialTimes={prayerTimes} />

      {/* 3. Ringkasan Profil & Kegiatan Utama */}
      <section className="py-5 mt-4">
        <div className="container">
          <div className="row g-4 align-items-center">
            <div className="col-lg-6">
              <span className="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
                SEJARAH & AMANAH
              </span>
              <h2 className="fw-bold mb-3">Tiga Dekade Melayani Jamaah & Warga Sekitar</h2>
              <p className="text-muted leading-relaxed">{history}</p>

              <div className="row g-3 mt-2">
                <div className="col-md-4">
                  <div className="p-3 bg-white border rounded-3 text-center h-100 shadow-sm">
                    <i className="bi bi-bell-fill text-success fs-2 mb-2 d-block"></i>
                    <strong className="d-block text-dark small">Sholat 5 Waktu</strong>
                    <span className="text-muted" style={{ fontSize: "0.75rem" }}>
                      Berjamaah Tepat Waktu
                    </span>
                  </div>
                </div>
                <div className="col-md-4">
                  <div className="p-3 bg-white border rounded-3 text-center h-100 shadow-sm">
                    <i className="bi bi-book-half text-warning fs-2 mb-2 d-block"></i>
                    <strong className="d-block text-dark small">Malam Jum&apos;at</strong>
                    <span className="text-muted" style={{ fontSize: "0.75rem" }}>
                      Yasinan & Tahlil Bersama
                    </span>
                  </div>
                </div>
                <div className="col-md-4">
                  <div className="p-3 bg-white border rounded-3 text-center h-100 shadow-sm">
                    <i className="bi bi-people-fill text-primary fs-2 mb-2 d-block"></i>
                    <strong className="d-block text-dark small">Pengajian Rutin</strong>
                    <span className="text-muted" style={{ fontSize: "0.75rem" }}>
                      Kajian Bulanan Warga
                    </span>
                  </div>
                </div>
              </div>

              <div className="mt-4">
                <Link href="/profil" className="btn btn-outline-success fw-bold">
                  Pelajari Sejarah & Struktur DKM <i className="bi bi-arrow-right ms-1"></i>
                </Link>
              </div>
            </div>

            <div className="col-lg-6">
              <div className="position-relative">
                <img
                  src={uploadUrl("foto-kegiatan-7.jpeg")}
                  alt="Musholla Ar-rahman"
                  className="img-fluid rounded-4 shadow-lg w-100 object-fit-cover"
                  style={{ minHeight: 320, maxHeight: 420 }}
                />
                <div
                  className="position-absolute bottom-0 start-0 m-3 p-3 bg-white rounded-3 shadow-sm border"
                  style={{ maxWidth: 320 }}
                >
                  <div className="d-flex align-items-center gap-2">
                    <div className="p-2 bg-success text-white rounded-circle">
                      <i className="bi bi-building-check fs-5"></i>
                    </div>
                    <div>
                      <h6 className="m-0 fw-bold">Musholla Ar-rahman</h6>
                      <small className="text-muted">Jl. Anyer RT 007 RW 07 Periuk</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* 4. Agenda Kegiatan Mendatang */}
      <section className="py-5 bg-white border-top border-bottom">
        <div className="container">
          <div className="d-flex justify-content-between align-items-end mb-4">
            <div>
              <span className="badge bg-warning-subtle text-warning-emphasis fw-bold px-3 py-2 rounded-pill mb-2">
                KEGIATAN & SYIAR
              </span>
              <h2 className="fw-bold m-0">Agenda Kegiatan Terdekat</h2>
            </div>
            <Link href="/kegiatan" className="btn btn-sm btn-outline-success fw-bold">
              Lihat Semua Kegiatan <i className="bi bi-arrow-right"></i>
            </Link>
          </div>

          <div className="row g-4">
            {events.map((evt) => (
              <div key={evt.id} className="col-md-6 col-lg-3">
                <div className="custom-card">
                  <img
                    src={uploadUrl(evt.image)}
                    alt={evt.title}
                    className="custom-card-img"
                  />
                  <div className="custom-card-body">
                    <div className="d-flex justify-content-between align-items-center mb-2">
                      <span className="card-badge card-badge-kegiatan">
                        {evt.category || "Rutin"}
                      </span>
                      <small className="text-muted">
                        <i className="bi bi-calendar-event me-1"></i>
                        {evt.event_date}
                      </small>
                    </div>
                    <h5 className="fw-bold fs-6 mb-2">
                      <Link href={`/kegiatan`} className="text-decoration-none text-dark">
                        {evt.title}
                      </Link>
                    </h5>
                    <p className="text-muted small mb-3 flex-grow-1">
                      {limitWords(evt.description, 14)}
                    </p>
                    <div className="border-top pt-2 small text-muted d-flex justify-content-between align-items-center">
                      <span>
                        <i className="bi bi-clock me-1"></i>
                        {evt.start_time} WIB
                      </span>
                      <Link href={`/kegiatan`} className="text-success fw-bold text-decoration-none">
                        Detail <i className="bi bi-arrow-right"></i>
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* 5. Berita & Pengumuman Terbaru */}
      <section className="py-5">
        <div className="container">
          <div className="d-flex justify-content-between align-items-end mb-4">
            <div>
              <span className="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
                WARTA MUSHOLLA
              </span>
              <h2 className="fw-bold m-0">Berita & Pengumuman Terbaru</h2>
            </div>
            <Link href="/berita" className="btn btn-sm btn-outline-success fw-bold">
              Arsip Berita <i className="bi bi-arrow-right"></i>
            </Link>
          </div>

          <div className="row g-4">
            {posts.map((post) => (
              <div key={post.id} className="col-md-4">
                <div className="custom-card">
                  <img
                    src={uploadUrl(post.image)}
                    alt={post.title}
                    className="custom-card-img"
                  />
                  <div className="custom-card-body">
                    <div className="d-flex justify-content-between align-items-center mb-2">
                      <span
                        className={`card-badge ${
                          post.category === "Pengumuman"
                            ? "card-badge-pengumuman"
                            : "card-badge-berita"
                        }`}
                      >
                        {post.category}
                      </span>
                      <small className="text-muted">
                        <i className="bi bi-clock me-1"></i>
                        {formatDate(post.created_at)}
                      </small>
                    </div>
                    <h5 className="fw-bold fs-6 mb-2">
                      <Link href={`/berita/${post.slug}`} className="text-decoration-none text-dark">
                        {post.title}
                      </Link>
                    </h5>
                    <p className="text-muted small mb-3 flex-grow-1">
                      {post.excerpt || limitWords(post.content, 20)}
                    </p>
                    <div className="border-top pt-2 d-flex justify-content-between align-items-center">
                      <small className="text-muted">
                        <i className="bi bi-person me-1"></i>
                        {post.author || "DKM"}
                      </small>
                      <Link
                        href={`/berita/${post.slug}`}
                        className="text-success fw-bold small text-decoration-none"
                      >
                        Baca Selengkapnya <i className="bi bi-arrow-right"></i>
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* 6. Sekilas Cuplikan Galeri Dokumentasi */}
      {recentGalleries.length > 0 && (
        <section className="py-5 bg-white border-top border-bottom">
          <div className="container">
            <div className="d-flex justify-content-between align-items-end mb-4">
              <div>
                <span className="badge bg-info-subtle text-info-emphasis fw-bold px-3 py-2 rounded-pill mb-2">
                  DOKUMENTASI
                </span>
                <h2 className="fw-bold m-0">Galeri Foto Kegiatan & Fasilitas</h2>
              </div>
              <Link href="/galeri" className="btn btn-sm btn-outline-success fw-bold">
                Lihat Seluruh Galeri <i className="bi bi-arrow-right"></i>
              </Link>
            </div>

            <div className="gallery-grid">
              {recentGalleries.map((gal) => (
                <div key={gal.id} className="gallery-item" data-title={gal.title}>
                  <img src={uploadUrl(gal.image)} alt={gal.title} loading="lazy" />
                  <div className="gallery-overlay">
                    <span className="badge bg-warning text-dark mb-1">
                      {gal.category || "Kegiatan"}
                    </span>
                    <h6 className="m-0 text-white fw-bold small">{gal.title}</h6>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>
      )}

      {/* 7. Modul Donasi & Rekening Bank BJB */}
      <section id="donasi" className="py-5">
        <div className="container">
          <div className="donation-card">
            <div className="row align-items-center g-4">
              <div className="col-lg-7">
                <span className="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill mb-3">
                  INFAQ & SEDEKAH JARIYAH
                </span>
                <h2 className="text-white fw-bold mb-3">
                  Salurkan Infaq Terbaik Anda untuk Kemakmuran Musholla Ar-rahman
                </h2>
                <p className="text-white-50 mb-4">
                  Setiap rupiah infaq dan sedekah yang Anda salurkan digunakan untuk operasional
                  harian, pemeliharaan sarana ibadah, dan kegiatan keagamaan jamaah lingkungan Gembor
                  Periuk Tangerang.
                </p>

                <div className="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-25 mb-4">
                  <div className="d-flex align-items-center gap-2 mb-2">
                    <span className="bank-badge">{bankName}</span>
                    <span className="text-white-50 small">
                      Atas Nama: <strong>Musholla Ar-rahman</strong>
                    </span>
                  </div>
                  <div className="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <span className="account-number">{bankAccount}</span>
                    <button
                      className="btn btn-gold btn-copy-account"
                      data-account={bankAccount}
                    >
                      <i className="bi bi-clipboard me-1"></i> Salin No. Rekening
                    </button>
                  </div>
                </div>

                <div className="d-flex flex-wrap gap-3">
                  <a
                    href={`https://wa.me/62${phone1Clean}?text=${encodeURIComponent(
                      "Assalamu'alaikum Pengurus DKM Musholla Ar-rahman, saya telah menyalurkan donasi via Bank BJB. Mohon konfirmasinya."
                    )}`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="btn btn-outline-light-custom"
                  >
                    <i className="bi bi-whatsapp me-1 text-success"></i> Konfirmasi via WhatsApp
                  </a>
                  <Link href="/keuangan" className="btn btn-link text-white text-decoration-none">
                    Lihat Laporan Transparansi Kas <i className="bi bi-arrow-right"></i>
                  </Link>
                </div>
              </div>

              <div className="col-lg-5 text-center">
                <div
                  className="bg-white p-4 rounded-4 shadow-lg d-inline-block text-dark"
                  style={{ maxWidth: 320 }}
                >
                  <img
                    src="/assets/images/default-qris.svg"
                    alt="QRIS Musholla Ar-rahman"
                    className="img-fluid rounded-3 mb-3"
                  />
                  <h6 className="fw-bold mb-1">Scan QRIS Infaq Resmi</h6>
                  <small className="text-muted d-block">
                    BCA, Mandiri, BRI, BSI, Gopay, OVO, Dana, dll
                  </small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* 8. Lokasi & Peta Google Maps */}
      <section className="py-5 bg-white border-top">
        <div className="container">
          <div className="row g-4 align-items-center">
            <div className="col-lg-5">
              <span className="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
                LOKASI KAMI
              </span>
              <h2 className="fw-bold mb-3">Kunjungi Musholla Ar-rahman</h2>
              <p className="text-muted mb-4">
                Musholla Ar-rahman terletak di tengah lingkungan masyarakat yang asri dan guyub di
                Kelurahan Gembor, Periuk Kota Tangerang.
              </p>

              <div className="d-flex flex-column gap-3 mb-4">
                <div className="d-flex align-items-start gap-3">
                  <div className="p-2 bg-success-subtle text-success rounded-3">
                    <i className="bi bi-geo-alt-fill fs-5"></i>
                  </div>
                  <div>
                    <strong className="d-block text-dark">Alamat Lengkap:</strong>
                    <span className="text-muted small">{address}</span>
                  </div>
                </div>
                <div className="d-flex align-items-start gap-3">
                  <div className="p-2 bg-success-subtle text-success rounded-3">
                    <i className="bi bi-telephone-fill fs-5"></i>
                  </div>
                  <div>
                    <strong className="d-block text-dark">Kontak Pengurus DKM:</strong>
                    <span className="text-muted small">
                      {phone1} / {phone2}
                    </span>
                  </div>
                </div>
              </div>

              <a
                href={mapsUrl}
                target="_blank"
                rel="noopener noreferrer"
                className="btn btn-primary-custom"
              >
                <i className="bi bi-pin-map-fill me-1"></i> Buka Rute di Google Maps
              </a>
            </div>

            <div className="col-lg-7">
              <div
                className="rounded-4 overflow-hidden shadow-sm border"
                style={{ minHeight: 350 }}
              >
                <iframe
                  src={mapsEmbed}
                  width="100%"
                  height="350"
                  style={{ border: 0 }}
                  allowFullScreen
                  loading="lazy"
                  referrerPolicy="no-referrer-when-downgrade"
                  title="Peta Lokasi Musholla Ar-rahman"
                />
              </div>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
