"use client";

import { useState } from "react";
import Image from "next/image";
import { Plus, Trash2, X, CheckCircle2 } from "lucide-react";
import { GalleryItem } from "@/types";
import { uploadUrl } from "@/lib/helper";

interface GalleryManagerProps {
  initialGalleries: GalleryItem[];
}

export default function GalleryManager({ initialGalleries }: GalleryManagerProps) {
  const [items, setItems] = useState<GalleryItem[]>(initialGalleries);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [loading, setLoading] = useState(false);
  const [msg, setMsg] = useState("");
  const [newPhoto, setNewPhoto] = useState({
    title: "",
    image: "/images/hero-bg-collage.jpg",
    category: "Kegiatan",
    description: "",
  });

  const handleDelete = async (id: number) => {
    if (!confirm("Hapus foto ini dari galeri?")) return;
    try {
      const res = await fetch(`/api/admin/gallery?id=${id}`, { method: "DELETE" });
      if (res.ok) {
        setItems((prev) => prev.filter((i) => i.id !== id));
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
      const res = await fetch("/api/admin/gallery", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(newPhoto),
      });

      if (res.ok) {
        setMsg("Foto baru berhasil ditambahkan!");
        setIsModalOpen(false);
        setNewPhoto({
          title: "",
          image: "/images/hero-bg-collage.jpg",
          category: "Kegiatan",
          description: "",
        });
        const updated = await fetch("/api/admin/gallery").then((r) => r.json());
        setItems(updated);
      } else {
        alert("Gagal menambahkan foto.");
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
          Koleksi Foto Dokumentasi ({items.length} Foto)
        </h2>
        <button
          onClick={() => setIsModalOpen(true)}
          className="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm shadow-md flex items-center gap-1.5 transition-colors"
        >
          <Plus className="w-4 h-4" />
          <span>Tambah Foto Baru</span>
        </button>
      </div>

      {/* Grid Photos */}
      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        {items.map((item) => (
          <div
            key={item.id}
            className="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm flex flex-col justify-between group"
          >
            <div className="relative h-48 w-full bg-gray-100">
              <Image src={uploadUrl(item.image)} alt={item.title} fill className="object-cover" />
              <div className="absolute top-2 left-2 bg-black/60 backdrop-blur-xs text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">
                {item.category}
              </div>
            </div>

            <div className="p-4 flex-1 flex flex-col justify-between space-y-3">
              <h3 className="font-bold text-gray-900 text-xs sm:text-sm line-clamp-2 leading-snug">
                {item.title}
              </h3>
              <div className="flex items-center justify-between pt-2 border-t border-gray-100">
                <span className="text-[10px] text-gray-400 font-mono">ID: #{item.id}</span>
                <button
                  onClick={() => handleDelete(item.id)}
                  className="p-1.5 rounded-lg text-red-500 hover:text-red-700 hover:bg-red-50 transition-colors"
                  title="Hapus foto"
                >
                  <Trash2 className="w-4 h-4" />
                </button>
              </div>
            </div>
          </div>
        ))}
      </div>

      {/* Modal Tambah Foto */}
      {isModalOpen && (
        <div className="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-gray-100">
              <h3 className="text-lg font-bold text-gray-900">Tambah Foto ke Galeri</h3>
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
                  Judul Foto / Kegiatan <span className="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  required
                  value={newPhoto.title}
                  onChange={(e) => setNewPhoto({ ...newPhoto, title: e.target.value })}
                  placeholder="Contoh: Sholat Berjamaah Idul Fitri Warga RT 07"
                  className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500"
                />
              </div>

              <div>
                <label className="block text-xs font-semibold text-gray-700 mb-1">
                  URL / Path File Gambar <span className="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  required
                  value={newPhoto.image}
                  onChange={(e) => setNewPhoto({ ...newPhoto, image: e.target.value })}
                  placeholder="/uploads/foto-kegiatan-1.jpeg"
                  className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500"
                />
              </div>

              <div>
                <label className="block text-xs font-semibold text-gray-700 mb-1">Kategori</label>
                <select
                  value={newPhoto.category}
                  onChange={(e) => setNewPhoto({ ...newPhoto, category: e.target.value })}
                  className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500"
                >
                  <option value="Kegiatan">Kegiatan</option>
                  <option value="Kajian">Kajian</option>
                  <option value="Jamaah">Jamaah</option>
                  <option value="Fasilitas">Fasilitas</option>
                  <option value="Sosialisasi">Sosialisasi</option>
                </select>
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
                  {loading ? "Menyimpan..." : "Simpan Foto"}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}
