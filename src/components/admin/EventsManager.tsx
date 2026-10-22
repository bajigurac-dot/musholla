"use client";

import { useState } from "react";
import { Plus, Trash2, X, CheckCircle2 } from "lucide-react";
import { EventItem } from "@/types";

interface EventsManagerProps {
  initialEvents: EventItem[];
}

export default function EventsManager({ initialEvents }: EventsManagerProps) {
  const [events, setEvents] = useState<EventItem[]>(initialEvents);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [loading, setLoading] = useState(false);
  const [msg, setMsg] = useState("");
  const [newEvent, setNewEvent] = useState({
    title: "",
    event_date: "2026-10-19",
    start_time: "18:30",
    end_time: "20:00",
    location: "Musholla Ar-rahman",
    category: "Rutin",
    description: "",
    status: "Mendatang",
  });

  const handleDelete = async (id: number) => {
    if (!confirm("Hapus agenda kegiatan ini?")) return;
    try {
      const res = await fetch(`/api/admin/events?id=${id}`, { method: "DELETE" });
      if (res.ok) {
        setEvents((prev) => prev.filter((e) => e.id !== id));
      } else {
        alert("Gagal menghapus.");
      }
    } catch {
      alert("Terjadi kesalahan.");
    }
  };

  const handleCreate = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    try {
      const res = await fetch("/api/admin/events", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(newEvent),
      });

      if (res.ok) {
        setMsg("Agenda kegiatan berhasil ditambahkan!");
        setIsModalOpen(false);
        setNewEvent({
          title: "",
          event_date: new Date().toISOString().substring(0, 10),
          start_time: "18:30",
          end_time: "20:00",
          location: "Musholla Ar-rahman",
          category: "Rutin",
          description: "",
          status: "Mendatang",
        });
        const updated = await fetch("/api/admin/events").then((r) => r.json());
        setEvents(updated);
      } else {
        alert("Gagal menambahkan kegiatan.");
      }
    } catch {
      alert("Terjadi kesalahan.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="space-y-6">
      {msg && (
        <div className="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
          <CheckCircle2 className="w-5 h-5 text-emerald-600" />
          <span>{msg}</span>
        </div>
      )}

      {/* Header */}
      <div className="flex items-center justify-between">
        <h2 className="text-xl font-bold text-gray-900">
          Agenda Kegiatan & Pengajian ({events.length})
        </h2>
        <button
          onClick={() => setIsModalOpen(true)}
          className="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm shadow-md flex items-center gap-1.5 transition-colors"
        >
          <Plus className="w-4 h-4" />
          <span>Tambah Kegiatan Baru</span>
        </button>
      </div>

      {/* Table */}
      <div className="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-left text-sm">
            <thead className="bg-gray-50 border-b border-gray-100 text-gray-500 text-xs uppercase font-semibold">
              <tr>
                <th className="py-4 px-6">Nama Kegiatan</th>
                <th className="py-4 px-6">Tanggal & Jam</th>
                <th className="py-4 px-6">Lokasi</th>
                <th className="py-4 px-6">Kategori</th>
                <th className="py-4 px-6 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-100">
              {events.map((evt) => (
                <tr key={evt.id} className="hover:bg-gray-50/50 transition-colors">
                  <td className="py-4 px-6 font-semibold text-gray-900">
                    <div>{evt.title}</div>
                    <div className="text-xs text-gray-400 font-normal line-clamp-1 mt-0.5">
                      {evt.description}
                    </div>
                  </td>
                  <td className="py-4 px-6 text-xs text-gray-600">
                    <span className="font-bold text-gray-900 block">{evt.event_date}</span>
                    <span className="text-gray-400 font-mono">
                      {evt.start_time} - {evt.end_time}
                    </span>
                  </td>
                  <td className="py-4 px-6 text-xs text-gray-600">{evt.location}</td>
                  <td className="py-4 px-6">
                    <span className="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                      {evt.category}
                    </span>
                  </td>
                  <td className="py-4 px-6 text-right">
                    <button
                      onClick={() => handleDelete(evt.id)}
                      className="p-1.5 rounded-lg text-red-500 hover:text-red-700 hover:bg-red-50 transition-colors"
                      title="Hapus Kegiatan"
                    >
                      <Trash2 className="w-4 h-4" />
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      {/* Modal Tambah Kegiatan */}
      {isModalOpen && (
        <div className="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-gray-100">
              <h3 className="text-lg font-bold text-gray-900">Tambah Agenda Kegiatan Baru</h3>
              <button
                onClick={() => setIsModalOpen(false)}
                className="p-1 rounded-lg text-gray-400 hover:text-gray-600"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            <form onSubmit={handleCreate} className="space-y-4">
              <div>
                <label className="block text-xs font-semibold text-gray-700 mb-1">
                  Nama Kegiatan / Pengajian <span className="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  required
                  value={newEvent.title}
                  onChange={(e) => setNewEvent({ ...newEvent, title: e.target.value })}
                  placeholder="Contoh: Pengajian Rutin Malam Jumat & Pembacaan Yasin"
                  className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500"
                />
              </div>

              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-xs font-semibold text-gray-700 mb-1">
                    Tanggal Kegiatan <span className="text-red-500">*</span>
                  </label>
                  <input
                    type="date"
                    required
                    value={newEvent.event_date}
                    onChange={(e) => setNewEvent({ ...newEvent, event_date: e.target.value })}
                    className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500"
                  />
                </div>
                <div>
                  <label className="block text-xs font-semibold text-gray-700 mb-1">Kategori</label>
                  <select
                    value={newEvent.category}
                    onChange={(e) => setNewEvent({ ...newEvent, category: e.target.value })}
                    className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500"
                  >
                    <option value="Rutin">Rutin</option>
                    <option value="Hari Besar">Hari Besar</option>
                    <option value="Kajian">Kajian</option>
                    <option value="Sosial">Sosial</option>
                  </select>
                </div>
              </div>

              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-xs font-semibold text-gray-700 mb-1">
                    Jam Mulai
                  </label>
                  <input
                    type="text"
                    value={newEvent.start_time}
                    onChange={(e) => setNewEvent({ ...newEvent, start_time: e.target.value })}
                    placeholder="18:30"
                    className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500"
                  />
                </div>
                <div>
                  <label className="block text-xs font-semibold text-gray-700 mb-1">
                    Jam Selesai
                  </label>
                  <input
                    type="text"
                    value={newEvent.end_time}
                    onChange={(e) => setNewEvent({ ...newEvent, end_time: e.target.value })}
                    placeholder="20:00 / Selesai"
                    className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500"
                  />
                </div>
              </div>

              <div>
                <label className="block text-xs font-semibold text-gray-700 mb-1">
                  Lokasi Kegiatan
                </label>
                <input
                  type="text"
                  value={newEvent.location}
                  onChange={(e) => setNewEvent({ ...newEvent, location: e.target.value })}
                  placeholder="Musholla Ar-rahman Gembor"
                  className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500"
                />
              </div>

              <div>
                <label className="block text-xs font-semibold text-gray-700 mb-1">
                  Deskripsi Kegiatan <span className="text-red-500">*</span>
                </label>
                <textarea
                  rows={3}
                  required
                  value={newEvent.description}
                  onChange={(e) => setNewEvent({ ...newEvent, description: e.target.value })}
                  placeholder="Keterangan pengajian, penceramah, susunan acara..."
                  className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500"
                />
              </div>

              <div className="flex justify-end gap-3 pt-3">
                <button
                  type="button"
                  onClick={() => setIsModalOpen(false)}
                  className="px-4 py-2 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50"
                >
                  Batal
                </button>
                <button
                  type="submit"
                  disabled={loading}
                  className="px-6 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-md"
                >
                  {loading ? "Menyimpan..." : "Simpan Kegiatan"}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}
