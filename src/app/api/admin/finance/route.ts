import { NextResponse } from "next/server";
import { getCurrentUser } from "@/lib/auth";
import { canAccess } from "@/lib/permissions";
import { getDb, ensureDatabaseReady } from "@/lib/db";

// GET transactions
export async function GET() {
  const user = await getCurrentUser();
  if (!user) return NextResponse.json({ message: "Unauthorized" }, { status: 401 });
  if (!canAccess(user.role, "/admin/finance")) {
    return NextResponse.json({ message: "Akses ditolak untuk role ini." }, { status: 403 });
  }

  await ensureDatabaseReady();
  const db = getDb();
  const res = await db.execute("SELECT * FROM financial_reports ORDER BY period_year DESC, period_month DESC");
  return NextResponse.json(res.rows);
}

// CREATE transaction
export async function POST(req: Request) {
  const user = await getCurrentUser();
  if (!user) return NextResponse.json({ message: "Unauthorized" }, { status: 401 });
  if (!canAccess(user.role, "/admin/finance")) {
    return NextResponse.json({ message: "Akses ditolak untuk role ini." }, { status: 403 });
  }

  await ensureDatabaseReady();
  const db = getDb();
  const body = await req.json();
  const { period_month, period_year, income, expense, balance, description } = body;

  if (!period_month || !period_year || income === undefined || expense === undefined) {
    return NextResponse.json({ message: "Bulan, tahun, pemasukan, dan pengeluaran wajib diisi." }, { status: 400 });
  }

  const inc = Number(income);
  const exp = Number(expense);
  const bal = balance !== undefined && balance !== "" ? Number(balance) : inc - exp;

  try {
    await db.execute({
      sql: `INSERT INTO financial_reports (period_month, period_year, income, expense, balance, description, status) VALUES (?, ?, ?, ?, ?, ?, 'Terbit')`,
      args: [
        Number(period_month),
        Number(period_year),
        inc,
        exp,
        bal,
        description || "Laporan Kas Bulanan",
      ],
    });

    return NextResponse.json({ success: true, message: "Laporan kas bulanan berhasil dicatat." });
  } catch (error) {
    console.error("Error creating financial report:", error);
    return NextResponse.json({ message: "Gagal mencatat laporan kas." }, { status: 500 });
  }
}

// DELETE transaction
export async function DELETE(req: Request) {
  const user = await getCurrentUser();
  if (!user) return NextResponse.json({ message: "Unauthorized" }, { status: 401 });
  if (!canAccess(user.role, "/admin/finance")) {
    return NextResponse.json({ message: "Akses ditolak untuk role ini." }, { status: 403 });
  }

  const { searchParams } = new URL(req.url);
  const id = searchParams.get("id");
  if (!id) return NextResponse.json({ message: "ID wajib disertakan." }, { status: 400 });

  await ensureDatabaseReady();
  const db = getDb();

  try {
    await db.execute({
      sql: "DELETE FROM financial_reports WHERE id = ?",
      args: [id],
    });
    return NextResponse.json({ success: true, message: "Laporan kas berhasil dihapus." });
  } catch (error) {
    console.error("Error deleting report:", error);
    return NextResponse.json({ message: "Gagal menghapus laporan kas." }, { status: 500 });
  }
}
