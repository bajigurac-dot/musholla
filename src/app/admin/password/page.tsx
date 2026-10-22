import { redirect } from "next/navigation";
import { KeyRound, ShieldCheck } from "lucide-react";
import PasswordManager from "@/components/admin/PasswordManager";
import { getCurrentUser } from "@/lib/auth";
import { getDb, ensureDatabaseReady } from "@/lib/db";

export default async function AdminPasswordPage() {
  const user = await getCurrentUser();
  if (!user) {
    redirect("/admin/login");
  }

  let usersList: {
    id: number;
    name: string;
    username: string;
    email: string;
    role: string;
    is_active: number;
    last_login: string | null;
  }[] = [];

  if (user.role === "admin" || user.role === "super_admin") {
    await ensureDatabaseReady();
    const db = getDb();
    const res = await db.execute(
      "SELECT id, name, username, email, role, is_active, last_login FROM users ORDER BY id ASC"
    );
    usersList = JSON.parse(JSON.stringify(res.rows));
  }

  return (
    <div className="space-y-6">
      <div className="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
          <span className="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full inline-flex items-center gap-1.5">
            <ShieldCheck className="w-3.5 h-3.5" />
            <span>Keamanan Akun</span>
          </span>
          <h1 className="text-2xl font-extrabold text-gray-900 mt-2 flex items-center gap-2">
            <KeyRound className="w-6 h-6 text-emerald-600" />
            <span>Pengaturan Kata Sandi & Akses Pengurus</span>
          </h1>
          <p className="text-xs text-gray-500 mt-1">
            Ganti kata sandi pribadi Anda dan kelola keamanan akun portal DKM Musholla Ar-rahman
          </p>
        </div>
      </div>

      <PasswordManager currentUser={user} initialUsers={usersList} />
    </div>
  );
}
