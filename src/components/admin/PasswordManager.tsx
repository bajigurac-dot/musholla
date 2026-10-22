"use client";

import { useState } from "react";
import {
  KeyRound,
  Shield,
  Eye,
  EyeOff,
  CheckCircle2,
  AlertCircle,
  Loader2,
  Lock,
  UserCheck,
  RefreshCw,
  Sparkles,
} from "lucide-react";
import { UserSession } from "@/lib/auth";
import { getRoleLabel, ROLE_DEFINITIONS, AdminRole } from "@/lib/permissions";

interface UserAccount {
  id: number;
  name: string;
  username: string;
  email: string;
  role: string;
  is_active: number;
  last_login: string | null;
}

interface PasswordManagerProps {
  currentUser: UserSession;
  initialUsers?: UserAccount[];
}

export default function PasswordManager({
  currentUser,
  initialUsers = [],
}: PasswordManagerProps) {
  // Self Password Change State
  const [currentPassword, setCurrentPassword] = useState("");
  const [newPassword, setNewPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [showCurrent, setShowCurrent] = useState(false);
  const [showNew, setShowNew] = useState(false);
  const [showConfirm, setShowConfirm] = useState(false);
  const [loadingSelf, setLoadingSelf] = useState(false);
  const [selfMessage, setSelfMessage] = useState<{ type: "success" | "error"; text: string } | null>(
    null
  );

  // Admin Reset State
  const [usersList, setUsersList] = useState<UserAccount[]>(initialUsers);
  const [selectedUser, setSelectedUser] = useState<UserAccount | null>(null);
  const [adminNewPassword, setAdminNewPassword] = useState("");
  const [loadingAdmin, setLoadingAdmin] = useState(false);
  const [adminMessage, setAdminMessage] = useState<{
    type: "success" | "error";
    text: string;
  } | null>(null);

  const isAdmin = currentUser.role === "admin" || currentUser.role === "super_admin";

  // Handle Self Password Change
  const handleSelfSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setSelfMessage(null);

    if (newPassword.length < 6) {
      setSelfMessage({ type: "error", text: "Kata sandi baru minimal harus 6 karakter." });
      return;
    }

    if (newPassword !== confirmPassword) {
      setSelfMessage({ type: "error", text: "Konfirmasi kata sandi baru tidak sama." });
      return;
    }

    setLoadingSelf(true);
    try {
      const res = await fetch("/api/admin/password", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ currentPassword, newPassword, confirmPassword }),
      });

      const data = await res.json();
      if (!res.ok) {
        throw new Error(data.message || "Gagal memperbarui kata sandi.");
      }

      setSelfMessage({ type: "success", text: data.message });
      setCurrentPassword("");
      setNewPassword("");
      setConfirmPassword("");
    } catch (err: unknown) {
      const error = err as Error;
      setSelfMessage({ type: "error", text: error.message || "Terjadi kesalahan." });
    } finally {
      setLoadingSelf(false);
    }
  };

  // Handle Admin Reset
  const handleAdminReset = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!selectedUser) return;
    setAdminMessage(null);

    if (adminNewPassword.length < 6) {
      setAdminMessage({ type: "error", text: "Password baru minimal 6 karakter." });
      return;
    }

    setLoadingAdmin(true);
    try {
      const res = await fetch("/api/admin/password", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ targetUserId: selectedUser.id, newPassword: adminNewPassword }),
      });

      const data = await res.json();
      if (!res.ok) {
        throw new Error(data.message || "Gagal mereset kata sandi.");
      }

      setAdminMessage({ type: "success", text: data.message });
      setAdminNewPassword("");
      setSelectedUser(null);
    } catch (err: unknown) {
      const error = err as Error;
      setAdminMessage({ type: "error", text: error.message || "Terjadi kesalahan." });
    } finally {
      setLoadingAdmin(false);
    }
  };

  return (
    <div className="space-y-8">
      {/* Section 1: Self Password Change Form */}
      <div className="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs">
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
          <div>
            <div className="flex items-center gap-2">
              <span className="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                <Lock className="w-4 h-4" />
              </span>
              <h2 className="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">
                Ganti Kata Sandi Akun Anda
              </h2>
            </div>
            <p className="text-xs text-slate-500 mt-1">
              Amankan akun pengurus Anda dengan memperbarui kata sandi secara berkala
            </p>
          </div>

          {/* User info chip */}
          <div className="inline-flex items-center gap-2.5 px-3.5 py-2 rounded-2xl bg-slate-50 border border-slate-200/60 self-start sm:self-auto">
            <div className="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-xs">
              {currentUser.username.substring(0, 1).toUpperCase()}
            </div>
            <div className="text-left text-xs">
              <span className="font-bold text-slate-800 block leading-tight">
                @{currentUser.username}
              </span>
              <span className="text-[10px] text-emerald-600 font-semibold block">
                {getRoleLabel(currentUser.role)}
              </span>
            </div>
          </div>
        </div>

        {/* Self Feedback Alert */}
        {selfMessage && (
          <div
            className={`mt-6 p-4 rounded-2xl flex items-start gap-3 text-xs leading-relaxed ${
              selfMessage.type === "success"
                ? "bg-emerald-50 text-emerald-800 border border-emerald-200"
                : "bg-rose-50 text-rose-800 border border-rose-200"
            }`}
          >
            {selfMessage.type === "success" ? (
              <CheckCircle2 className="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" />
            ) : (
              <AlertCircle className="w-4 h-4 text-rose-600 shrink-0 mt-0.5" />
            )}
            <span className="font-medium">{selfMessage.text}</span>
          </div>
        )}

        <form onSubmit={handleSelfSubmit} className="mt-6 space-y-5 max-w-xl">
          {/* Kata Sandi Lama */}
          <div>
            <label className="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">
              Kata Sandi Saat Ini <span className="text-rose-500">*</span>
            </label>
            <div className="relative">
              <input
                type={showCurrent ? "text" : "password"}
                required
                value={currentPassword}
                onChange={(e) => setCurrentPassword(e.target.value)}
                placeholder="Masukkan kata sandi lama Anda"
                className="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all pr-11"
              />
              <button
                type="button"
                onClick={() => setShowCurrent(!showCurrent)}
                className="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer p-1"
              >
                {showCurrent ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
              </button>
            </div>
          </div>

          {/* Kata Sandi Baru */}
          <div>
            <label className="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">
              Kata Sandi Baru <span className="text-rose-500">*</span>
            </label>
            <div className="relative">
              <input
                type={showNew ? "text" : "password"}
                required
                minLength={6}
                value={newPassword}
                onChange={(e) => setNewPassword(e.target.value)}
                placeholder="Minimal 6 karakter"
                className="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all pr-11"
              />
              <button
                type="button"
                onClick={() => setShowNew(!showNew)}
                className="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer p-1"
              >
                {showNew ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
              </button>
            </div>
          </div>

          {/* Konfirmasi Kata Sandi Baru */}
          <div>
            <label className="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">
              Ulangi Kata Sandi Baru <span className="text-rose-500">*</span>
            </label>
            <div className="relative">
              <input
                type={showConfirm ? "text" : "password"}
                required
                minLength={6}
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.target.value)}
                placeholder="Ketik ulang kata sandi baru"
                className="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all pr-11"
              />
              <button
                type="button"
                onClick={() => setShowConfirm(!showConfirm)}
                className="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer p-1"
              >
                {showConfirm ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
              </button>
            </div>
          </div>

          <div className="pt-2">
            <button
              type="submit"
              disabled={loadingSelf}
              className="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
            >
              {loadingSelf ? (
                <>
                  <Loader2 className="w-4 h-4 animate-spin" />
                  <span>Menyimpan Perubahan...</span>
                </>
              ) : (
                <>
                  <KeyRound className="w-4 h-4" />
                  <span>Simpan Kata Sandi Baru</span>
                </>
              )}
            </button>
          </div>
        </form>
      </div>

      {/* Section 2: Admin Only - Manage & Reset Other Users' Passwords */}
      {isAdmin && (
        <div className="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
          <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-5 border-b border-slate-100">
            <div>
              <div className="flex items-center gap-2">
                <span className="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                  <Shield className="w-4 h-4" />
                </span>
                <h2 className="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">
                  Manajemen Akun & Reset Kata Sandi Pengurus
                </h2>
              </div>
              <p className="text-xs text-slate-500 mt-1">
                Sebagai Administrator, Anda dapat mereset kata sandi akun pengurus (Sekretaris, Bendahara, dll.) jika mereka lupa kata sandi.
              </p>
            </div>

            <span className="text-[11px] font-bold px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200/60 self-start">
              Khusus Administrator
            </span>
          </div>

          {/* Admin Feedback Alert */}
          {adminMessage && (
            <div
              className={`p-4 rounded-2xl flex items-start gap-3 text-xs leading-relaxed ${
                adminMessage.type === "success"
                  ? "bg-emerald-50 text-emerald-800 border border-emerald-200"
                  : "bg-rose-50 text-rose-800 border border-rose-200"
              }`}
            >
              {adminMessage.type === "success" ? (
                <CheckCircle2 className="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" />
              ) : (
                <AlertCircle className="w-4 h-4 text-rose-600 shrink-0 mt-0.5" />
              )}
              <span className="font-medium">{adminMessage.text}</span>
            </div>
          )}

          {/* Reset Modal / Form overlay if user selected */}
          {selectedUser && (
            <div className="p-5 rounded-2xl bg-amber-50/80 border border-amber-200 space-y-4">
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2">
                  <RefreshCw className="w-4 h-4 text-amber-700" />
                  <span className="font-bold text-xs text-amber-900">
                    Reset Kata Sandi Akun: <span className="underline font-mono">@{selectedUser.username}</span> ({selectedUser.name})
                  </span>
                </div>
                <button
                  type="button"
                  onClick={() => {
                    setSelectedUser(null);
                    setAdminNewPassword("");
                  }}
                  className="text-xs text-slate-500 hover:text-slate-800 font-semibold cursor-pointer"
                >
                  Batal
                </button>
              </div>

              <form onSubmit={handleAdminReset} className="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div className="relative flex-1">
                  <input
                    type="text"
                    required
                    minLength={6}
                    value={adminNewPassword}
                    onChange={(e) => setAdminNewPassword(e.target.value)}
                    placeholder={`Masukkan kata sandi baru untuk @${selectedUser.username}`}
                    className="w-full px-4 py-2.5 rounded-xl border border-amber-300 bg-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600"
                  />
                </div>

                <button
                  type="submit"
                  disabled={loadingAdmin}
                  className="px-5 py-2.5 rounded-xl bg-amber-700 hover:bg-amber-800 text-white font-bold text-xs shadow-xs transition-colors flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50 shrink-0"
                >
                  {loadingAdmin ? (
                    <>
                      <Loader2 className="w-3.5 h-3.5 animate-spin" />
                      <span>Menyimpan...</span>
                    </>
                  ) : (
                    <>
                      <KeyRound className="w-3.5 h-3.5" />
                      <span>Setel Kata Sandi Baru</span>
                    </>
                  )}
                </button>
              </form>
            </div>
          )}

          {/* User Accounts Table */}
          <div className="overflow-x-auto">
            <table className="w-full text-xs text-left">
              <thead>
                <tr className="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-wider">
                  <th className="py-3 px-3">Nama & Username</th>
                  <th className="py-3 px-3">Role / Jabatan</th>
                  <th className="py-3 px-3">Email</th>
                  <th className="py-3 px-3">Login Terakhir</th>
                  <th className="py-3 px-3 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100">
                {usersList.map((u) => {
                  const roleDef = ROLE_DEFINITIONS[u.role as AdminRole] || {
                    label: u.role,
                    badgeColor: "bg-slate-100 text-slate-700",
                  };

                  return (
                    <tr key={u.id} className="hover:bg-slate-50 transition-colors">
                      <td className="py-3.5 px-3">
                        <div className="flex items-center gap-2.5">
                          <div className="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0">
                            {u.name.substring(0, 2).toUpperCase()}
                          </div>
                          <div>
                            <span className="font-bold text-slate-900 block leading-tight">
                              {u.name}
                            </span>
                            <span className="text-[10px] text-slate-400 font-mono">
                              @{u.username}
                            </span>
                          </div>
                        </div>
                      </td>

                      <td className="py-3.5 px-3">
                        <span className={`text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md border ${roleDef.badgeColor}`}>
                          {roleDef.label}
                        </span>
                      </td>

                      <td className="py-3.5 px-3 text-slate-600 font-mono text-[11px]">
                        {u.email}
                      </td>

                      <td className="py-3.5 px-3 text-slate-500 font-mono text-[11px]">
                        {u.last_login || "Belum pernah"}
                      </td>

                      <td className="py-3.5 px-3 text-right">
                        <button
                          type="button"
                          onClick={() => {
                            setSelectedUser(u);
                            setAdminNewPassword("");
                            setAdminMessage(null);
                          }}
                          className="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 text-slate-700 font-semibold text-xs transition-colors inline-flex items-center gap-1.5 cursor-pointer border border-slate-200/60"
                        >
                          <KeyRound className="w-3 h-3 text-emerald-600" />
                          <span>Reset Sandi</span>
                        </button>
                      </td>
                    </tr>
                  );
                })}
              </tbody>
            </table>
          </div>
        </div>
      )}
    </div>
  );
}
