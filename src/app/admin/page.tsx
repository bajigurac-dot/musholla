import { redirect } from "next/navigation";
import Link from "next/link";
import {
  Newspaper,
  Calendar,
  Image as ImageIcon,
  Wallet,
  MessageSquare,
  Plus,
  ArrowRight,
  ExternalLink,
  Sparkles,
  TrendingUp,
  TrendingDown,
  ShieldCheck,
} from "lucide-react";
import { getCurrentUser } from "@/lib/auth";
import { canAccess, getRoleLabel } from "@/lib/permissions";
import {
  getPosts,
  getEvents,
  getGalleries,
  getFinancialSummary,
  getFinancialReports,
  getContactMessages,
  getSettings,
} from "@/lib/data";

export default async function AdminDashboardPage() {
  const user = await getCurrentUser();
  if (!user) {
    redirect("/admin/login");
  }

  const [posts, events, galleries, finance, financialReports, messages, settings] =
    await Promise.all([
      getPosts(),
      getEvents(),
      getGalleries(),
      getFinancialSummary(),
      getFinancialReports(),
      getContactMessages(),
      getSettings(),
    ]);

  const roleLabel = getRoleLabel(user.role);
  const isBendahara = user.role === "bendahara";
  const isSekretaris = user.role === "sekretaris" || user.role === "editor";
  const isAdmin = user.role === "admin" || user.role === "super_admin";

  // Build metric cards dynamically based on role
  let metricCards = [];

  if (isBendahara) {
    metricCards = [
      {
        title: "Saldo Kas Berjalan",
        value: `Rp ${finance.balance.toLocaleString("id-ID")}`,
        desc: "Kas tunai & rekening infaq saat ini",
        icon: Wallet,
        href: "/admin/finance",
        color: "from-emerald-700 to-teal-800",
      },
      {
        title: "Akumulasi Pemasukan Infaq",
        value: `Rp ${finance.totalIncome.toLocaleString("id-ID")}`,
        desc: "Total sedekah & donasi tercatat",
        icon: TrendingUp,
        href: "/admin/finance",
        color: "from-blue-600 to-cyan-600",
      },
      {
        title: "Akumulasi Pengeluaran",
        value: `Rp ${finance.totalExpense.toLocaleString("id-ID")}`,
        desc: "Biaya operasional & pemeliharaan",
        icon: TrendingDown,
        href: "/admin/finance",
        color: "from-amber-600 to-rose-600",
      },
    ];
  } else if (isSekretaris) {
    metricCards = [
      {
        title: "Total Berita & Warta",
        value: `${posts.length} Artikel`,
        desc: "Kabar & pengumuman jamaah",
        icon: Newspaper,
        href: "/admin/posts",
        color: "from-blue-600 to-indigo-600",
      },
      {
        title: "Agenda Kegiatan",
        value: `${events.length} Agenda`,
        desc: "Jadwal sholat, pengajian & kajian",
        icon: Calendar,
        href: "/admin/events",
        color: "from-emerald-600 to-teal-600",
      },
      {
        title: "Dokumentasi Galeri",
        value: `${galleries.length} Foto`,
        desc: "Dokumentasi kegiatan & sarana",
        icon: ImageIcon,
        href: "/admin/gallery",
        color: "from-purple-600 to-pink-600",
      },
    ];
  } else {
    // Admin / Super Admin (All Access)
    metricCards = [
      {
        title: "Total Berita",
        value: `${posts.length} Artikel`,
        desc: "Kabar & pengumuman jamaah",
        icon: Newspaper,
        href: "/admin/posts",
        color: "from-blue-600 to-indigo-600",
      },
      {
        title: "Agenda Kegiatan",
        value: `${events.length} Agenda`,
        desc: "Jadwal sholat & pengajian",
        icon: Calendar,
        href: "/admin/events",
        color: "from-emerald-600 to-teal-600",
      },
      {
        title: "Foto Galeri",
        value: `${galleries.length} Foto`,
        desc: "Dokumentasi kegiatan fisik",
        icon: ImageIcon,
        href: "/admin/gallery",
        color: "from-purple-600 to-pink-600",
      },
      {
        title: "Saldo Kas Berjalan",
        value: `Rp ${finance.balance.toLocaleString("id-ID")}`,
        desc: "Kas tunai & rekening BJB",
        icon: Wallet,
        href: "/admin/finance",
        color: "from-emerald-700 to-teal-800",
      },
      {
        title: "Pesan Masuk",
        value: `${messages.length} Pesan`,
        desc: "Aspirasi & masukan jamaah",
        icon: MessageSquare,
        href: "/admin/messages",
        color: "from-rose-600 to-red-600",
      },
    ];
  }

  return (
    <div className="space-y-8">
      {/* Welcome Banner */}
      <div className="relative overflow-hidden bg-gradient-to-r from-[#075B4A] via-[#053E32] to-[#0a483b] text-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-emerald-950/20 border border-emerald-600/30 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div className="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-400/15 rounded-full blur-3xl pointer-events-none" />

        <div className="space-y-2 relative z-10">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold backdrop-blur-xs border border-white/10">
            <Sparkles className="w-3.5 h-3.5 text-emerald-300" />
            <span>Selamat Bertugas, {user.name}</span>
            <span className="text-white/40">•</span>
            <span className="bg-emerald-400/20 text-emerald-200 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider">
              {roleLabel}
            </span>
          </div>

          <h2 className="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
            Ahlan wa Sahlan di Panel DKM
          </h2>

          <p className="text-xs sm:text-sm text-emerald-200/90 max-w-xl leading-relaxed">
            {isBendahara && "Akses khusus Bendahara untuk pelaporan kas infaq, pencatatan pemasukan sedekah, dan transparansi pengeluaran."}
            {isSekretaris && "Akses khusus Sekretaris untuk publikasi warta berita, jadwal agenda pengajian, dan dokumentasi foto galeri kegiatan."}
            {isAdmin && `Pusat pengelolaan publikasi, jadwal agenda, transparansi kas, dan aspirasi jamaah ${settings.mushola_name}.`}
          </p>
        </div>

        {/* Quick Action Shortcuts based on Role */}
        <div className="flex flex-wrap items-center gap-3 relative z-10">
          {canAccess(user.role, "/admin/posts") && (
            <Link
              href="/admin/posts"
              className="px-4 py-2.5 rounded-xl bg-white hover:bg-emerald-50 text-emerald-950 font-extrabold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all inline-flex items-center gap-2 cursor-pointer border border-white"
            >
              <Plus className="w-4 h-4 text-emerald-700 shrink-0" />
              <span className="text-emerald-950 font-extrabold">Tulis Berita</span>
            </Link>
          )}

          {canAccess(user.role, "/admin/events") && (
            <Link
              href="/admin/events"
              className="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs sm:text-sm border border-white/25 transition-all inline-flex items-center gap-2 cursor-pointer backdrop-blur-xs"
            >
              <Calendar className="w-4 h-4 text-emerald-300 shrink-0" />
              <span className="text-white font-semibold">Agenda Baru</span>
            </Link>
          )}

          {canAccess(user.role, "/admin/gallery") && (
            <Link
              href="/admin/gallery"
              className="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs sm:text-sm border border-white/25 transition-all inline-flex items-center gap-2 cursor-pointer backdrop-blur-xs"
            >
              <ImageIcon className="w-4 h-4 text-emerald-300 shrink-0" />
              <span className="text-white font-semibold">Upload Foto</span>
            </Link>
          )}

          {canAccess(user.role, "/admin/finance") && (
            <Link
              href="/admin/finance"
              className="px-4 py-2.5 rounded-xl bg-emerald-300 hover:bg-emerald-200 text-emerald-950 font-extrabold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all inline-flex items-center gap-2 cursor-pointer border border-emerald-300"
            >
              <Wallet className="w-4 h-4 text-emerald-900 shrink-0" />
              <span className="text-emerald-950 font-extrabold">Kelola Kas</span>
            </Link>
          )}
        </div>
      </div>

      {/* Metrics Grid */}
      <div>
        <div className="flex items-center justify-between mb-4">
          <h3 className="text-sm font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
            <ShieldCheck className="w-4 h-4 text-emerald-600" />
            <span>Ringkasan Tugas & Data ({roleLabel})</span>
          </h3>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
          {metricCards.map((c) => {
            const Icon = c.icon;
            return (
              <Link
                key={c.title}
                href={c.href}
                className="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-lg hover:border-slate-300 transition-all group flex flex-col justify-between space-y-4 cursor-pointer"
              >
                <div className="flex items-center justify-between">
                  <div
                    className={`w-12 h-12 rounded-2xl bg-gradient-to-tr ${c.color} text-white flex items-center justify-center shadow-md`}
                  >
                    <Icon className="w-6 h-6" />
                  </div>
                  <ArrowRight className="w-4 h-4 text-slate-300 group-hover:text-emerald-600 group-hover:translate-x-1 transition-all" />
                </div>

                <div>
                  <span className="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                    {c.title}
                  </span>
                  <span className="text-2xl sm:text-3xl font-extrabold text-slate-900 font-mono tracking-tight mt-1 block">
                    {c.value}
                  </span>
                  <span className="text-[11px] text-slate-400 mt-1 block">
                    {c.desc}
                  </span>
                </div>
              </Link>
            );
          })}
        </div>
      </div>

      {/* Dynamic Role-specific Sections */}
      {isBendahara ? (
        /* Bendahara View: Riwayat Laporan Keuangan Terakhir */
        <div className="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
          <div className="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 className="font-bold text-slate-900 text-base flex items-center gap-2">
              <Wallet className="w-4 h-4 text-emerald-600" />
              <span>Riwayat Transaksi Kas Terakhir</span>
            </h3>
            <Link
              href="/admin/finance"
              className="text-xs font-semibold text-emerald-700 hover:text-emerald-800"
            >
              Buka Laporan Penuh ({financialReports.length} Periode)
            </Link>
          </div>

          {financialReports.length === 0 ? (
            <div className="py-8 text-center text-xs text-slate-400">
              Belum ada riwayat pembukuan kas yang tercatat.
            </div>
          ) : (
            <div className="overflow-x-auto">
              <table className="w-full text-xs text-left">
                <thead>
                  <tr className="border-b border-slate-100 text-slate-400 font-medium uppercase">
                    <th className="py-2.5 px-3">Periode</th>
                    <th className="py-2.5 px-3">Keterangan</th>
                    <th className="py-2.5 px-3 text-right">Pemasukan</th>
                    <th className="py-2.5 px-3 text-right">Pengeluaran</th>
                    <th className="py-2.5 px-3 text-right">Saldo</th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-slate-100">
                  {financialReports.slice(0, 5).map((r) => (
                    <tr key={r.id} className="hover:bg-slate-50">
                      <td className="py-3 px-3 font-bold text-slate-900">
                        Bulan {r.period_month} / {r.period_year}
                      </td>
                      <td className="py-3 px-3 text-slate-600">{r.description}</td>
                      <td className="py-3 px-3 text-right font-mono font-semibold text-emerald-600">
                        + Rp {Number(r.income).toLocaleString("id-ID")}
                      </td>
                      <td className="py-3 px-3 text-right font-mono font-semibold text-rose-600">
                        - Rp {Number(r.expense).toLocaleString("id-ID")}
                      </td>
                      <td className="py-3 px-3 text-right font-mono font-bold text-slate-900">
                        Rp {Number(r.balance).toLocaleString("id-ID")}
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </div>
      ) : isSekretaris ? (
        /* Sekretaris View: Berita Terbaru & Agenda */
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
          {/* Berita Terbaru */}
          <div className="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
              <h3 className="font-bold text-slate-900 text-base flex items-center gap-2">
                <Newspaper className="w-4 h-4 text-emerald-600" />
                <span>Berita Terakhir Diterbitkan</span>
              </h3>
              <Link
                href="/admin/posts"
                className="text-xs font-semibold text-emerald-700 hover:text-emerald-800"
              >
                Kelola Semua ({posts.length})
              </Link>
            </div>

            {posts.length === 0 ? (
              <div className="py-8 text-center text-xs text-slate-400">
                Belum ada berita yang diterbitkan.
              </div>
            ) : (
              <div className="space-y-3">
                {posts.slice(0, 3).map((p) => (
                  <div
                    key={p.id}
                    className="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between gap-3"
                  >
                    <div className="min-w-0 flex-1">
                      <span className="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block">
                        {p.category}
                      </span>
                      <h4 className="font-bold text-xs text-slate-900 truncate mt-0.5">
                        {p.title}
                      </h4>
                      <span className="text-[10px] text-slate-400 mt-0.5 block">
                        Oleh: {p.author} • {p.created_at?.substring(0, 10)}
                      </span>
                    </div>
                    <span className="text-[10px] px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-semibold shrink-0">
                      {p.status}
                    </span>
                  </div>
                ))}
              </div>
            )}
          </div>

          {/* Agenda Kegiatan */}
          <div className="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
              <h3 className="font-bold text-slate-900 text-base flex items-center gap-2">
                <Calendar className="w-4 h-4 text-emerald-600" />
                <span>Agenda Mendatang</span>
              </h3>
              <Link
                href="/admin/events"
                className="text-xs font-semibold text-emerald-700 hover:text-emerald-800"
              >
                Kelola Semua ({events.length})
              </Link>
            </div>

            {events.length === 0 ? (
              <div className="py-8 text-center text-xs text-slate-400">
                Belum ada jadwal kegiatan mendatang.
              </div>
            ) : (
              <div className="space-y-3">
                {events.slice(0, 3).map((e) => (
                  <div
                    key={e.id}
                    className="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between gap-3"
                  >
                    <div className="min-w-0 flex-1">
                      <span className="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block">
                        {e.category}
                      </span>
                      <h4 className="font-bold text-xs text-slate-900 truncate mt-0.5">
                        {e.title}
                      </h4>
                      <span className="text-[10px] text-slate-400 mt-0.5 block">
                        📅 {e.event_date} • ⏰ {e.start_time} WIB
                      </span>
                    </div>
                    <span className="text-[10px] px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 font-semibold shrink-0">
                      {e.status}
                    </span>
                  </div>
                ))}
              </div>
            )}
          </div>
        </div>
      ) : (
        /* Administrator View (All Access): Aspirasi Jamaah & Info Musholla */
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
          {/* Pesan Warga Terbaru */}
          <div className="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
              <h3 className="font-bold text-slate-900 text-base flex items-center gap-2">
                <MessageSquare className="w-4 h-4 text-emerald-600" />
                <span>Aspirasi Jamaah Terbaru</span>
              </h3>
              <Link
                href="/admin/messages"
                className="text-xs font-semibold text-emerald-700 hover:text-emerald-800"
              >
                Lihat Semua ({messages.length})
              </Link>
            </div>

            {messages.length === 0 ? (
              <div className="py-8 text-center text-xs text-slate-400">
                Belum ada pesan yang masuk dari jamaah.
              </div>
            ) : (
              <div className="space-y-3">
                {messages.slice(0, 3).map((m) => (
                  <div
                    key={m.id}
                    className="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5"
                  >
                    <div className="flex items-center justify-between">
                      <span className="font-bold text-xs text-slate-900">{m.name}</span>
                      <span className="text-[10px] text-slate-400 font-mono">
                        {m.created_at?.substring(0, 10)}
                      </span>
                    </div>
                    <p className="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                      &ldquo;{m.message}&rdquo;
                    </p>
                  </div>
                ))}
              </div>
            )}
          </div>

          {/* Informasi Pintas Musholla */}
          <div className="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
              <h3 className="font-bold text-slate-900 text-base flex items-center gap-2">
                <ExternalLink className="w-4 h-4 text-emerald-600" />
                <span>Informasi & Pengaturan Musholla</span>
              </h3>
              <Link
                href="/admin/settings"
                className="text-xs font-semibold text-emerald-700 hover:text-emerald-800"
              >
                Ubah Pengaturan
              </Link>
            </div>

            <div className="space-y-3 text-xs">
              <div className="flex justify-between py-2 border-b border-slate-100">
                <span className="text-slate-500 font-medium">Nama Resmi:</span>
                <span className="font-bold text-slate-900">{settings.mushola_name}</span>
              </div>
              <div className="flex justify-between py-2 border-b border-slate-100">
                <span className="text-slate-500 font-medium">Rekening Donasi:</span>
                <span className="font-bold text-emerald-700 font-mono">
                  {settings.donation_bank} - {settings.donation_account}
                </span>
              </div>
              <div className="flex justify-between py-2 border-b border-slate-100">
                <span className="text-slate-500 font-medium">WhatsApp Pengurus:</span>
                <span className="font-bold text-slate-900 font-mono">{settings.phone_1}</span>
              </div>
              <div className="flex justify-between py-2">
                <span className="text-slate-500 font-medium">Lokasi:</span>
                <span className="font-medium text-slate-700 text-right max-w-xs truncate">
                  {settings.address}
                </span>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
