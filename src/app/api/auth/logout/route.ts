import { NextResponse } from "next/server";
import { cookies } from "next/headers";

export async function POST(req: Request) {
  const cookieStore = await cookies();
  cookieStore.delete("mushola_admin_session");

  if (req.headers.get("accept")?.includes("application/json")) {
    return NextResponse.json({ success: true });
  }

  return NextResponse.redirect(new URL("/admin/login", req.url));
}

export async function GET(req: Request) {
  const cookieStore = await cookies();
  cookieStore.delete("mushola_admin_session");
  return NextResponse.redirect(new URL("/admin/login", req.url));
}
