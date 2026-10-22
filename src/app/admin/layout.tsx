import "./admin.css";
import { getCurrentUser } from "@/lib/auth";
import AdminSidebar from "@/components/admin/AdminSidebar";
import AdminTopHeader from "@/components/admin/AdminTopHeader";

export const dynamic = "force-dynamic";

export default async function AdminLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const user = await getCurrentUser();

  if (!user) {
    return <div className="admin-portal">{children}</div>;
  }

  return (
    <div className="admin-portal min-h-screen bg-[#F8FAFC] flex flex-col md:flex-row text-slate-800">
      {/* Sidebar Navigation */}
      <AdminSidebar user={user} />

      {/* Main Content Area */}
      <div className="flex-1 flex flex-col min-w-0">
        <AdminTopHeader user={user} />
        <main className="flex-1 p-5 sm:p-8 max-w-7xl w-full mx-auto">{children}</main>
      </div>
    </div>
  );
}
