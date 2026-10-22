"use client";

import { useState } from "react";

export default function ContactForm() {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    phone: "",
    subject: "",
    message: "",
  });
  const [loading, setLoading] = useState(false);
  const [status, setStatus] = useState<"idle" | "success" | "error">("idle");
  const [errorMsg, setErrorMsg] = useState("");

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setStatus("idle");
    setErrorMsg("");

    try {
      const res = await fetch("/api/contact", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData),
      });

      if (res.ok) {
        setStatus("success");
        setFormData({ name: "", email: "", phone: "", subject: "", message: "" });
      } else {
        const err = await res.json();
        setErrorMsg(err.message || "Gagal mengirim pesan. Silakan coba lagi.");
        setStatus("error");
      }
    } catch {
      setErrorMsg("Terjadi gangguan koneksi. Silakan hubungi langsung via WhatsApp.");
      setStatus("error");
    } finally {
      setLoading(false);
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      {status === "success" && (
        <div className="alert alert-success d-flex align-items-center gap-2 mb-3">
          <i className="bi bi-check-circle-fill fs-5"></i>
          <div>Alhamdulillah, pesan Anda telah terkirim kepada pengurus DKM Ar-rahman.</div>
        </div>
      )}

      {status === "error" && (
        <div className="alert alert-danger d-flex align-items-center gap-2 mb-3">
          <i className="bi bi-exclamation-triangle-fill fs-5"></i>
          <div>{errorMsg}</div>
        </div>
      )}

      <div className="mb-3">
        <label className="form-label small fw-bold text-dark">
          Nama Lengkap <span className="text-danger">*</span>
        </label>
        <input
          type="text"
          required
          value={formData.name}
          onChange={(e) => setFormData({ ...formData, name: e.target.value })}
          placeholder="Contoh: Ahmad Fauzi"
          className="form-control"
        />
      </div>

      <div className="row g-3 mb-3">
        <div className="col-sm-6">
          <label className="form-label small fw-bold text-dark">
            Nomor WhatsApp / HP <span className="text-danger">*</span>
          </label>
          <input
            type="tel"
            required
            value={formData.phone}
            onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
            placeholder="0812xxxxxxxx"
            className="form-control"
          />
        </div>
        <div className="col-sm-6">
          <label className="form-label small fw-bold text-dark">
            Alamat Email (Opsional)
          </label>
          <input
            type="email"
            value={formData.email}
            onChange={(e) => setFormData({ ...formData, email: e.target.value })}
            placeholder="nama@email.com"
            className="form-control"
          />
        </div>
      </div>

      <div className="mb-3">
        <label className="form-label small fw-bold text-dark">
          Topik / Keperluan <span className="text-danger">*</span>
        </label>
        <input
          type="text"
          required
          value={formData.subject}
          onChange={(e) => setFormData({ ...formData, subject: e.target.value })}
          placeholder="Contoh: Permohonan Izin Pengajian / Saran Fasilitas"
          className="form-control"
        />
      </div>

      <div className="mb-3">
        <label className="form-label small fw-bold text-dark">
          Isi Pesan / Saran <span className="text-danger">*</span>
        </label>
        <textarea
          required
          rows={4}
          value={formData.message}
          onChange={(e) => setFormData({ ...formData, message: e.target.value })}
          placeholder="Tuliskan pesan, usulan, atau pertanyaan Anda..."
          className="form-control"
        />
      </div>

      <button
        type="submit"
        disabled={loading}
        className="btn btn-success w-100 fw-bold py-2 shadow-sm d-flex align-items-center justify-content-center gap-2"
      >
        <i className="bi bi-send-fill"></i>
        <span>{loading ? "Mengirim Pesan..." : "Kirim Pesan ke Pengurus"}</span>
      </button>
    </form>
  );
}
