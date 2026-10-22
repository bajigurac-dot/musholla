import { NextResponse } from "next/server";
import { getCurrentUser } from "@/lib/auth";
import { canAccess } from "@/lib/permissions";
import { getDb, ensureDatabaseReady } from "@/lib/db";

// GET all galleries
export async function GET() {
  const user = await getCurrentUser();
  if (!user) return NextResponse.json({ message: "Unauthorized" }, { status: 401 });
  if (!canAccess(user.role, "/admin/gallery")) {
    return NextResponse.json({ message: "Akses ditolak untuk role ini." }, { status: 403 });
  }

  await ensureDatabaseReady();
  const db = getDb();
  const res = await db.execute("SELECT * FROM galleries ORDER BY id DESC");
  return NextResponse.json(res.rows);
}

// CREATE new gallery item
export async function POST(req: Request) {
  const user = await getCurrentUser();
  if (!user) return NextResponse.json({ message: "Unauthorized" }, { status: 401 });
  if (!canAccess(user.role, "/admin/gallery")) {
    return NextResponse.json({ message: "Akses ditolak untuk role ini." }, { status: 403 });
  }

  await ensureDatabaseReady();
  const db = getDb();
  const body = await req.json();
  const { title, image, category, description } = body;

  if (!title || !image) {
    return NextResponse.json({ message: "Judul dan URL gambar wajib diisi." }, { status: 400 });
  }

  try {
    await db.execute({
      sql: `INSERT INTO galleries (title, image, category, description) VALUES (?, ?, ?, ?)`,
      args: [title, image, category || "Kegiatan", description || null],
    });

    return NextResponse.json({ success: true, message: "Foto berhasil ditambahkan ke galeri." });
  } catch (error) {
    console.error("Error adding gallery item:", error);
    return NextResponse.json({ message: "Gagal menyimpan foto." }, { status: 500 });
  }
}

// DELETE gallery item
export async function DELETE(req: Request) {
  const user = await getCurrentUser();
  if (!user) return NextResponse.json({ message: "Unauthorized" }, { status: 401 });
  if (!canAccess(user.role, "/admin/gallery")) {
    return NextResponse.json({ message: "Akses ditolak untuk role ini." }, { status: 403 });
  }

  const { searchParams } = new URL(req.url);
  const id = searchParams.get("id");
  if (!id) return NextResponse.json({ message: "ID wajib disertakan." }, { status: 400 });

  await ensureDatabaseReady();
  const db = getDb();

  try {
    await db.execute({
      sql: "DELETE FROM galleries WHERE id = ?",
      args: [id],
    });
    return NextResponse.json({ success: true, message: "Foto berhasil dihapus dari galeri." });
  } catch (error) {
    console.error("Error deleting gallery item:", error);
    return NextResponse.json({ message: "Gagal menghapus foto." }, { status: 500 });
  }
}
