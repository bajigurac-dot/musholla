import ContactForm from "@/components/ContactForm";
import { getSettings } from "@/lib/data";

export const metadata = {
  title: "Hubungi Pengurus",
  description:
    "Hubungi sekretariat dan pengurus DKM Musholla Ar-rahman RT 007 RW 07 Gembor Periuk Tangerang.",
};

export default async function KontakPage() {
  const settings = await getSettings();

  const musholaName = settings.mushola_name || "Musholla Ar-rahman";
  const address =
    settings.address ||
    "Jl. Anyer RT 007 RW 07, Kelurahan Gembor, Kecamatan Periuk, Kota Tangerang, Banten 15133";
  const phone1 = settings.phone_1 || "0813-8619-8079";
  const phone2 = settings.phone_2 || "0812-9465-6075";
  const email = settings.email || "dkm.musholla.arrahman@gmail.com";
  const mapsEmbed =
    settings.maps_embed ||
    "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15866.505295982056!2d106.577239!3d-6.180424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f8c6543b5935%3A0x6b4847e9545dc6a9!2sGembor%2C%20Periuk%2C%20Tangerang%20City%2C%20Banten!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid";
  const mapsUrl = settings.maps_url || "https://maps.app.goo.gl/JZzSrDEKjCseGwgw7?g_st=aw";

  const phone1Clean = phone1.replace(/[^0-9]/g, "").replace(/^0/, "");
  const phone2Clean = phone2.replace(/[^0-9]/g, "").replace(/^0/, "");

  return (
    <>
      {/* Header Kontak */}
      <section className="py-5 bg-white border-bottom">
        <div className="container text-center py-4">
          <span className="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
            SILATURAHMI
          </span>
          <h1 className="fw-bold mb-2">Hubungi Pengurus {musholaName}</h1>
          <p className="text-muted m-0">
            Kami menyambut baik setiap pertanyaan, saran, maupun permohonan koordinasi ibadah warga
          </p>
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          <div className="row g-4">
            {/* Kolom Informasi Kontak & Pengurus */}
            <div className="col-lg-5">
              <div className="bg-white border rounded-4 p-4 shadow-sm mb-4">
                <h5 className="fw-bold mb-3 border-bottom pb-2">
                  Informasi Kontak & Sekretariat
                </h5>

                <div className="d-flex align-items-start gap-3 mb-3">
                  <div className="p-2 bg-success text-white rounded-3">
                    <i className="bi bi-geo-alt-fill fs-5"></i>
                  </div>
                  <div>
                    <strong className="d-block text-dark">Alamat Musholla:</strong>
                    <p className="text-muted small m-0 leading-relaxed">{address}</p>
                  </div>
                </div>

                <div className="d-flex align-items-start gap-3 mb-3">
                  <div className="p-2 bg-success text-white rounded-3">
                    <i className="bi bi-whatsapp fs-5"></i>
                  </div>
                  <div>
                    <strong className="d-block text-dark">WhatsApp Pengurus DKM:</strong>
                    <div className="d-flex flex-column gap-1 mt-1">
                      <a
                        href={`https://wa.me/62${phone1Clean}`}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="text-success small fw-bold text-decoration-none"
                      >
                        <i className="bi bi-chat-dots-fill me-1"></i> Kontak 1: {phone1}
                      </a>
                      <a
                        href={`https://wa.me/62${phone2Clean}`}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="text-success small fw-bold text-decoration-none"
                      >
                        <i className="bi bi-chat-dots-fill me-1"></i> Kontak 2: {phone2}
                      </a>
                    </div>
                  </div>
                </div>

                <div className="d-flex align-items-start gap-3 mb-3">
                  <div className="p-2 bg-success text-white rounded-3">
                    <i className="bi bi-envelope-fill fs-5"></i>
                  </div>
                  <div>
                    <strong className="d-block text-dark">Surat Elektronik (Email):</strong>
                    <a
                      href={`mailto:${email}`}
                      className="text-success small fw-bold text-decoration-none"
                    >
                      {email}
                    </a>
                  </div>
                </div>

                <div className="border-top pt-3">
                  <a
                    href={mapsUrl}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="btn btn-outline-success w-100 fw-bold btn-sm"
                  >
                    <i className="bi bi-pin-map-fill me-1"></i> Buka Petunjuk Arah di Google Maps
                  </a>
                </div>
              </div>

              {/* Peta Lokasi */}
              <div className="bg-white border rounded-4 p-2 shadow-sm overflow-hidden">
                <iframe
                  src={mapsEmbed}
                  width="100%"
                  height="260"
                  style={{ border: 0, borderRadius: 12 }}
                  allowFullScreen
                  loading="lazy"
                  referrerPolicy="no-referrer-when-downgrade"
                  title="Peta Lokasi Musholla"
                />
              </div>
            </div>

            {/* Kolom Formulir Pesan */}
            <div className="col-lg-7">
              <div className="bg-white border rounded-4 p-4 p-md-5 shadow-sm">
                <h5 className="fw-bold mb-2">Kirim Pesan / Aspirasi Jamaah</h5>
                <p className="text-muted small mb-4">
                  Sampaikan kritik, saran pembangunan, atau permohonan informasi kepada pengurus DKM.
                </p>
                <ContactForm />
              </div>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
