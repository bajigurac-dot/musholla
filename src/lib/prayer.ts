export interface PrayerTimes {
  date: string;
  hijri: string;
  imsak: string;
  subuh: string;
  terbit: string;
  dzuhur: string;
  ashar: string;
  maghrib: string;
  isya: string;
}

// Fallback prayer times for Tangerang
export const fallbackPrayerTimes: PrayerTimes = {
  date: new Date().toISOString().split("T")[0],
  hijri: "Rabiul Akhir 1448 H",
  imsak: "04:12",
  subuh: "04:22",
  terbit: "05:38",
  dzuhur: "11:47",
  ashar: "14:56",
  maghrib: "17:53",
  isya: "19:04",
};

// In-memory cache to prevent redundant external API hits
let prayerCache: { key: string; data: PrayerTimes } | null = null;

export async function getPrayerTimes(dateStr?: string): Promise<PrayerTimes> {
  const targetDate = dateStr ? new Date(dateStr) : new Date();
  const day = targetDate.getDate();
  const month = targetDate.getMonth() + 1;
  const year = targetDate.getFullYear();
  const dateKey = `${year}-${String(month).padStart(2, "0")}-${String(day).padStart(2, "0")}`;

  if (prayerCache && prayerCache.key === dateKey) {
    return prayerCache.data;
  }

  try {
    // Aladhan API for Tangerang with 2.5s timeout
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 2500);

    const res = await fetch(
      `https://api.aladhan.com/v1/timings/${day}-${month}-${year}?latitude=-6.1783&longitude=106.6319&method=20`,
      {
        next: { revalidate: 3600 },
        signal: controller.signal,
      }
    );
    clearTimeout(timeoutId);

    if (res.ok) {
      const data = await res.json();
      const t = data.data.timings;
      const h = data.data.date.hijri;
      const result: PrayerTimes = {
        date: dateKey,
        hijri: `${h.day} ${h.month.en} ${h.year} H`,
        imsak: t.Imsak?.substring(0, 5) || fallbackPrayerTimes.imsak,
        subuh: t.Fajr?.substring(0, 5) || fallbackPrayerTimes.subuh,
        terbit: t.Sunrise?.substring(0, 5) || fallbackPrayerTimes.terbit,
        dzuhur: t.Dhuhr?.substring(0, 5) || fallbackPrayerTimes.dzuhur,
        ashar: t.Asr?.substring(0, 5) || fallbackPrayerTimes.ashar,
        maghrib: t.Maghrib?.substring(0, 5) || fallbackPrayerTimes.maghrib,
        isya: t.Isha?.substring(0, 5) || fallbackPrayerTimes.isya,
      };
      prayerCache = { key: dateKey, data: result };
      return result;
    }
  } catch {
    // Silently fall back without delaying request
  }

  const fallback: PrayerTimes = { ...fallbackPrayerTimes, date: dateKey };
  prayerCache = { key: dateKey, data: fallback };
  return fallback;
}
