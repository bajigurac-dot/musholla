import { redirect } from "next/navigation";
import { Image as ImageIcon } from "lucide-react";
import GalleryManager from "@/components/admin/GalleryManager";
import { getCurrentUser } from "@/lib/auth";
import { canAccess } from "@/lib/permissions";
import { getGalleries } from "@/lib/data";

export default async function AdminGalleryPage() {
  const user = await getCurrentUser();
  if (!user) {
    redirect("/admin/login");
  }

  if (!canAccess(user.role, "/admin/gallery")) {
    redirect("/admin");
  }

  const galleries = await getGalleries();

  return (
    <div className="space-y-6">
      <div className="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
          <span className="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">
            Dokumentasi
          </span>
          <h1 className="text-2xl font-extrabold text-gray-900 mt-2 flex items-center gap-2">
            <ImageIcon className="w-6 h-6 text-emerald-600" />
            <span>Kelola Galeri Foto Kegiatan</span>
          </h1>
          <p className="text-xs text-gray-500 mt-1">
            Tambah, ganti judul, dan hapus foto kegiatan dokumentasi warga musholla
          </p>
        </div>
      </div>

      <GalleryManager initialGalleries={galleries} />
    </div>
  );
}
