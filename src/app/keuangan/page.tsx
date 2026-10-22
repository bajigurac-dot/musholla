import { getSettings, getFinancialReports, getFinancialSummary } from "@/lib/data";

export const metadata = {
  title: "Laporan Kas & Donasi",
  description:
    "Transparansi kas dan rekening donasi resmi Bank BJB Musholla Ar-rahman Gembor Periuk Tangerang.",
};

export default async function KeuanganPage() {
  const [settings, reports, summary] = await Promise.all([
    getSettings(),
    getFinancialReports(),
    getFinancialSummary(),
  ]);

  const bankName = settings.donation_bank || "Bank BJB";
  const bankAccount = settings.donation_account || "0152632533100";
  const bankHolder = settings.donation_holder || "Musholla Ar-rahman";
  const phone1 = settings.phone_1 || "0813-8619-8079";
  const phone1Clean = phone1.replace(/[^0-9]/g, "").replace(/^0/, "");

  const months: Record<number, string> = {
    1: "Januari",
    2: "Februari",
    3: "Maret",
    4: "April",
    5: "Mei",
    6: "Juni",
    7: "Juli",
    8: "Agustus",
    9: "September",
    10: "Oktober",
    11: "November",
    12: "Desember",
  };

  return (
    <>
      {/* Header Laporan Keuangan */}
      <section className="py-5 bg-white border-bottom">
        <div className="container text-center py-4">
          <span className="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">
            TRANSPARANSI KAS
          </span>
          <h1 className="fw-bold mb-2">Laporan Kas Keuangan Musholla Ar-rahman</h1>
          <p className="text-muted m-0">
            Keterbukaan informasi pengelolaan infaq dan sedekah jamaah secara amanah dan bertanggung jawab
          </p>
        </div>
      </section>

      <section className="py-5">
        <div className="container">
          {/* Ringkasan Saldo Berjalan */}
          <div className="row g-3 mb-4">
            <div className="col-md-4">
              <div className="p-3 bg-white border rounded-4 shadow-sm text-center">
                <small className="text-muted d-block text-uppercase fw-bold" style={{ fontSize: "0.75rem" }}>
                  Total Pemasukan Kas
                </small>
                <h4 className="fw-bold text-success m-0 mt-1">
                  Rp {summary.totalIncome.toLocaleString("id-ID")}
                </h4>
              </div>
            </div>
            <div className="col-md-4">
              <div className="p-3 bg-white border rounded-4 shadow-sm text-center">
                <small className="text-muted d-block text-uppercase fw-bold" style={{ fontSize: "0.75rem" }}>
                  Total Pengeluaran Kas
                </small>
                <h4 className="fw-bold text-danger m-0 mt-1">
                  Rp {summary.totalExpense.toLocaleString("id-ID")}
                </h4>
              </div>
            </div>
            <div className="col-md-4">
              <div
                className="p-3 rounded-4 shadow-sm text-center text-white"
                style={{ background: "linear-gradient(135deg, #075B4A 0%, #053E32 100%)" }}
              >
                <small className="text-white-50 d-block text-uppercase fw-bold" style={{ fontSize: "0.75rem" }}>
                  Saldo Kas Saat Ini
                </small>
                <h4 className="fw-bold text-warning m-0 mt-1">
                  Rp {summary.balance.toLocaleString("id-ID")}
                </h4>
              </div>
            </div>
          </div>

          {/* Tabel Laporan Bulanan */}
          <div className="bg-white border rounded-4 p-4 shadow-sm mb-5">
            <div className="d-flex justify-content-between align-items-center mb-3">
              <h5 className="fw-bold m-0">
                <i className="bi bi-file-earmark-spreadsheet-fill text-success me-2"></i>
                Rekap Laporan Per Periode
              </h5>
              <small className="text-muted">
                <i className="bi bi-check-circle-fill text-success me-1"></i> Disetujui Bendahara DKM
              </small>
            </div>

            {reports.length > 0 ? (
              <div className="table-responsive">
                <table className="table table-hover align-middle mb-0">
                  <thead className="table-light">
                    <tr>
                      <th scope="col" style={{ width: 140 }}>Periode</th>
                      <th scope="col">Pemasukan</th>
                      <th scope="col">Pengeluaran</th>
                      <th scope="col">Saldo Periode</th>
                      <th scope="col">Keterangan / Catatan Alokasi</th>
                    </tr>
                  </thead>
                  <tbody>
                    {reports.map((rep) => {
                      const mName = months[rep.period_month] || rep.period_month;
                      const balance = rep.income - rep.expense;
                      return (
                        <tr key={rep.id}>
                          <td>
                            <span className="badge bg-light text-dark border fw-bold px-2 py-1">
                              {mName} {rep.period_year}
                            </span>
                          </td>
                          <td className="text-success fw-bold">
                            + Rp {rep.income.toLocaleString("id-ID")}
                          </td>
                          <td className="text-danger fw-bold">
                            - Rp {rep.expense.toLocaleString("id-ID")}
                          </td>
                          <td>
                            <strong className={balance >= 0 ? "text-primary" : "text-danger"}>
                              Rp {balance.toLocaleString("id-ID")}
                            </strong>
                          </td>
                          <td className="small text-muted">{rep.description || "-"}</td>
                        </tr>
                      );
                    })}
                  </tbody>
                </table>
              </div>
            ) : (
              <p className="text-muted text-center py-4 m-0">
                Belum ada laporan kas periode yang dipublikasikan.
              </p>
            )}
          </div>

          {/* Bagian Rekening Infaq & Donasi Resmi */}
          <div id="donasi" className="pt-2">
            <div className="row g-4 align-items-center">
              <div className="col-lg-7">
                <div className="donation-card mb-4">
                  <span className="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill mb-3">
                    REKENING RESMI
                  </span>
                  <h3 className="text-white fw-bold mb-3">Transfer Bank Resmi</h3>
                  <p className="text-white-50 mb-4">
                    Salurkan infaq operasional musholla, santunan yatim/dhuafa, atau wakaf sarana tempat ibadah melalui rekening resmi berikut:
                  </p>

                  <div className="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-25 mb-3">
                    <div className="d-flex align-items-center justify-content-between mb-2">
                      <span className="bank-badge">{bankName}</span>
                      <small className="text-white-50">KCP Tangerang</small>
                    </div>
                    <div className="mb-2">
                      <small className="text-white-50 d-block">Nomor Rekening:</small>
                      <span className="account-number">{bankAccount}</span>
                    </div>
                    <div className="d-flex flex-wrap align-items-center justify-content-between gap-2 border-top border-white border-opacity-25 pt-2">
                      <span className="text-white small">
                        Atas Nama: <strong>{bankHolder}</strong>
                      </span>
                    </div>
                  </div>

                  <p className="text-white-50 small m-0">
                    <i className="bi bi-shield-lock-fill text-warning me-1"></i> Pastikan nama pemilik rekening tujuan sesuai sebelum menyelesaikan transaksi transfer.
                  </p>
                </div>
              </div>

              <div className="col-lg-5">
                <div className="bg-white border rounded-4 p-4 shadow-sm">
                  <h5 className="fw-bold text-dark mb-3">
                    <i className="bi bi-chat-dots-fill text-success me-2"></i>Konfirmasi Donasi
                  </h5>
                  <p className="text-muted small leading-relaxed mb-4">
                    Setelah melakukan transfer infaq, mohon konfirmasi ke pengurus DKM agar tercatat rapi dalam pembukuan kas resmi:
                  </p>
                  <a
                    href={`https://wa.me/62${phone1Clean}?text=${encodeURIComponent(
                      "Assalamu'alaikum Pengurus Musholla Ar-rahman, saya bermaksud konfirmasi transfer infaq/donasi..."
                    )}`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="btn btn-success w-100 fw-bold py-2 mb-2"
                  >
                    <i className="bi bi-whatsapp me-2"></i> Konfirmasi via WhatsApp
                  </a>
                  <small className="text-muted text-center d-block">
                    Nomor Layanan: {phone1}
                  </small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
