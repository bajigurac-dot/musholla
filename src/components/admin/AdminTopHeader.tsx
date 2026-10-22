"use client";

import { usePathname } from "next/navigation";
import Link from "next/link";
import { ExternalLink, Globe } from "lucide-react";
import { UserSession } from "@/lib/auth";

const pageTitles: Record<string, { title: string; subtitle: string }> = {
  "/admin": {
    title: "Ringkasan Dashboard",
    subtitle: "Pantau ringkasan berita, agenda, kas, dan aspirasi jamaah musholla",
  },
  "/admin/posts": {
    title: "Kelola Berita & Pengumuman",
    subtitle: "Terbitkan kabar terkini, tausiyah singkat, dan pemberitahuan DKM",
  },
  "/admin/events": {
    title: "Kelola Agenda Kegiatan",
    subtitle: "Jadwalkan kegiatan sholat, kajian rutin, yasinan, dan peringatan hari besar Islam",
  },
  "/admin/gallery": {
    title: "Kelola Galeri Foto",
    subtitle: "Dokumentasi momen kegiatan jamaah dan sarana fisik musholla",
  },
  "/admin/finance": {
    title: "Laporan Kas & Transparansi Infaq",
    subtitle: "Kelola laporan pemasukan dan pengeluaran kas musholla secara amanah",
  },
  "/admin/settings": {
    title: "Pengaturan Identitas & Kontak",
    subtitle: "Ubah nama, kontak pengurus, alamat, rekening BJB, dan fasilitas",
  },
  "/admin/messages": {
    title: "Pesan & Aspirasi Jamaah",
    subtitle: "Daftar usulan dan pesan yang dikirimkan warga melalui website",
  },
  "/admin/password": {
    title: "Keamanan Akun & Kata Sandi",
    subtitle: "Perbarui kata sandi akun untuk menjaga keamanan hak akses portal DKM",
  },
};

import { getRoleLabel } from "@/lib/permissions";

export default function AdminTopHeader({ user }: { user: UserSession }) {
  const pathname = usePathname();
  const current = pageTitles[pathname] || {
    title: "Panel Administrator",
    subtitle: "Sistem Pengelolaan Musholla Ar-rahman",
  };
  const roleLabel = getRoleLabel(user.role);

  return (
    <header className="bg-white/80 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-10 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <div className="flex items-center gap-2 text-xs text-slate-500 mb-0.5">
          <span>Portal DKM</span>
          <span>/</span>
          <span className="font-semibold text-emerald-700">{current.title}</span>
        </div>
        <h1 className="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
          {current.title}
        </h1>
      </div>

      <div className="flex items-center gap-3">
        <Link
          href="/"
          target="_blank"
          className="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs inline-flex items-center gap-2 transition-colors border border-slate-200/60"
        >
          <Globe className="w-3.5 h-3.5 text-emerald-600" />
          <span>Lihat Website</span>
          <ExternalLink className="w-3 h-3 text-slate-400" />
        </Link>

        <Link
          href="/admin/password"
          className="hidden sm:flex items-center gap-2 pl-3 border-l border-slate-200 hover:opacity-80 transition-opacity"
          title="Klik untuk ke halaman ganti kata sandi"
        >
          <div className="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
            {user.name.substring(0, 1)}
          </div>
          <div className="text-left">
            <span className="text-xs font-bold text-slate-800 block leading-tight">
              {user.name}
            </span>
            <span className="text-[10px] text-emerald-600 font-medium block">
              ● {roleLabel}
            </span>
          </div>
        </Link>
      </div>
    </header>
  );
}
