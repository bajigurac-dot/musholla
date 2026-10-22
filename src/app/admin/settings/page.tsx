import { redirect } from "next/navigation";
import { Settings } from "lucide-react";
import SettingsForm from "@/components/admin/SettingsForm";
import { getCurrentUser } from "@/lib/auth";
import { canAccess } from "@/lib/permissions";
import { getSettings } from "@/lib/data";

export default async function AdminSettingsPage() {
  const user = await getCurrentUser();
  if (!user) {
    redirect("/admin/login");
  }

  if (!canAccess(user.role, "/admin/settings")) {
    redirect("/admin");
  }

  const settings = await getSettings();

  return (
    <div className="space-y-6">
      <div className="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
          <span className="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">
            Pengaturan Sistem
          </span>
          <h1 className="text-2xl font-extrabold text-gray-900 mt-2 flex items-center gap-2">
            <Settings className="w-6 h-6 text-emerald-600" />
            <span>Pengaturan Identitas & Kontak Musholla</span>
          </h1>
          <p className="text-xs text-gray-500 mt-1">
            Ubah nama musholla, alamat, kontak WhatsApp, email resmi, rekening donasi, dan fasilitas
          </p>
        </div>
      </div>

      <SettingsForm initialSettings={settings} />
    </div>
  );
}
