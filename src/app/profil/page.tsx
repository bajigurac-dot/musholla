import { getSettings } from "@/lib/data";
import { uploadUrl } from "@/lib/helper";

export const metadata = {
  title: "Profil & Sejarah",
  description: "Sejarah berdirinya Musholla Ar-rahman Gembor Periuk sejak tahun 1990, visi, misi, dan susunan pengurus DKM.",
};

function formatPersonName(name: string) {
  if (!name) return "";
  return name
    .split(" ")
    .map((part) => {
      if (part.includes(".")) return part.toUpperCase();
      return part.charAt(0).toUpperCase() + part.slice(1).toLowerCase();
    })
    .join(" ");
}

export default async function ProfilPage() {
  const settings = await getSettings();

  const facilitiesList = settings.facilities
    ? settings.facilities.split(",").map((f) => f.trim())
    : [];

  return (
    <>
      {/* Page Header */}
      <section className="py-5 bg-white border-bottom">
        <div className="container text-center py-4">
          <span className="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
            PROFIL RESMI
          </span>
          <h1 className="fw-bold mb-2">Profil & Sejarah {settings.mushola_name}</h1>
          <p className="text-muted m-0">
            Menelusuri jejak perjuangan gotong royong warga sejak tahun 1990 di Gembor, Periuk Tangerang
          </p>
        </div>
      </section>

      {/* Konten Profil Utama */}
      <section className="py-5">
        <div className="container">
          {/* Bagian Sejarah */}
          <div className="row g-4 align-items-center mb-5">
            <div className="col-lg-6">
              <span className="text-success fw-bold text-uppercase small">SEJARAH BERDIRINYA</span>
              <h2 className="fw-bold mb-3">Gotong Royong Sejak Tahun 1990</h2>
              <div className="p-4 bg-white border rounded-4 shadow-sm mb-3">
                <p className="text-muted leading-relaxed m-0" style={{ fontSize: "1.05rem" }}>
                  <i className="bi bi-quote fs-2 text-success me-1"></i>
                  {settings.history}
                </p>
              </div>
              <p className="text-muted small">
                Melalui keteladanan para sesepuh dan tokoh masyarakat terdahulu, Musholla Ar-rahman hingga saat ini terus dirawat dan dimakmurkan oleh generasi penerus warga RT 007 RW 07 Kelurahan Gembor Periuk Tangerang secara istiqomah.
              </p>
            </div>
            <div className="col-lg-6">
              <div className="position-relative">
                <img
                  src={uploadUrl("foto-kegiatan-8.jpeg")}
                  alt="Bangunan Musholla Ar-rahman"
                  className="img-fluid rounded-4 shadow-md w-100 object-fit-cover"
                  style={{ minHeight: 340, maxHeight: 420 }}
                />
                <div className="position-absolute top-0 end-0 m-3 badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill shadow-sm">
                  <i className="bi bi-award-fill me-1"></i> Didirikan Tahun 1990
                </div>
              </div>
            </div>
          </div>

          {/* Visi dan Misi */}
          <div className="row g-4 mb-5">
            <div className="col-md-6">
              <div className="p-4 bg-white border rounded-4 shadow-sm h-100">
                <div className="d-flex align-items-center gap-2 mb-3">
                  <div className="p-2 bg-success text-white rounded-3">
                    <i className="bi bi-compass-fill fs-5"></i>
                  </div>
                  <h4 className="fw-bold m-0 text-success">Visi Musholla</h4>
                </div>
                <p className="text-muted leading-relaxed" style={{ fontSize: "1.02rem" }}>
                  &ldquo;{settings.vision}&rdquo;
                </p>
              </div>
            </div>

            <div className="col-md-6">
              <div className="p-4 bg-white border rounded-4 shadow-sm h-100">
                <div className="d-flex align-items-center gap-2 mb-3">
                  <div className="p-2 bg-warning text-dark rounded-3">
                    <i className="bi bi-card-checklist fs-5"></i>
                  </div>
                  <h4 className="fw-bold m-0 text-dark">Misi Musholla</h4>
                </div>
                <div className="text-muted small leading-relaxed whitespace-pre-line">
                  {settings.mission}
                </div>
              </div>
            </div>
          </div>

          {/* Susunan Pengurus DKM */}
          <div className="mb-5">
            <div className="text-center mb-4">
              <span className="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
                AMANAH KEPENGURUSAN
              </span>
              <h2 className="fw-bold m-0">Susunan Pengurus DKM Ar-rahman</h2>
              <p className="text-muted small">Melayani umat dengan keikhlasan, amanah, dan transparansi</p>
            </div>

            <div className="row g-4 justify-content-center">
              {/* Ketua DKM */}
              <div className="col-md-4">
                <div className="p-4 bg-white border rounded-4 shadow-sm text-center h-100 d-flex flex-column align-items-center">
                  <div
                    className="rounded-circle shadow-sm border border-success border-3 mb-3 mx-auto overflow-hidden bg-white position-relative"
                    style={{ width: 110, height: 110, minWidth: 110, minHeight: 110, maxWidth: 110, maxHeight: 110 }}
                  >
                    <img
                      src={uploadUrl("ketua-dkm-ustadz-tata.jpeg")}
                      alt={settings.dkm_lead}
                      className="w-100 h-100 object-fit-cover"
                      style={{ width: 110, height: 110, objectFit: "cover" }}
                    />
                  </div>
                  <h5 className="fw-bold mb-1" style={{ fontSize: "1.15rem", color: "#1E293B" }}>
                    {formatPersonName(settings.dkm_lead)}
                  </h5>
                  <span className="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill mb-3 fw-semibold">
                    Ketua DKM
                  </span>
                  <p className="text-muted small m-0 mt-auto pt-2" style={{ lineHeight: 1.6 }}>
                    Penanggung jawab umum kegiatan dakwah, kajian, dan peribadatan warga
                  </p>
                </div>
              </div>

              {/* Bendahara DKM */}
              <div className="col-md-4">
                <div className="p-4 bg-white border rounded-4 shadow-sm text-center h-100 d-flex flex-column align-items-center">
                  <div
                    className="rounded-circle shadow-sm border border-success border-3 mb-3 mx-auto overflow-hidden bg-white position-relative"
                    style={{ width: 110, height: 110, minWidth: 110, minHeight: 110, maxWidth: 110, maxHeight: 110 }}
                  >
                    <img
                      src="/assets/images/avatar-bendahara.svg"
                      alt={settings.dkm_treasurer}
                      className="w-100 h-100 object-fit-cover"
                      style={{ width: 110, height: 110, objectFit: "cover" }}
                    />
                  </div>
                  <h5 className="fw-bold mb-1" style={{ fontSize: "1.15rem", color: "#1E293B" }}>
                    {formatPersonName(settings.dkm_treasurer)}
                  </h5>
                  <span className="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1 rounded-pill mb-3 fw-semibold">
                    Bendahara DKM
                  </span>
                  <p className="text-muted small m-0 mt-auto pt-2" style={{ lineHeight: 1.6 }}>
                    Amanah pencatatan kas, transparansi infaq Jumat, dan pelaporan keuangan donatur
                  </p>
                </div>
              </div>

              {/* Sekretaris DKM */}
              <div className="col-md-4">
                <div className="p-4 bg-white border rounded-4 shadow-sm text-center h-100 d-flex flex-column align-items-center">
                  <div
                    className="rounded-circle shadow-sm border border-success border-3 mb-3 mx-auto overflow-hidden bg-white position-relative"
                    style={{ width: 110, height: 110, minWidth: 110, minHeight: 110, maxWidth: 110, maxHeight: 110 }}
                  >
                    <img
                      src="/assets/images/avatar-sekretaris.svg"
                      alt={settings.dkm_secretary}
                      className="w-100 h-100 object-fit-cover"
                      style={{ width: 110, height: 110, objectFit: "cover" }}
                    />
                  </div>
                  <h5 className="fw-bold mb-1" style={{ fontSize: "1.15rem", color: "#1E293B" }}>
                    {formatPersonName(settings.dkm_secretary)}
                  </h5>
                  <span className="badge bg-primary-subtle text-primary-emphasis border border-primary-subtle px-3 py-1 rounded-pill mb-3 fw-semibold">
                    Sekretaris DKM
                  </span>
                  <p className="text-muted small m-0 mt-auto pt-2" style={{ lineHeight: 1.6 }}>
                    Administrasi surat-menyurat, arsip dokumentasi, dan hubungan komunikasi jamaah
                  </p>
                </div>
              </div>
            </div>
          </div>

          {/* Fasilitas Musholla */}
          <div>
            <div className="text-center mb-4">
              <span className="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
                SARANA IBADAH
              </span>
              <h2 className="fw-bold m-0">Fasilitas Jamaah</h2>
              <p className="text-muted small">Menjaga kebersihan dan kenyamanan tempat ibadah</p>
            </div>

            <div className="row g-3">
              {facilitiesList.map((f, i) => (
                <div key={i} className="col-md-6 col-lg-3">
                  <div className="p-3 bg-white border rounded-3 h-100 d-flex align-items-center gap-3 shadow-xs">
                    <div className="p-2 bg-success-subtle text-success rounded-circle">
                      <i className="bi bi-check2-circle fs-5"></i>
                    </div>
                    <span className="small fw-semibold text-dark">{f}</span>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
