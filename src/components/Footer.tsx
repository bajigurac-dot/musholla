"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { SettingsMap, defaultSettings } from "@/types";

interface FooterProps {
  settings?: SettingsMap;
}

export default function Footer({ settings = defaultSettings }: FooterProps) {
  const pathname = usePathname();

  // If in admin area, don't show public footer
  if (pathname.startsWith("/admin")) {
    return null;
  }

  const musholaName = settings.mushola_name || defaultSettings.mushola_name;
  const address = settings.address || defaultSettings.address;
  const phone1 = settings.phone_1 || defaultSettings.phone_1;
  const phone2 = settings.phone_2 || defaultSettings.phone_2;
  const email = settings.email || "dkm.musholla.arrahman@gmail.com";
  const mapsUrl = settings.maps_url || defaultSettings.maps_url;
  const dkmLead = settings.dkm_lead || defaultSettings.dkm_lead;
  const dkmTreasurer = settings.dkm_treasurer || defaultSettings.dkm_treasurer;
  const dkmSecretary = settings.dkm_secretary || defaultSettings.dkm_secretary;
  const bankAccount = settings.donation_account || "0152632533100";
  const bankName = settings.donation_bank || "Bank BJB";

  const phone1Clean = phone1.replace(/[^0-9]/g, "").replace(/^0/, "");
  const phone2Clean = phone2.replace(/[^0-9]/g, "").replace(/^0/, "");

  return (
    <footer className="footer">
      <div className="container">
        <div className="row g-4">
          {/* Kolom 1: Profil Musholla */}
          <div className="col-lg-4 col-md-6">
            <div className="d-flex align-items-center gap-2 mb-3">
              <img
                src="/assets/images/default-logo.svg"
                alt="Logo"
                width={38}
                height={38}
              />
              <h5 className="m-0 text-white">{musholaName}</h5>
            </div>
            <p className="text-light-50 small mb-3">
              Berdiri sejak tahun 1990 atas gotong royong warga RT 007 RW 07 Kelurahan Gembor,
              Kecamatan Periuk, Kota Tangerang bersama pemerintah setempat sebagai pusat ibadah,
              ukhuwah islamiyah, dan pembinaan umat.
            </p>
            <div
              className="p-3 rounded-3"
              style={{
                background: "rgba(255, 255, 255, 0.05)",
                border: "1px solid rgba(255, 255, 255, 0.1)",
              }}
            >
              <small className="text-warning d-block fw-bold mb-1">
                <i className="bi bi-wallet2 me-1"></i> Rekening Donasi Resmi:
              </small>
              <div className="d-flex align-items-center justify-content-between">
                <div>
                  <span className="badge bg-light text-dark fw-bold me-1">{bankName}</span>
                  <span className="text-white fw-bold font-monospace">{bankAccount}</span>
                </div>
                <button
                  className="btn btn-sm btn-outline-light-custom btn-copy-account py-1 px-2"
                  data-account={bankAccount}
                  title="Salin No. Rekening"
                >
                  <i className="bi bi-clipboard"></i>
                </button>
              </div>
            </div>
          </div>

          {/* Kolom 2: Navigasi Cepat */}
          <div className="col-lg-2 col-md-6">
            <h5>Menu Utama</h5>
            <ul className="list-unstyled d-flex flex-column gap-2 small">
              <li>
                <Link href="/">
                  <i className="bi bi-chevron-right me-1 text-warning"></i> Beranda
                </Link>
              </li>
              <li>
                <Link href="/profil">
                  <i className="bi bi-chevron-right me-1 text-warning"></i> Profil & Sejarah
                </Link>
              </li>
              <li>
                <Link href="/kegiatan">
                  <i className="bi bi-chevron-right me-1 text-warning"></i> Agenda Kegiatan
                </Link>
              </li>
              <li>
                <Link href="/berita">
                  <i className="bi bi-chevron-right me-1 text-warning"></i> Berita & Info
                </Link>
              </li>
              <li>
                <Link href="/galeri">
                  <i className="bi bi-chevron-right me-1 text-warning"></i> Galeri Dokumentasi
                </Link>
              </li>
              <li>
                <Link href="/keuangan">
                  <i className="bi bi-chevron-right me-1 text-warning"></i> Infaq & Donasi
                </Link>
              </li>
              <li>
                <Link href="/kontak">
                  <i className="bi bi-chevron-right me-1 text-warning"></i> Hubungi Kami
                </Link>
              </li>
            </ul>
          </div>

          {/* Kolom 3: Susunan Pengurus DKM */}
          <div className="col-lg-3 col-md-6">
            <h5>Pengurus DKM</h5>
            <ul className="list-unstyled small d-flex flex-column gap-2">
              <li className="d-flex align-items-start gap-2">
                <i className="bi bi-person-check-fill text-warning mt-1"></i>
                <div>
                  <span className="text-white-50 d-block">Ketua DKM:</span>
                  <strong className="text-white">{dkmLead}</strong>
                </div>
              </li>
              <li className="d-flex align-items-start gap-2">
                <i className="bi bi-cash-stack text-warning mt-1"></i>
                <div>
                  <span className="text-white-50 d-block">Bendahara:</span>
                  <strong className="text-white">{dkmTreasurer}</strong>
                </div>
              </li>
              <li className="d-flex align-items-start gap-2">
                <i className="bi bi-pen-fill text-warning mt-1"></i>
                <div>
                  <span className="text-white-50 d-block">Sekretaris:</span>
                  <strong className="text-white">{dkmSecretary}</strong>
                </div>
              </li>
            </ul>
          </div>

          {/* Kolom 4: Alamat & Kontak */}
          <div className="col-lg-3 col-md-6">
            <h5>Alamat & Kontak</h5>
            <p className="small text-light-50 mb-3">
              <i className="bi bi-geo-alt-fill text-warning me-1"></i>
              {address}
            </p>
            <div className="d-flex flex-column gap-2 small mb-3">
              <a
                href={`https://wa.me/62${phone1Clean}`}
                target="_blank"
                rel="noopener noreferrer"
                className="d-inline-flex align-items-center gap-2"
              >
                <i className="bi bi-whatsapp text-success fs-6"></i> {phone1}
              </a>
              <a
                href={`https://wa.me/62${phone2Clean}`}
                target="_blank"
                rel="noopener noreferrer"
                className="d-inline-flex align-items-center gap-2"
              >
                <i className="bi bi-whatsapp text-success fs-6"></i> {phone2}
              </a>
              <a
                href={`mailto:${email}`}
                className="d-inline-flex align-items-center gap-2"
              >
                <i className="bi bi-envelope-fill text-warning fs-6"></i> {email}
              </a>
            </div>
            <a
              href={mapsUrl}
              target="_blank"
              rel="noopener noreferrer"
              className="btn btn-sm btn-outline-light-custom w-100"
            >
              <i className="bi bi-map-fill me-1"></i> Buka di Google Maps
            </a>
          </div>
        </div>

        <div className="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-4 pt-4 border-top border-white border-opacity-10">
          <div>
            &copy; 2026 <strong>{musholaName}</strong> Gembor Periuk Tangerang. Hak Cipta Dilindungi.
          </div>
          <div className="d-flex align-items-center gap-3">
            <Link href="/kontak" className="text-white-50">
              Privasi & Etika
            </Link>
            <span className="text-white-50">•</span>
            <Link href="/admin/login" className="text-warning">
              <i className="bi bi-shield-lock-fill me-1"></i> Area Pengurus
            </Link>
          </div>
        </div>
      </div>
    </footer>
  );
}
