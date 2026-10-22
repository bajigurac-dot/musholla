import { redirect } from "next/navigation";
import { Newspaper } from "lucide-react";
import PostsManager from "@/components/admin/PostsManager";
import { getCurrentUser } from "@/lib/auth";
import { canAccess } from "@/lib/permissions";
import { getPosts } from "@/lib/data";

export default async function AdminPostsPage() {
  const user = await getCurrentUser();
  if (!user) {
    redirect("/admin/login");
  }

  if (!canAccess(user.role, "/admin/posts")) {
    redirect("/admin");
  }

  const posts = await getPosts();

  return (
    <div className="space-y-6">
      <div className="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
          <span className="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">
            Publikasi
          </span>
          <h1 className="text-2xl font-extrabold text-gray-900 mt-2 flex items-center gap-2">
            <Newspaper className="w-6 h-6 text-emerald-600" />
            <span>Kelola Berita & Pengumuman</span>
          </h1>
          <p className="text-xs text-gray-500 mt-1">
            Tambah, sunting, dan hapus berita kegiatan musholla untuk jamaah
          </p>
        </div>
      </div>

      <PostsManager initialPosts={posts} />
    </div>
  );
}
