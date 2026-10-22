"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import {
  LayoutDashboard,
  Newspaper,
  Calendar,
  Image as ImageIcon,
  Wallet,
  Settings,
  MessageSquare,
  LogOut,
  ExternalLink,
  Shield,
  ChevronRight,
  KeyRound,
} from "lucide-react";
import { UserSession } from "@/lib/auth";
import { canAccess, getRoleLabel, ROLE_DEFINITIONS, AdminRole } from "@/lib/permissions";

interface AdminSidebarProps {
  user: UserSession;
}

const navItems = [
  { href: "/admin", label: "Dashboard", icon: LayoutDashboard },
  { href: "/admin/posts", label: "Kelola Berita", icon: Newspaper },
  { href: "/admin/events", label: "Kelola Kegiatan", icon: Calendar },
  { href: "/admin/gallery", label: "Kelola Galeri", icon: ImageIcon },
  { href: "/admin/finance", label: "Laporan Keuangan", icon: Wallet },
  { href: "/admin/settings", label: "Pengaturan Profil", icon: Settings },
  { href: "/admin/messages", label: "Pesan Warga", icon: MessageSquare },
  { href: "/admin/password", label: "Ganti Password", icon: KeyRound },
];

export default function AdminSidebar({ user }: AdminSidebarProps) {
  const pathname = usePathname();
  const allowedNavItems = navItems.filter((item) => canAccess(user.role, item.href));
  const roleLabel = getRoleLabel(user.role);
  const roleMeta = ROLE_DEFINITIONS[user.role as AdminRole] || {
    badgeColor: "bg-emerald-500/20 text-emerald-300 border-emerald-500/30",
  };

  return (
    <aside className="w-full md:w-72 bg-[#091512] text-white shrink-0 flex flex-col justify-between border-r border-emerald-950/60 shadow-xl z-20">
      <div className="p-6 space-y-7">
        {/* Brand Header */}
        <div className="flex items-center gap-3.5 pb-5 border-b border-white/10">
          <div className="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 via-emerald-500 to-teal-400 flex items-center justify-center text-white shadow-lg shadow-emerald-500/25 ring-2 ring-emerald-400/20">
            <Shield className="w-6 h-6" />
          </div>
          <div>
            <span className="font-extrabold text-sm block leading-tight tracking-tight text-white">
              Musholla Ar-rahman
            </span>
            <div className="flex items-center gap-1.5 mt-0.5">
              <span className="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
              <span className="text-[11px] font-medium text-emerald-400">Portal Pengurus DKM</span>
            </div>
          </div>
        </div>

        {/* Navigation Menu */}
        <div className="space-y-1.5">
          <div className="flex items-center justify-between px-3 mb-2">
            <span className="text-[10px] uppercase font-bold tracking-wider text-slate-500 block">
              Menu Utama
            </span>
            <span className="text-[10px] px-2 py-0.5 rounded-full font-mono bg-white/5 text-slate-400 border border-white/5">
              {allowedNavItems.length} modul
            </span>
          </div>

          <nav className="space-y-1">
            {allowedNavItems.map((item) => {
              const Icon = item.icon;
              const isActive =
                item.href === "/admin"
                  ? pathname === "/admin"
                  : pathname.startsWith(item.href);

              return (
                <Link
                  key={item.href}
                  href={item.href}
                  className={`flex items-center justify-between px-3.5 py-3 rounded-xl text-sm font-medium transition-all group ${
                    isActive
                      ? "admin-nav-active font-semibold text-emerald-400"
                      : "admin-nav-inactive text-slate-400 hover:text-white"
                  }`}
                >
                  <div className="flex items-center gap-3">
                    <Icon
                      className={`w-4 h-4 transition-transform group-hover:scale-110 ${
                        isActive ? "text-emerald-400" : "text-slate-400 group-hover:text-emerald-400"
                      }`}
                    />
                    <span>{item.label}</span>
                  </div>
                  {isActive && <ChevronRight className="w-4 h-4 text-emerald-400 shrink-0" />}
                </Link>
              );
            })}
          </nav>
        </div>
      </div>

      {/* Footer Info & User Card */}
      <div className="p-5 border-t border-white/10 bg-black/20 space-y-4">
        {/* User Badge */}
        <Link
          href="/admin/password"
          className="flex items-center gap-3 p-2.5 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 transition-colors group cursor-pointer"
          title="Klik untuk ganti password"
        >
          <div className="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-md">
            {user.name.substring(0, 2).toUpperCase()}
          </div>
          <div className="min-w-0 flex-1">
            <span className="font-bold text-xs text-white block truncate group-hover:text-emerald-300 transition-colors">
              {user.name}
            </span>
            <div className="flex items-center gap-1.5 mt-0.5">
              <span className={`text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md border ${roleMeta.badgeColor}`}>
                {roleLabel}
              </span>
            </div>
          </div>
          <KeyRound className="w-3.5 h-3.5 text-slate-500 group-hover:text-emerald-400 transition-colors shrink-0" />
        </Link>

        {/* Action Buttons */}
        <div className="flex items-center justify-between pt-1 text-xs">
          <Link
            href="/"
            target="_blank"
            className="text-slate-400 hover:text-white flex items-center gap-1.5 font-medium transition-colors py-1 px-2 rounded-lg hover:bg-white/5"
          >
            <span>Kunjungi Web</span>
            <ExternalLink className="w-3.5 h-3.5" />
          </Link>

          <form action="/api/auth/logout" method="POST">
            <button
              type="submit"
              className="text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 flex items-center gap-1.5 font-semibold py-1 px-2.5 rounded-lg transition-colors cursor-pointer"
            >
              <LogOut className="w-3.5 h-3.5" />
              <span>Keluar</span>
            </button>
          </form>
        </div>
      </div>
    </aside>
  );
}
