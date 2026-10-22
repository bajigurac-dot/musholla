import { getDb, ensureDatabaseReady } from "./db";
import {
  SettingsMap,
  defaultSettings,
  Post,
  EventItem,
  GalleryItem,
  FinanceReport,
  ContactMessage,
} from "@/types";

export * from "@/types";

function toPlain<T>(data: unknown): T {
  return JSON.parse(JSON.stringify(data));
}

export async function getSettings(): Promise<SettingsMap> {
  await ensureDatabaseReady();
  const db = getDb();
  try {
    const res = await db.execute("SELECT setting_key, setting_value FROM settings");
    const map = { ...defaultSettings };
    for (const row of res.rows) {
      if (typeof row.setting_key === "string" && typeof row.setting_value === "string") {
        map[row.setting_key] = row.setting_value;
      }
    }
    return toPlain<SettingsMap>(map);
  } catch (error) {
    console.error("Error fetching settings:", error);
    return defaultSettings;
  }
}

export async function getPosts(limit?: number): Promise<Post[]> {
  await ensureDatabaseReady();
  const db = getDb();
  try {
    const sql = limit
      ? `SELECT * FROM posts WHERE status='Terbit' ORDER BY created_at DESC LIMIT ${limit}`
      : "SELECT * FROM posts WHERE status='Terbit' ORDER BY created_at DESC";
    const res = await db.execute(sql);
    return toPlain<Post[]>(res.rows);
  } catch (error) {
    console.error("Error fetching posts:", error);
    return [];
  }
}

export async function getPostBySlug(slug: string): Promise<Post | null> {
  await ensureDatabaseReady();
  const db = getDb();
  try {
    const res = await db.execute({
      sql: "SELECT * FROM posts WHERE slug = ? LIMIT 1",
      args: [slug],
    });
    if (res.rows.length === 0) return null;
    return toPlain<Post>(res.rows[0]);
  } catch (error) {
    console.error("Error fetching post by slug:", error);
    return null;
  }
}

export async function getEvents(limit?: number): Promise<EventItem[]> {
  await ensureDatabaseReady();
  const db = getDb();
  try {
    const sql = limit
      ? `SELECT * FROM events ORDER BY event_date ASC LIMIT ${limit}`
      : "SELECT * FROM events ORDER BY event_date ASC";
    const res = await db.execute(sql);
    return toPlain<EventItem[]>(res.rows);
  } catch (error) {
    console.error("Error fetching events:", error);
    return [];
  }
}

export async function getEventBySlug(slug: string): Promise<EventItem | null> {
  await ensureDatabaseReady();
  const db = getDb();
  try {
    const res = await db.execute({
      sql: "SELECT * FROM events WHERE slug = ? LIMIT 1",
      args: [slug],
    });
    if (res.rows.length === 0) return null;
    return toPlain<EventItem>(res.rows[0]);
  } catch (error) {
    console.error("Error fetching event by slug:", error);
    return null;
  }
}

export async function getGalleries(): Promise<GalleryItem[]> {
  await ensureDatabaseReady();
  const db = getDb();
  try {
    const res = await db.execute("SELECT * FROM galleries ORDER BY id ASC");
    return toPlain<GalleryItem[]>(res.rows);
  } catch (error) {
    console.error("Error fetching galleries:", error);
    return [];
  }
}

export async function getFinancialReports(): Promise<FinanceReport[]> {
  await ensureDatabaseReady();
  const db = getDb();
  try {
    const res = await db.execute(
      "SELECT * FROM financial_reports ORDER BY period_year DESC, period_month DESC"
    );
    return toPlain<FinanceReport[]>(res.rows);
  } catch (error) {
    console.error("Error fetching finance:", error);
    return [];
  }
}

export async function getFinancialSummary() {
  const reports = await getFinancialReports();
  let totalIncome = 0;
  let totalExpense = 0;
  let balance = 0;

  if (reports.length > 0) {
    // Current active balance from the most recent period
    balance = Number(reports[0].balance);
    for (const r of reports) {
      totalIncome += Number(r.income);
      totalExpense += Number(r.expense);
    }
  }

  return {
    totalIncome,
    totalExpense,
    balance,
  };
}

export async function getContactMessages(): Promise<ContactMessage[]> {
  await ensureDatabaseReady();
  const db = getDb();
  try {
    const res = await db.execute("SELECT * FROM contact_messages ORDER BY created_at DESC");
    return toPlain<ContactMessage[]>(res.rows);
  } catch (error) {
    console.error("Error fetching messages:", error);
    return [];
  }
}

export async function saveContactMessage(data: {
  name: string;
  email?: string;
  phone: string;
  subject: string;
  message: string;
}) {
  await ensureDatabaseReady();
  const db = getDb();
  return await db.execute({
    sql: `INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)`,
    args: [data.name, data.email || null, data.phone, data.subject, data.message],
  });
}
