import Link from "next/link";
import { getEvents } from "@/lib/data";
import { uploadUrl, limitWords, formatDate } from "@/lib/helper";

export const metadata = {
  title: "Agenda Kegiatan",
  description:
    "Jadwal sholat berjamaah, yasinan malam Jum'at, dan pengajian rutin bulanan warga Musholla Ar-rahman.",
};

export default async function KegiatanPage({
  searchParams,
}: {
  searchParams: Promise<{ tab?: string }>;
}) {
  const resolvedSearchParams = await searchParams;
  const tab = resolvedSearchParams.tab || "upcoming";
  const allEvents = await getEvents();

  // Filter based on tab: upcoming vs past
  const events = allEvents.filter((evt) => {
    if (tab === "past") {
      return evt.status === "Selesai";
    }
    return evt.status !== "Selesai";
  });

  return (
    <>
      {/* Header Halaman Kegiatan */}
      <section className="py-5 bg-white border-bottom">
        <div className="container text-center py-4">
          <span className="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
            SYIAR & IBADAH
          </span>
          <h1 className="fw-bold mb-2">Agenda Kegiatan Musholla Ar-rahman</h1>
          <p className="text-muted m-0">
            Jadwal sholat berjamaah, yasinan malam Jum&apos;at, dan pengajian rutin bulanan warga
          </p>
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          {/* Tab Filter: Mendatang vs Selesai */}
          <div className="d-flex justify-content-center mb-4">
            <div className="btn-group p-1 bg-white border rounded-pill shadow-sm" role="group">
              <Link
                href="/kegiatan?tab=upcoming"
                className={`btn rounded-pill px-4 fw-bold ${
                  tab === "upcoming" ? "btn-success text-white" : "btn-light text-muted"
                }`}
              >
                <i className="bi bi-calendar-event me-1"></i> Kegiatan Mendatang
              </Link>
              <Link
                href="/kegiatan?tab=past"
                className={`btn rounded-pill px-4 fw-bold ${
                  tab === "past" ? "btn-success text-white" : "btn-light text-muted"
                }`}
              >
                <i className="bi bi-archive me-1"></i> Arsip Kegiatan Lampau
              </Link>
            </div>
          </div>

          {events.length > 0 ? (
            <div className="row g-4">
              {events.map((evt) => (
                <div key={evt.id} className="col-md-6 col-lg-4">
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
                        <span
                          className={`badge ${
                            evt.status === "Mendatang" ? "bg-success" : "bg-secondary"
                          }`}
                        >
                          {evt.status}
                        </span>
                      </div>
                      <h5 className="fw-bold fs-6 mb-2">
                        <Link href={`/kegiatan/${evt.slug}`} className="text-decoration-none text-dark">
                          {evt.title}
                        </Link>
                      </h5>
                      <div className="small text-muted mb-2">
                        <div className="d-flex align-items-center gap-1 mb-1">
                          <i className="bi bi-calendar3 text-success"></i>
                          <span>{formatDate(evt.event_date)}</span>
                        </div>
                        <div className="d-flex align-items-center gap-1 mb-1">
                          <i className="bi bi-clock text-warning"></i>
                          <span>
                            Pukul {evt.start_time} - {evt.end_time} WIB
                          </span>
                        </div>
                        <div className="d-flex align-items-center gap-1">
                          <i className="bi bi-geo-alt text-danger"></i>
                          <span>{evt.location || "Musholla Ar-rahman"}</span>
                        </div>
                      </div>
                      <p className="text-muted small mb-3 flex-grow-1">
                        {limitWords(evt.description, 18)}
                      </p>
                      <div className="border-top pt-2 text-end">
                        <Link
                          href={`/kegiatan/${evt.slug}`}
                          className="btn btn-sm btn-outline-success fw-bold"
                        >
                          Lihat Rincian <i className="bi bi-arrow-right"></i>
                        </Link>
                      </div>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <div className="alert alert-light border text-center p-5 rounded-4 shadow-sm">
              <i className="bi bi-calendar-x fs-1 text-muted d-block mb-2"></i>
              <h5 className="fw-bold text-muted">Belum ada kegiatan pada daftar ini</h5>
              <p className="text-muted small m-0">
                Silakan periksa kembali pada kategori tab lainnya.
              </p>
            </div>
          )}
        </div>
      </section>
    </>
  );
}
