import { NextResponse } from "next/server";
import { cookies } from "next/headers";
import { loginUser, createToken } from "@/lib/auth";

export async function POST(req: Request) {
  try {
    const { username, password } = await req.json();

    if (!username || !password) {
      return NextResponse.json(
        { message: "Username dan password wajib diisi." },
        { status: 400 }
      );
    }

    const user = await loginUser(username, password);

    if (!user) {
      return NextResponse.json(
        { message: "Username atau password salah." },
        { status: 401 }
      );
    }

    const token = createToken(user);
    const cookieStore = await cookies();

    cookieStore.set("mushola_admin_session", token, {
      httpOnly: true,
      secure: process.env.NODE_ENV === "production",
      path: "/",
      maxAge: 86400 * 7, // 7 days
      sameSite: "lax",
    });

    return NextResponse.json({ success: true, user });
  } catch (error: unknown) {
    console.error("Login API error:", error);
    const errMessage = error instanceof Error ? error.message : String(error);
    return NextResponse.json(
      { message: `Terjadi kesalahan internal pada server: ${errMessage}` },
      { status: 500 }
    );
  }
}
