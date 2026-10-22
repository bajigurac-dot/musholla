import Link from "next/link";
import { notFound } from "next/navigation";
import { getEventBySlug, getEvents } from "@/lib/data";
import { uploadUrl, formatDate } from "@/lib/helper";

interface EventDetailPageProps {
  params: Promise<{ slug: string }>;
}

export async function generateMetadata({ params }: EventDetailPageProps) {
  const { slug } = await params;
  const event = await getEventBySlug(slug);
  if (!event) return { title: "Kegiatan Tidak Ditemukan" };
  return {
    title: event.title,
    description: event.description.slice(0, 160),
  };
}

export default async function EventDetailPage({ params }: EventDetailPageProps) {
  const { slug } = await params;
  const event = await getEventBySlug(slug);
  if (!event) notFound();

  const allEvents = await getEvents(5);
  const otherEvents = allEvents.filter((e) => e.slug !== slug).slice(0, 3);

  const shareText = `Hadiri kegiatan: ${event.title} pada ${formatDate(
    event.event_date
  )} di Musholla Ar-rahman Gembor Periuk`;

  return (
    <>
      {/* Detail Kegiatan Header */}
      <section className="py-5 bg-white border-bottom">
        <div className="container py-3">
          <nav aria-label="breadcrumb">
            <ol className="breadcrumb small">
              <li className="breadcrumb-item">
                <Link href="/" className="text-decoration-none text-muted">
                  Beranda
                </Link>
              </li>
              <li className="breadcrumb-item">
                <Link href="/kegiatan" className="text-decoration-none text-muted">
                  Kegiatan
                </Link>
              </li>
              <li className="breadcrumb-item active text-success fw-bold" aria-current="page">
                {event.title}
              </li>
            </ol>
          </nav>
          <span className="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
            {event.category || "Rutin"}
          </span>
          <h1 className="fw-bold">{event.title}</h1>
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          <div className="row g-4">
            {/* Kolom Konten Utama */}
            <div className="col-lg-8">
              <div className="bg-white border rounded-4 p-4 shadow-sm mb-4">
                <img
                  src={uploadUrl(event.image)}
                  alt={event.title}
                  className="img-fluid rounded-3 mb-4 w-100"
                  style={{ maxHeight: 400, objectFit: "cover" }}
                />

                {/* Info Box Tanggal, Jam, Lokasi */}
                <div className="p-3 bg-light rounded-3 border mb-4">
                  <div className="row g-3">
                    <div className="col-sm-4">
                      <small className="text-muted d-block">
                        <i className="bi bi-calendar-event text-success me-1"></i> Tanggal Pelaksanaan:
                      </small>
                      <strong className="text-dark">{formatDate(event.event_date)}</strong>
                    </div>
                    <div className="col-sm-4">
                      <small className="text-muted d-block">
                        <i className="bi bi-clock text-warning me-1"></i> Waktu / Pukul:
                      </small>
                      <strong className="text-dark">
                        {event.start_time} - {event.end_time} WIB
                      </strong>
                    </div>
                    <div className="col-sm-4">
                      <small className="text-muted d-block">
                        <i className="bi bi-geo-alt text-danger me-1"></i> Tempat / Lokasi:
                      </small>
                      <strong className="text-dark">
                        {event.location || "Musholla Ar-rahman"}
                      </strong>
                    </div>
                  </div>
                </div>

                <h5 className="fw-bold mb-3">Deskripsi Lengkap Kegiatan</h5>
                <div
                  className="leading-relaxed text-muted mb-4"
                  style={{ fontSize: "1.05rem", whiteSpace: "pre-line" }}
                >
                  {event.description}
                </div>

                <div className="d-flex flex-wrap align-items-center justify-content-between border-top pt-3">
                  <span className="small text-muted">
                    Ajak keluarga dan tetangga memakmurkan musholla kita.
                  </span>
                  <a
                    href={`https://api.whatsapp.com/send?text=${encodeURIComponent(shareText)}`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="btn btn-sm btn-success"
                  >
                    <i className="bi bi-whatsapp me-1"></i> Bagikan ke WhatsApp
                  </a>
                </div>
              </div>
            </div>

            {/* Sidebar Kegiatan Lainnya */}
            <div className="col-lg-4">
              <div className="bg-white border rounded-4 p-4 shadow-sm mb-4">
                <h5 className="fw-bold mb-3 border-bottom pb-2">Agenda Terdekat Lainnya</h5>
                {otherEvents.length > 0 ? (
                  <div className="d-flex flex-column gap-3">
                    {otherEvents.map((oe) => (
                      <div key={oe.id} className="d-flex gap-3 align-items-start border-bottom pb-3">
                        <img
                          src={uploadUrl(oe.image)}
                          alt={oe.title}
                          className="rounded-2 object-fit-cover"
                          style={{ width: 70, height: 70 }}
                        />
                        <div>
                          <span className="badge bg-light text-success border small mb-1">
                            {oe.category || "Rutin"}
                          </span>
                          <h6 className="fw-bold fs-6 mb-1">
                            <Link
                              href={`/kegiatan/${oe.slug}`}
                              className="text-decoration-none text-dark"
                            >
                              {oe.title}
                            </Link>
                          </h6>
                          <small className="text-muted d-block">
                            <i className="bi bi-calendar3 me-1"></i> {formatDate(oe.event_date)}
                          </small>
                        </div>
                      </div>
                    ))}
                  </div>
                ) : (
                  <p className="text-muted small m-0">Tidak ada agenda lain.</p>
                )}
              </div>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
