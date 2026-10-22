import type { Metadata } from "next";
import Script from "next/script";
import { Suspense } from "react";
import "./globals.css";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import { getSettings } from "@/lib/data";

export const metadata: Metadata = {
  title: {
    template: "%s | Musholla Ar-rahman Periuk Tangerang",
    default: "Website Resmi Musholla Ar-rahman Periuk Tangerang",
  },
  description:
    "Website resmi Musholla Ar-rahman RT 007 RW 07 Kelurahan Gembor Kecamatan Periuk Kota Tangerang. Informasi jadwal salat, agenda kegiatan, pengajian, berita, galeri, dan infaq donasi.",
  keywords: [
    "Musholla Ar-rahman",
    "Musholla Tangerang",
    "Musholla Periuk Gembor",
    "Jadwal Salat Tangerang",
    "DKM Ar-rahman",
    "Pengajian Rutin Tangerang",
    "Donasi Musholla",
  ],
  icons: {
    icon: "/assets/images/default-logo.svg",
  },
};

export default async function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const settings = await getSettings();

  return (
    <html lang="id">
      <head>
        {/* Preconnect for high-speed font and asset loading */}
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
        <link rel="preconnect" href="https://cdn.jsdelivr.net" crossOrigin="anonymous" />

        {/* Google Fonts: Plus Jakarta Sans & Amiri */}
        <link
          rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap"
        />

        {/* Bootstrap 5.3.3 CSS */}
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        />

        {/* Bootstrap Icons 1.11.3 */}
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        />

        {/* Custom Modern Islamic Design System */}
        <link rel="stylesheet" href="/assets/css/style.css?v=1.1" />
      </head>
      <body>
        <Suspense fallback={null}>
          <Navbar musholaName={settings.mushola_name} settings={settings} />
        </Suspense>

        <main>{children}</main>

        <Suspense fallback={null}>
          <Footer settings={settings} />
        </Suspense>

        {/* Bootstrap 5.3.3 JS Bundle */}
        <Script
          src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
          strategy="afterInteractive"
        />

        {/* Main interactive JS */}
        <Script src="/assets/js/main.js" strategy="afterInteractive" />
      </body>
    </html>
  );
}
