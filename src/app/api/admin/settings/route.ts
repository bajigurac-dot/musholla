import { NextResponse } from "next/server";
import { getCurrentUser } from "@/lib/auth";
import { canAccess } from "@/lib/permissions";
import { getDb, ensureDatabaseReady } from "@/lib/db";

export async function POST(req: Request) {
  const user = await getCurrentUser();
  if (!user) {
    return NextResponse.json({ message: "Unauthorized" }, { status: 401 });
  }
  if (!canAccess(user.role, "/admin/settings")) {
    return NextResponse.json({ message: "Akses ditolak: hanya Administrator yang dapat mengubah pengaturan sistem." }, { status: 403 });
  }

  await ensureDatabaseReady();
  const db = getDb();
  const body = await req.json();

  try {
    for (const [key, value] of Object.entries(body)) {
      if (typeof value === "string") {
        await db.execute({
          sql: `
            INSERT INTO settings (setting_key, setting_value, updated_at)
            VALUES (?, ?, datetime('now', 'localtime'))
            ON CONFLICT(setting_key) DO UPDATE SET
              setting_value = excluded.setting_value,
              updated_at = datetime('now', 'localtime')
          `,
          args: [key, value],
        });
      }
    }

    return NextResponse.json({ success: true, message: "Pengaturan berhasil diperbarui." });
  } catch (error) {
    console.error("Error updating settings:", error);
    return NextResponse.json({ message: "Gagal menyimpan pengaturan." }, { status: 500 });
  }
}
