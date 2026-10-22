import { redirect } from "next/navigation";
import { Calendar } from "lucide-react";
import EventsManager from "@/components/admin/EventsManager";
import { getCurrentUser } from "@/lib/auth";
import { canAccess } from "@/lib/permissions";
import { getEvents } from "@/lib/data";

export default async function AdminEventsPage() {
  const user = await getCurrentUser();
  if (!user) {
    redirect("/admin/login");
  }

  if (!canAccess(user.role, "/admin/events")) {
    redirect("/admin");
  }

  const events = await getEvents();

  return (
    <div className="space-y-6">
      <div className="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
          <span className="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">
            Agenda
          </span>
          <h1 className="text-2xl font-extrabold text-gray-900 mt-2 flex items-center gap-2">
            <Calendar className="w-6 h-6 text-emerald-600" />
            <span>Kelola Kegiatan & Pengajian</span>
          </h1>
          <p className="text-xs text-gray-500 mt-1">
            Tambah, jadwalkan, dan kelola kegiatan ibadah serta pengajian warga
          </p>
        </div>
      </div>

      <EventsManager initialEvents={events} />
    </div>
  );
}
