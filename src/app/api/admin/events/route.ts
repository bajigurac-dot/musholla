import { NextResponse } from "next/server";
import { getCurrentUser } from "@/lib/auth";
import { canAccess } from "@/lib/permissions";
import { getDb, ensureDatabaseReady } from "@/lib/db";

export async function GET() {
  const user = await getCurrentUser();
  if (!user) return NextResponse.json({ message: "Unauthorized" }, { status: 401 });
  if (!canAccess(user.role, "/admin/events")) {
    return NextResponse.json({ message: "Akses ditolak untuk role ini." }, { status: 403 });
  }

  await ensureDatabaseReady();
  const db = getDb();
  const res = await db.execute("SELECT * FROM events ORDER BY event_date DESC");
  return NextResponse.json(res.rows);
}

export async function POST(req: Request) {
  const user = await getCurrentUser();
  if (!user) return NextResponse.json({ message: "Unauthorized" }, { status: 401 });
  if (!canAccess(user.role, "/admin/events")) {
    return NextResponse.json({ message: "Akses ditolak untuk role ini." }, { status: 403 });
  }

  await ensureDatabaseReady();
  const db = getDb();
  const body = await req.json();
  const { title, event_date, start_time, end_time, location, category, description, status } =
    body;

  if (!title || !event_date || !description) {
    return NextResponse.json(
      { message: "Judul, tanggal, dan deskripsi kegiatan wajib diisi." },
      { status: 400 }
    );
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
      sql: `INSERT INTO events (title, slug, description, event_date, start_time, end_time, location, category, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)`,
      args: [
        title,
        slug,
        description,
        event_date,
        start_time || "18:00",
        end_time || "Selesai",
        location || "Musholla Ar-rahman",
        category || "Rutin",
        status || "Mendatang",
      ],
    });

    return NextResponse.json({ success: true, message: "Kegiatan berhasil ditambahkan." });
  } catch (error) {
    console.error("Error creating event:", error);
    return NextResponse.json({ message: "Gagal menyimpan kegiatan." }, { status: 500 });
  }
}

export async function DELETE(req: Request) {
  const user = await getCurrentUser();
  if (!user) return NextResponse.json({ message: "Unauthorized" }, { status: 401 });
  if (!canAccess(user.role, "/admin/events")) {
    return NextResponse.json({ message: "Akses ditolak untuk role ini." }, { status: 403 });
  }

  const { searchParams } = new URL(req.url);
  const id = searchParams.get("id");
  if (!id) return NextResponse.json({ message: "ID wajib disertakan." }, { status: 400 });

  await ensureDatabaseReady();
  const db = getDb();

  try {
    await db.execute({
      sql: "DELETE FROM events WHERE id = ?",
      args: [id],
    });
    return NextResponse.json({ success: true, message: "Kegiatan berhasil dihapus." });
  } catch (error) {
    console.error("Error deleting event:", error);
    return NextResponse.json({ message: "Gagal menghapus kegiatan." }, { status: 500 });
  }
}
