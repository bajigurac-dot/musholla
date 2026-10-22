export type AdminRole = "super_admin" | "admin" | "sekretaris" | "bendahara" | "editor";

export interface RoleInfo {
  role: AdminRole;
  label: string;
  description: string;
  badgeColor: string;
}

export const ROLE_DEFINITIONS: Record<AdminRole, RoleInfo> = {
  super_admin: {
    role: "super_admin",
    label: "Super Admin",
    description: "Akses penuh ke semua modul, laporan, dan pengaturan sistem",
    badgeColor: "bg-emerald-500/20 text-emerald-400 border-emerald-500/30",
  },
  admin: {
    role: "admin",
    label: "Administrator",
    description: "Akses penuh ke seluruh pengelolaan musholla",
    badgeColor: "bg-emerald-500/20 text-emerald-400 border-emerald-500/30",
  },
  sekretaris: {
    role: "sekretaris",
    label: "Sekretaris",
    description: "Pengelolaan warta berita, agenda kegiatan, dan dokumentasi galeri",
    badgeColor: "bg-blue-500/20 text-blue-400 border-blue-500/30",
  },
  bendahara: {
    role: "bendahara",
    label: "Bendahara",
    description: "Pengelolaan keuangan, kas masuk, pengeluaran, dan transparansi infaq",
    badgeColor: "bg-amber-500/20 text-amber-400 border-amber-500/30",
  },
  editor: {
    role: "editor",
    label: "Editor Publikasi",
    description: "Pengelolaan berita, pengumuman, dan galeri",
    badgeColor: "bg-purple-500/20 text-purple-400 border-purple-500/30",
  },
};

/**
 * Check whether a user role has permission to access a specific route or action.
 */
export function canAccess(role: string | undefined | null, path: string): boolean {
  if (!role) return false;

  // super_admin and admin have unrestricted access
  if (role === "admin" || role === "super_admin") {
    return true;
  }

  // Common root dashboard and change password are accessible to all authenticated roles
  if (path === "/admin" || path.startsWith("/admin/password")) {
    return true;
  }

  // Sekretaris: upload berita, kegiatan, dan kelola galeri
  if (role === "sekretaris" || role === "editor") {
    return (
      path.startsWith("/admin/posts") ||
      path.startsWith("/admin/events") ||
      path.startsWith("/admin/gallery")
    );
  }

  // Bendahara: laporan keuangan
  if (role === "bendahara") {
    return path.startsWith("/admin/finance");
  }

  return false;
}

/**
 * Returns human-readable label for a role.
 */
export function getRoleLabel(role: string | undefined | null): string {
  if (!role) return "Tamu";
  const def = ROLE_DEFINITIONS[role as AdminRole];
  if (def) return def.label;
  return role.charAt(0).toUpperCase() + role.slice(1).replace("_", " ");
}
