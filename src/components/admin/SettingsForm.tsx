"use client";

import { useState } from "react";
import { Save, CheckCircle2, AlertCircle } from "lucide-react";
import { SettingsMap } from "@/types";

interface SettingsFormProps {
  initialSettings: SettingsMap;
}

export default function SettingsForm({ initialSettings }: SettingsFormProps) {
  const [formData, setFormData] = useState<SettingsMap>(initialSettings);
  const [loading, setLoading] = useState(false);
  const [status, setStatus] = useState<"idle" | "success" | "error">("idle");
  const [msg, setMsg] = useState("");

  const handleChange = (key: string, value: string) => {
    setFormData((prev) => ({ ...prev, [key]: value }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setStatus("idle");
    setMsg("");

    try {
      const res = await fetch("/api/admin/settings", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData),
      });

      if (res.ok) {
        setStatus("success");
        setMsg("Pengaturan identitas musholla berhasil disimpan!");
      } else {
        const err = await res.json();
        setStatus("error");
        setMsg(err.message || "Gagal menyimpan.");
      }
    } catch {
      setStatus("error");
      setMsg("Terjadi gangguan koneksi.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-6">
      {status === "success" && (
        <div className="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-2">
          <CheckCircle2 className="w-5 h-5 text-emerald-600 shrink-0" />
          <span>{msg}</span>
        </div>
      )}

      {status === "error" && (
        <div className="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm flex items-center gap-2">
          <AlertCircle className="w-5 h-5 text-red-600 shrink-0" />
          <span>{msg}</span>
        </div>
      )}

      {/* Bagian 1: Identitas Musholla */}
      <div className="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-4">
        <h2 className="text-base font-bold text-gray-900 border-b border-gray-100 pb-3">
          Identitas & Informasi Musholla
        </h2>

        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label className="block text-xs font-semibold text-gray-700 mb-1">
              Nama Musholla
            </label>
            <input
              type="text"
              value={formData.mushola_name || ""}
              onChange={(e) => handleChange("mushola_name", e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
            />
          </div>

          <div>
            <label className="block text-xs font-semibold text-gray-700 mb-1">
              Email Resmi DKM
            </label>
            <input
              type="email"
              value={formData.email || "dkm.musholla.arrahman@gmail.com"}
              onChange={(e) => handleChange("email", e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm font-medium"
            />
          </div>

          <div className="sm:col-span-2">
            <label className="block text-xs font-semibold text-gray-700 mb-1">
              Tagline / Slogan
            </label>
            <input
              type="text"
              value={formData.tagline || ""}
              onChange={(e) => handleChange("tagline", e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
            />
          </div>

          <div className="sm:col-span-2">
            <label className="block text-xs font-semibold text-gray-700 mb-1">
              Alamat Lengkap
            </label>
            <input
              type="text"
              value={formData.address || ""}
              onChange={(e) => handleChange("address", e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
            />
          </div>

          <div>
            <label className="block text-xs font-semibold text-gray-700 mb-1">
              WhatsApp Pengurus 1
            </label>
            <input
              type="text"
              value={formData.phone_1 || ""}
              onChange={(e) => handleChange("phone_1", e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
            />
          </div>

          <div>
            <label className="block text-xs font-semibold text-gray-700 mb-1">
              WhatsApp Pengurus 2
            </label>
            <input
              type="text"
              value={formData.phone_2 || ""}
              onChange={(e) => handleChange("phone_2", e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
            />
          </div>
        </div>
      </div>

      {/* Bagian 2: Susunan Pengurus DKM */}
      <div className="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-4">
        <h2 className="text-base font-bold text-gray-900 border-b border-gray-100 pb-3">
          Susunan Pengurus DKM
        </h2>

        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div>
            <label className="block text-xs font-semibold text-gray-700 mb-1">
              Ketua DKM
            </label>
            <input
              type="text"
              value={formData.dkm_lead || ""}
              onChange={(e) => handleChange("dkm_lead", e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
            />
          </div>

          <div>
            <label className="block text-xs font-semibold text-gray-700 mb-1">
              Bendahara DKM
            </label>
            <input
              type="text"
              value={formData.dkm_treasurer || ""}
              onChange={(e) => handleChange("dkm_treasurer", e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
            />
          </div>

          <div>
            <label className="block text-xs font-semibold text-gray-700 mb-1">
              Sekretaris DKM
            </label>
            <input
              type="text"
              value={formData.dkm_secretary || ""}
              onChange={(e) => handleChange("dkm_secretary", e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
            />
          </div>
        </div>
      </div>

      {/* Bagian 3: Rekening Donasi Bank BJB */}
      <div className="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-4">
        <h2 className="text-base font-bold text-gray-900 border-b border-gray-100 pb-3">
          Rekening Resmi Donasi / Infaq
        </h2>

        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div>
            <label className="block text-xs font-semibold text-gray-700 mb-1">
              Nama Bank
            </label>
            <input
              type="text"
              value={formData.donation_bank || ""}
              onChange={(e) => handleChange("donation_bank", e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
            />
          </div>

          <div>
            <label className="block text-xs font-semibold text-gray-700 mb-1">
              Nomor Rekening
            </label>
            <input
              type="text"
              value={formData.donation_account || ""}
              onChange={(e) => handleChange("donation_account", e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm font-mono font-bold"
            />
          </div>

          <div>
            <label className="block text-xs font-semibold text-gray-700 mb-1">
              Atas Nama Rekening
            </label>
            <input
              type="text"
              value={formData.donation_holder || ""}
              onChange={(e) => handleChange("donation_holder", e.target.value)}
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
            />
          </div>
        </div>
      </div>

      {/* Bagian 4: Sejarah, Visi, Misi, Fasilitas */}
      <div className="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-4">
        <h2 className="text-base font-bold text-gray-900 border-b border-gray-100 pb-3">
          Sejarah, Visi, Misi & Fasilitas
        </h2>

        <div>
          <label className="block text-xs font-semibold text-gray-700 mb-1">
            Sejarah Berdirinya Musholla (Tahun 1990)
          </label>
          <textarea
            rows={3}
            value={formData.history || ""}
            onChange={(e) => handleChange("history", e.target.value)}
            className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
          />
        </div>

        <div>
          <label className="block text-xs font-semibold text-gray-700 mb-1">
            Visi Musholla
          </label>
          <input
            type="text"
            value={formData.vision || ""}
            onChange={(e) => handleChange("vision", e.target.value)}
            className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
          />
        </div>

        <div>
          <label className="block text-xs font-semibold text-gray-700 mb-1">
            Misi Musholla (Pisahkan dengan baris baru)
          </label>
          <textarea
            rows={4}
            value={formData.mission || ""}
            onChange={(e) => handleChange("mission", e.target.value)}
            className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
          />
        </div>

        <div>
          <label className="block text-xs font-semibold text-gray-700 mb-1">
            Daftar Fasilitas (Pisahkan dengan tanda koma)
          </label>
          <input
            type="text"
            value={formData.facilities || ""}
            onChange={(e) => handleChange("facilities", e.target.value)}
            className="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 text-sm"
          />
        </div>
      </div>

      {/* Tombol Simpan */}
      <div className="flex justify-end">
        <button
          type="submit"
          disabled={loading}
          className="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md flex items-center gap-2 transition-all disabled:opacity-50"
        >
          <Save className="w-4 h-4" />
          <span>{loading ? "Menyimpan..." : "Simpan Perubahan Pengaturan"}</span>
        </button>
      </div>
    </form>
  );
}
