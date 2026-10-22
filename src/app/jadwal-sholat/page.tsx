import { getPrayerTimes } from "@/lib/prayer";

export const metadata = {
  title: "Jadwal Sholat Tangerang",
  description:
    "Jadwal sholat lima waktu akurat untuk wilayah Kota Tangerang, Gembor, Periuk dan sekitarnya.",
};

export default async function JadwalSholatPage() {
  const times = await getPrayerTimes();

  const scheduleList = [
    { name: "Imsak", time: times.imsak, desc: "Batas akhir santap sahur" },
    { name: "Subuh", time: times.subuh, desc: "Awal waktu sholat shubuh" },
    { name: "Terbit", time: times.terbit, desc: "Matahari terbit (syuruq)" },
    { name: "Dzuhur", time: times.dzuhur, desc: "Tergelincirnya matahari" },
    { name: "Ashar", time: times.ashar, desc: "Bayangan sama panjang" },
    { name: "Maghrib", time: times.maghrib, desc: "Terbenamnya matahari" },
    { name: "Isya", time: times.isya, desc: "Hilangnya mega merah" },
  ];

  return (
    <>
      <section className="py-5 bg-white border-bottom">
        <div className="container text-center py-4">
          <span className="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
            WAKTU IBADAH ISTIQOMAH
          </span>
          <h1 className="fw-bold mb-2">Jadwal Sholat Wilayah Kota Tangerang</h1>
          <p className="text-muted m-0">
            Jadwal resmi hisab rukyat Kementerian Agama RI untuk wilayah Kelurahan Gembor,
            Kecamatan Periuk, Kota Tangerang dan sekitarnya.
          </p>
        </div>
      </section>

      <section className="py-5">
        <div className="container" style={{ maxWidth: 960 }}>
          <div className="bg-white border rounded-4 p-4 p-md-5 shadow-sm">
            <div className="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 pb-4 mb-4 border-bottom">
              <div className="d-flex align-items-center gap-2 text-success fw-bold">
                <i className="bi bi-geo-alt-fill fs-5 text-danger"></i>
                <span>Kota Tangerang (WIB / UTC+7)</span>
              </div>
              <div className="text-muted small">
                <i className="bi bi-calendar-event me-1"></i>
                <span>{times.hijri}</span>
              </div>
            </div>

            <div className="row g-3">
              {scheduleList.map((item) => (
                <div key={item.name} className="col-6 col-md-4 col-lg-3">
                  <div className="p-3 rounded-3 border bg-light text-center h-100">
                    <span className="badge bg-success-subtle text-success fw-bold px-2 py-1 mb-2">
                      {item.name}
                    </span>
                    <div className="fs-3 fw-bold text-dark font-monospace mb-1">
                      {item.time}
                    </div>
                    <small className="text-muted d-block" style={{ fontSize: "0.75rem" }}>
                      {item.desc}
                    </small>
                  </div>
                </div>
              ))}
            </div>

            <div className="mt-4 p-3 bg-light rounded-3 border small text-muted">
              <i className="bi bi-info-circle-fill text-success me-1"></i>
              <strong>Catatan:</strong> Waktu sholat diperbarui secara otomatis setiap hari berdasarkan koordinat lintang/bujur Kota Tangerang menggunakan standar Kementerian Agama RI.
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
