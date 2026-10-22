import { NextResponse } from "next/server";
import { getCurrentUser } from "@/lib/auth";
import { canAccess } from "@/lib/permissions";
import { getDb, ensureDatabaseReady } from "@/lib/db";

// GET all posts
export async function GET() {
  const user = await getCurrentUser();
  if (!user) return NextResponse.json({ message: "Unauthorized" }, { status: 401 });
  if (!canAccess(user.role, "/admin/posts")) {
    return NextResponse.json({ message: "Akses ditolak untuk role ini." }, { status: 403 });
  }

  await ensureDatabaseReady();
  const db = getDb();
  const res = await db.execute("SELECT * FROM posts ORDER BY created_at DESC");
  return NextResponse.json(res.rows);
}

// CREATE new post
export async function POST(req: Request) {
  const user = await getCurrentUser();
  if (!user) return NextResponse.json({ message: "Unauthorized" }, { status: 401 });
  if (!canAccess(user.role, "/admin/posts")) {
    return NextResponse.json({ message: "Akses ditolak untuk role ini." }, { status: 403 });
  }

  await ensureDatabaseReady();
  const db = getDb();
  const body = await req.json();
  const { title, category, content, excerpt, image, status } = body;

  if (!title || !content) {
    return NextResponse.json({ message: "Judul dan konten wajib diisi." }, { status: 400 });
  }

  const slug =
    title
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, "-")
      .replace(/^-|-$/g, "") +
    "-" +
    Date.now().toString().slice(-4);

  try {
    await db.execute({
      sql: `INSERT INTO posts (title, slug, category, excerpt, content, image, author, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)`,
      args: [
        title,
        slug,
        category || "Berita",
        excerpt || content.substring(0, 150),
        content,
        image || "/images/hero-bg-collage.jpg",
        user.name,
        status || "Terbit",
      ],
    });

    return NextResponse.json({ success: true, message: "Berita berhasil diterbitkan." });
  } catch (error) {
    console.error("Error creating post:", error);
    return NextResponse.json({ message: "Gagal menyimpan berita." }, { status: 500 });
  }
}

// DELETE post
export async function DELETE(req: Request) {
  const user = await getCurrentUser();
  if (!user) return NextResponse.json({ message: "Unauthorized" }, { status: 401 });
  if (!canAccess(user.role, "/admin/posts")) {
    return NextResponse.json({ message: "Akses ditolak untuk role ini." }, { status: 403 });
  }

  const { searchParams } = new URL(req.url);
  const id = searchParams.get("id");
  if (!id) return NextResponse.json({ message: "ID wajib disertakan." }, { status: 400 });

  await ensureDatabaseReady();
  const db = getDb();

  try {
    await db.execute({
      sql: "DELETE FROM posts WHERE id = ?",
      args: [id],
    });
    return NextResponse.json({ success: true, message: "Berita berhasil dihapus." });
  } catch (error) {
    console.error("Error deleting post:", error);
    return NextResponse.json({ message: "Gagal menghapus berita." }, { status: 500 });
  }
}
