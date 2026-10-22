"use client";

import { useEffect, useState } from "react";
import { PrayerTimes } from "@/lib/prayer";

interface PrayerBannerProps {
  initialTimes?: PrayerTimes;
}

export default function PrayerBanner({ initialTimes }: PrayerBannerProps) {
  const [times] = useState<PrayerTimes>(
    initialTimes || {
      date: "2026-10-19",
      hijri: "Rabiul Akhir 1448 H",
      imsak: "04:12",
      subuh: "04:22",
      terbit: "05:38",
      dzuhur: "11:47",
      ashar: "14:56",
      maghrib: "17:53",
      isya: "19:04",
    }
  );

  const [activeName, setActiveName] = useState<string>("Isya");
  const [dateDisplay, setDateDisplay] = useState<string>("Senin, 19 Oktober 2026");

  useEffect(() => {
    const timer = setTimeout(() => {
      // Format Indonesian date
      const now = new Date();
      const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
      const months = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
      ];
      const dayName = days[now.getDay()];
      const dateNum = now.getDate();
      const monthName = months[now.getMonth()];
      const year = now.getFullYear();
      setDateDisplay(`${dayName}, ${dateNum} ${monthName} ${year}`);

      // Calculate active next prayer
      const currentMinutes = now.getHours() * 60 + now.getMinutes();
      const schedule = [
        { name: "Subuh", time: times.subuh },
        { name: "Terbit", time: times.terbit },
        { name: "Dzuhur", time: times.dzuhur },
        { name: "Ashar", time: times.ashar },
        { name: "Maghrib", time: times.maghrib },
        { name: "Isya", time: times.isya },
      ];

      let found = null;
      for (const p of schedule) {
        const [h, m] = p.time.split(":").map(Number);
        if (h * 60 + m > currentMinutes) {
          found = p.name;
          break;
        }
      }
      setActiveName(found || "Isya");
    }, 0);

    return () => clearTimeout(timer);
  }, [times]);

  const prayerItems = [
    { name: "Subuh", time: times.subuh },
    { name: "Terbit", time: times.terbit },
    { name: "Dzuhur", time: times.dzuhur },
    { name: "Ashar", time: times.ashar },
    { name: "Maghrib", time: times.maghrib },
    { name: "Isya", time: times.isya },
  ];

  return (
    <div className="prayer-widget-wrapper">
      <div className="container">
        <div className="prayer-card">
          <div className="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
            <div className="d-flex align-items-center gap-2">
              <span className="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                <i className="bi bi-clock-history me-1"></i> Jadwal Salat Hari Ini
              </span>
              <strong className="text-dark small">
                <i className="bi bi-geo-alt-fill text-danger me-1"></i> Kota Tangerang
              </strong>
            </div>
            <div className="small text-muted">
              <i className="bi bi-calendar-event me-1"></i> {dateDisplay}
              <span className="badge bg-light text-secondary border ms-1">
                Kemenag RI / Aladhan API
              </span>
            </div>
          </div>

          <div className="row g-2 g-md-3">
            {prayerItems.map((p) => {
              const isActive = p.name === activeName;
              return (
                <div key={p.name} className="col-4 col-md-2">
                  <div
                    className={`prayer-item ${isActive ? "active" : ""}`}
                    data-time={p.time}
                  >
                    <div className="prayer-name">{p.name}</div>
                    <div className="prayer-time">{p.time}</div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </div>
    </div>
  );
}
