"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { useState, useEffect } from "react";
import { SettingsMap, defaultSettings } from "@/types";

interface NavbarProps {
  musholaName?: string;
  settings?: SettingsMap;
}

export default function Navbar({
  musholaName = "Musholla Ar-rahman",
  settings = defaultSettings,
}: NavbarProps) {
  const pathname = usePathname();
  const [isNavCollapsed, setIsNavCollapsed] = useState(true);
  const [timeStr, setTimeStr] = useState("");

  useEffect(() => {
    const updateTime = () => {
      const now = new Date();
      const h = String(now.getHours()).padStart(2, "0");
      const m = String(now.getMinutes()).padStart(2, "0");
      const s = String(now.getSeconds()).padStart(2, "0");
      setTimeStr(`${h}:${m}:${s} WIB`);
    };
    const timer = setTimeout(updateTime, 0);
    const interval = setInterval(updateTime, 1000);
    return () => {
      clearTimeout(timer);
      clearInterval(interval);
    };
  }, []);

  // If in admin area, don't show public navbar
  if (pathname.startsWith("/admin")) {
    return null;
  }

  const phone1 = settings.phone_1 || "0813-8619-8079";
  const address = settings.address || defaultSettings.address;
  const mapsUrl = settings.maps_url || defaultSettings.maps_url;
  const phone1Clean = phone1.replace(/[^0-9]/g, "").replace(/^0/, "");

  const navLinks = [
    { href: "/", label: "Beranda" },
    { href: "/profil", label: "Profil" },
    { href: "/kegiatan", label: "Kegiatan" },
    { href: "/berita", label: "Berita" },
    { href: "/galeri", label: "Galeri" },
    { href: "/keuangan", label: "Laporan Kas" },
    { href: "/kontak", label: "Kontak" },
  ];

  return (
    <>
      {/* Topbar Informasi */}
      <div className="topbar d-none d-md-block">
        <div className="container">
          <div className="d-flex justify-content-between align-items-center">
            <div className="d-flex align-items-center gap-4">
              <span>
                <i className="bi bi-geo-alt-fill text-warning me-1"></i>{" "}
                {address.length > 58 ? `${address.substring(0, 58)}...` : address}
              </span>
              <span>
                <i className="bi bi-clock-fill text-warning me-1"></i>{" "}
                <span id="live-clock">{timeStr || "--:--:-- WIB"}</span>
              </span>
            </div>
            <div className="d-flex align-items-center gap-3">
              <a
                href={`https://wa.me/62${phone1Clean}`}
                target="_blank"
                rel="noopener noreferrer"
              >
                <i className="bi bi-whatsapp text-success me-1"></i> {phone1}
              </a>
              <span className="text-white-50">|</span>
              <a href={mapsUrl} target="_blank" rel="noopener noreferrer">
                <i className="bi bi-pin-map text-warning me-1"></i> Peta Lokasi
              </a>
            </div>
          </div>
        </div>
      </div>

      {/* Navbar Utama */}
      <nav className="navbar navbar-expand-lg navbar-custom sticky-top">
        <div className="container">
          <Link href="/" className="navbar-brand navbar-brand-wrapper">
            <img
              src="/assets/images/default-logo.svg"
              alt={`Logo ${musholaName}`}
              className="navbar-brand-logo"
            />
            <div className="navbar-brand-text">
              <h1>{musholaName}</h1>
              <p>Gembor • Periuk • Kota Tangerang</p>
            </div>
          </Link>

          <button
            className="navbar-toggler border-0 shadow-none"
            type="button"
            onClick={() => setIsNavCollapsed(!isNavCollapsed)}
            aria-label="Toggle navigation"
          >
            <i className="bi bi-list fs-1 text-success"></i>
          </button>

          <div
            className={`collapse navbar-collapse ${isNavCollapsed ? "" : "show"}`}
            style={{ visibility: "visible" }}
          >
            <ul className="navbar-nav ms-auto align-items-lg-center gap-1 mb-2 mb-lg-0">
              {navLinks.map((link) => {
                const isActive =
                  link.href === "/"
                    ? pathname === "/"
                    : pathname.startsWith(link.href);
                return (
                  <li key={link.href} className="nav-item">
                    <Link
                      href={link.href}
                      onClick={() => setIsNavCollapsed(true)}
                      className={`nav-link ${isActive ? "active" : ""}`}
                    >
                      {link.label}
                    </Link>
                  </li>
                );
              })}
              <li className="nav-item ms-lg-2 mt-2 mt-lg-0">
                <Link
                  href="/keuangan#donasi"
                  onClick={() => setIsNavCollapsed(true)}
                  className="btn btn-gold btn-sm px-3 rounded-pill fw-bold text-nowrap d-inline-flex align-items-center gap-1"
                >
                  <i className="bi bi-heart-fill text-danger me-1"></i> Infaq & Donasi
                </Link>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </>
  );
}
