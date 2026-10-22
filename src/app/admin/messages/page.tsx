import { redirect } from "next/navigation";
import { MessageSquare, Phone, Mail, Calendar } from "lucide-react";
import { getCurrentUser } from "@/lib/auth";
import { canAccess } from "@/lib/permissions";
import { getContactMessages } from "@/lib/data";

export default async function AdminMessagesPage() {
  const user = await getCurrentUser();
  if (!user) {
    redirect("/admin/login");
  }

  if (!canAccess(user.role, "/admin/messages")) {
    redirect("/admin");
  }

  const messages = await getContactMessages();

  return (
    <div className="space-y-6">
      <div className="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
          <span className="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">
            Aspirasi Warga
          </span>
          <h1 className="text-2xl font-extrabold text-gray-900 mt-2 flex items-center gap-2">
            <MessageSquare className="w-6 h-6 text-emerald-600" />
            <span>Pesan & Aspirasi Jamaah ({messages.length})</span>
          </h1>
          <p className="text-xs text-gray-500 mt-1">
            Daftar pesan dan usulan yang dikirimkan oleh warga melalui formulir kontak website
          </p>
        </div>
      </div>

      {messages.length === 0 ? (
        <div className="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm text-gray-400">
          Belum ada pesan yang masuk.
        </div>
      ) : (
        <div className="space-y-4">
          {messages.map((m) => (
            <div
              key={m.id}
              className="bg-white rounded-3xl p-6 border border-gray-100 shadow-xs hover:shadow-md transition-shadow space-y-3"
            >
              <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-3">
                <div>
                  <h3 className="font-bold text-gray-900 text-base">{m.name}</h3>
                  <div className="flex flex-wrap items-center gap-3 text-xs text-gray-500 mt-0.5">
                    <span className="flex items-center gap-1 font-mono">
                      <Phone className="w-3.5 h-3.5 text-emerald-600" />
                      <a
                        href={`https://wa.me/62${m.phone.replace(/[^0-9]/g, "").slice(1)}`}
                        target="_blank"
                        rel="noreferrer"
                        className="text-emerald-700 hover:underline"
                      >
                        {m.phone}
                      </a>
                    </span>
                    {m.email && (
                      <span className="flex items-center gap-1">
                        <Mail className="w-3.5 h-3.5 text-emerald-600" />
                        <a href={`mailto:${m.email}`} className="hover:underline">
                          {m.email}
                        </a>
                      </span>
                    )}
                  </div>
                </div>

                <div className="text-xs text-gray-400 flex items-center gap-1">
                  <Calendar className="w-3.5 h-3.5" />
                  <span>{m.created_at}</span>
                </div>
              </div>

              <div className="space-y-1">
                <span className="text-xs font-semibold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full inline-block">
                  Subjek: {m.subject}
                </span>
                <p className="text-sm text-gray-700 leading-relaxed whitespace-pre-line pt-1">
                  {m.message}
                </p>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}
