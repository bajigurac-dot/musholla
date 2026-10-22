import { NextResponse } from "next/server";
import { saveContactMessage } from "@/lib/data";

export async function POST(req: Request) {
  try {
    const body = await req.json();
    const { name, email, phone, subject, message } = body;

    if (!name || !phone || !subject || !message) {
      return NextResponse.json(
        { message: "Semua kolom bertanda bintang wajib diisi." },
        { status: 400 }
      );
    }

    await saveContactMessage({
      name,
      email: email || undefined,
      phone,
      subject,
      message,
    });

    return NextResponse.json({ success: true, message: "Pesan berhasil disimpan." });
  } catch (error) {
    console.error("Error submitting contact message:", error);
    return NextResponse.json(
      { message: "Gagal menyimpan pesan ke database." },
      { status: 500 }
    );
  }
}
