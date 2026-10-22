import { redirect } from "next/navigation";
import { Wallet } from "lucide-react";
import FinanceManager from "@/components/admin/FinanceManager";
import { getCurrentUser } from "@/lib/auth";
import { canAccess } from "@/lib/permissions";
import { getFinancialReports, getFinancialSummary } from "@/lib/data";

export default async function AdminFinancePage() {
  const user = await getCurrentUser();
  if (!user) {
    redirect("/admin/login");
  }

  if (!canAccess(user.role, "/admin/finance")) {
    redirect("/admin");
  }

  const [reports, summary] = await Promise.all([
    getFinancialReports(),
    getFinancialSummary(),
  ]);

  return (
    <div className="space-y-6">
      <div className="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
          <span className="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">
            Keuangan
          </span>
          <h1 className="text-2xl font-extrabold text-gray-900 mt-2 flex items-center gap-2">
            <Wallet className="w-6 h-6 text-emerald-600" />
            <span>Laporan & Transparansi Kas Infaq</span>
          </h1>
          <p className="text-xs text-gray-500 mt-1">
            Catat pemasukan infaq dan pengeluaran operasional musholla
          </p>
        </div>
      </div>

      <FinanceManager initialReports={reports} initialSummary={summary} />
    </div>
  );
}
