"use client";

import { useState } from "react";
import { Plus, Trash2, X, CheckCircle2, PiggyBank, ArrowDownLeft, ArrowUpRight, Calendar } from "lucide-react";
import { FinanceReport } from "@/types";

interface FinanceManagerProps {
  initialReports: FinanceReport[];
  initialSummary: { totalIncome: number; totalExpense: number; balance: number };
}

export default function FinanceManager({ initialReports, initialSummary }: FinanceManagerProps) {
  const [reports, setReports] = useState<FinanceReport[]>(initialReports);
  const [summary, setSummary] = useState(initialSummary);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [loading, setLoading] = useState(false);
  const [msg, setMsg] = useState("");
  const [newReport, setNewReport] = useState({
    period_month: "10",
    period_year: "2026",
    income: "",
    expense: "",
    balance: "",
    description: "",
  });

  const monthNames = [
    "", "Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
  ];

  const handleDelete = async (id: number) => {
    if (!confirm("Hapus laporan kas periode ini?")) return;
    try {
      const res = await fetch(`/api/admin/finance?id=${id}`, { method: "DELETE" });
      if (res.ok) {
        const updated = reports.filter((r) => r.id !== id);
        setReports(updated);
        let inc = 0;
        let exp = 0;
        let bal = 0;
        if (updated.length > 0) {
          bal = Number(updated[0].balance);
          updated.forEach((r) => {
            inc += Number(r.income);
            exp += Number(r.expense);
          });
        }
        setSummary({ totalIncome: inc, totalExpense: exp, balance: bal });
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
      const res = await fetch("/api/admin/finance", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(newReport),
      });

      if (res.ok) {
        setMsg("Laporan kas bulanan berhasil dicatat!");
        setIsModalOpen(false);
        setNewReport({
          period_month: "10",
          period_year: "2026",
          income: "",
          expense: "",
          balance: "",
          description: "",
        });
        const updated = await fetch("/api/admin/finance").then((r) => r.json());
        setReports(updated);
        let inc = 0;
        let exp = 0;
        let bal = 0;
        if (updated.length > 0) {
          bal = Number(updated[0].balance);
          updated.forEach((r: FinanceReport) => {
            inc += Number(r.income);
            exp += Number(r.expense);
          });
        }
        setSummary({ totalIncome: inc, totalExpense: exp, balance: bal });
      } else {
        alert("Gagal menyimpan laporan kas.");
      }
    } catch {
      alert("Terjadi kesalahan.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="space-y-8">
      {msg && (
        <div className="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-xs">
          <CheckCircle2 className="w-5 h-5 text-emerald-600 shrink-0" />
          <span className="font-medium">{msg}</span>
        </div>
      )}

      {/* Summary Cards */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-5">
        {/* Card 1: Saldo Kas */}
        <div className="relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-[#075B4A] via-[#053E32] to-[#042820] text-white shadow-xl shadow-emerald-950/20 border border-emerald-600/30">
          <div className="absolute -right-6 -bottom-6 w-32 h-32 bg-emerald-400/15 rounded-full blur-2xl pointer-events-none" />
          
          <div className="flex items-center justify-between mb-4">
            <span className="text-xs uppercase font-bold tracking-wider text-emerald-200/90 flex items-center gap-1.5">
              <PiggyBank className="w-4 h-4 text-emerald-300" />
              Saldo Kas Aktif
            </span>
            <span className="text-[10px] font-bold uppercase tracking-wider bg-white/10 text-emerald-200 px-2.5 py-1 rounded-full border border-white/10">
              Kas Resmi DKM
            </span>
          </div>

          <div className="space-y-1">
            <div className="text-2xl sm:text-3xl font-extrabold font-mono tracking-tight text-white">
              Rp {summary.balance.toLocaleString("id-ID")}
            </div>
            <p className="text-[11px] text-emerald-300/80">
              Posisi saldo berjalan kas tunai & rekening BJB
            </p>
          </div>
        </div>

        {/* Card 2: Total Pemasukan */}
        <div className="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col justify-between space-y-4">
          <div className="flex items-center justify-between">
            <span className="text-xs uppercase font-bold tracking-wider text-slate-500">
              Total Pemasukan
            </span>
            <div className="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
              <ArrowDownLeft className="w-5 h-5" />
            </div>
          </div>
          <div>
            <div className="text-2xl font-extrabold font-mono tracking-tight text-emerald-600">
              + Rp {summary.totalIncome.toLocaleString("id-ID")}
            </div>
            <p className="text-[11px] text-slate-400 mt-1">
              Dari infaq Jumat, donasi warga, & transfer
            </p>
          </div>
        </div>

        {/* Card 3: Total Pengeluaran */}
        <div className="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col justify-between space-y-4">
          <div className="flex items-center justify-between">
            <span className="text-xs uppercase font-bold tracking-wider text-slate-500">
              Total Pengeluaran
            </span>
            <div className="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
              <ArrowUpRight className="w-5 h-5" />
            </div>
          </div>
          <div>
            <div className="text-2xl font-extrabold font-mono tracking-tight text-rose-600">
              - Rp {summary.totalExpense.toLocaleString("id-ID")}
            </div>
            <p className="text-[11px] text-slate-400 mt-1">
              Operasional rutin, listrik PLN, & perawatan
            </p>
          </div>
        </div>
      </div>

      {/* Action Header */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2">
        <div>
          <h2 className="text-xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
            <span>Rekapitulasi Kas Bulanan</span>
            <span className="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-2.5 py-0.5 rounded-full">
              {reports.length} Periode
            </span>
          </h2>
          <p className="text-xs text-slate-500 mt-0.5">
            Daftar pembukuan kas yang dipublikasikan secara transparan ke jamaah
          </p>
        </div>

        <button
          onClick={() => setIsModalOpen(true)}
          className="px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-xs sm:text-sm shadow-md shadow-emerald-600/25 flex items-center justify-center gap-2 transition-all cursor-pointer"
        >
          <Plus className="w-4 h-4" />
          <span>Tambah Laporan Kas Baru</span>
        </button>
      </div>

      {/* Table Card */}
      <div className="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-left text-sm">
            <thead className="bg-slate-50/80 border-b border-slate-100 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
              <tr>
                <th className="py-4 px-6">Periode</th>
                <th className="py-4 px-6">Rincian Keterangan</th>
                <th className="py-4 px-6 text-right">Pemasukan</th>
                <th className="py-4 px-6 text-right">Pengeluaran</th>
                <th className="py-4 px-6 text-right">Saldo Akhir</th>
                <th className="py-4 px-6 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100">
              {reports.map((row) => (
                <tr key={row.id} className="hover:bg-slate-50/60 transition-colors">
                  <td className="py-4 px-6 whitespace-nowrap">
                    <div className="flex items-center gap-2">
                      <div className="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                        <Calendar className="w-4 h-4" />
                      </div>
                      <span className="font-bold text-slate-900 text-sm">
                        {monthNames[row.period_month] || row.period_month} {row.period_year}
                      </span>
                    </div>
                  </td>
                  <td className="py-4 px-6 text-xs text-slate-600 max-w-sm leading-relaxed">
                    {row.description}
                  </td>
                  <td className="py-4 px-6 text-right font-mono font-bold text-emerald-600 whitespace-nowrap">
                    + Rp {Number(row.income).toLocaleString("id-ID")}
                  </td>
                  <td className="py-4 px-6 text-right font-mono font-bold text-rose-600 whitespace-nowrap">
                    - Rp {Number(row.expense).toLocaleString("id-ID")}
                  </td>
                  <td className="py-4 px-6 text-right font-mono font-bold text-slate-900 whitespace-nowrap text-sm">
                    Rp {Number(row.balance).toLocaleString("id-ID")}
                  </td>
                  <td className="py-4 px-6 text-center whitespace-nowrap">
                    <button
                      onClick={() => handleDelete(row.id)}
                      className="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer"
                      title="Hapus Laporan Periode Ini"
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


      {/* Modal Tambah Laporan Kas */}
      {isModalOpen && (
        <div className="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-gray-100">
              <h3 className="text-lg font-bold text-gray-900">Tambah Laporan Kas Bulanan</h3>
              <button
                onClick={() => setIsModalOpen(false)}
                className="p-1 rounded-lg text-gray-400 hover:text-gray-600"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            <form onSubmit={handleCreate} className="space-y-4">
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-xs font-semibold text-gray-700 mb-1">
                    Bulan Periode <span className="text-red-500">*</span>
                  </label>
                  <select
                    value={newReport.period_month}
                    onChange={(e) => setNewReport({ ...newReport, period_month: e.target.value })}
                    className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500 font-semibold"
                  >
                    {monthNames.map((m, idx) =>
                      idx === 0 ? null : (
                        <option key={idx} value={idx}>
                          {m}
                        </option>
                      )
                    )}
                  </select>
                </div>
                <div>
                  <label className="block text-xs font-semibold text-gray-700 mb-1">
                    Tahun <span className="text-red-500">*</span>
                  </label>
                  <input
                    type="number"
                    required
                    value={newReport.period_year}
                    onChange={(e) => setNewReport({ ...newReport, period_year: e.target.value })}
                    className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500"
                  />
                </div>
              </div>

              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-xs font-semibold text-gray-700 mb-1">
                    Pemasukan (Rp) <span className="text-red-500">*</span>
                  </label>
                  <input
                    type="number"
                    required
                    min={0}
                    value={newReport.income}
                    onChange={(e) => setNewReport({ ...newReport, income: e.target.value })}
                    placeholder="Contoh: 5000000"
                    className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-mono font-bold focus:ring-2 focus:ring-emerald-500"
                  />
                </div>
                <div>
                  <label className="block text-xs font-semibold text-gray-700 mb-1">
                    Pengeluaran (Rp) <span className="text-red-500">*</span>
                  </label>
                  <input
                    type="number"
                    required
                    min={0}
                    value={newReport.expense}
                    onChange={(e) => setNewReport({ ...newReport, expense: e.target.value })}
                    placeholder="Contoh: 3000000"
                    className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-mono font-bold focus:ring-2 focus:ring-emerald-500"
                  />
                </div>
              </div>

              <div>
                <label className="block text-xs font-semibold text-gray-700 mb-1">
                  Saldo Kas Akhir (Rp) (Opsional, otomatis dihitung)
                </label>
                <input
                  type="number"
                  value={newReport.balance}
                  onChange={(e) => setNewReport({ ...newReport, balance: e.target.value })}
                  placeholder="Kosongkan untuk otomatis (Pemasukan - Pengeluaran)"
                  className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-mono focus:ring-2 focus:ring-emerald-500"
                />
              </div>

              <div>
                <label className="block text-xs font-semibold text-gray-700 mb-1">
                  Keterangan & Rincian Penggunaan Kas
                </label>
                <textarea
                  rows={3}
                  value={newReport.description}
                  onChange={(e) => setNewReport({ ...newReport, description: e.target.value })}
                  placeholder="Rincian infaq Jumat, donasi, biaya listrik PLN, honor kebersihan, dan perawatan..."
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
                  {loading ? "Menyimpan..." : "Simpan Laporan Kas"}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}
