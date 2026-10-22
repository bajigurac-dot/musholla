import { createClient, Client } from "@libsql/client";
import path from "node:path";
import fs from "node:fs";

let dbInstance: Client | null = null;

export function getDb(): Client {
  if (dbInstance) {
    return dbInstance;
  }

  const tursoUrl = process.env.TURSO_DATABASE_URL;
  const tursoAuthToken = process.env.TURSO_AUTH_TOKEN;

  if (tursoUrl) {
    dbInstance = createClient({
      url: tursoUrl,
      authToken: tursoAuthToken,
    });
  } else {
    // Local SQLite fallback
    const dbPath = path.resolve(process.cwd(), "database", "mushola.sqlite");
    dbInstance = createClient({
      url: `file:${dbPath}`,
    });
  }

  return dbInstance;
}

let isDbReady = false;
let dbReadyPromise: Promise<void> | null = null;

// Auto migration & seed helper if tables are missing
export async function ensureDatabaseReady(): Promise<void> {
  if (isDbReady) return;
  if (dbReadyPromise) return dbReadyPromise;

  dbReadyPromise = (async () => {
    const db = getDb();
    try {
      const tableCheck = await db.execute(
        "SELECT name FROM sqlite_master WHERE type='table' AND name='settings'"
      );
      if (tableCheck.rows.length === 0) {
        console.log("Initializing database tables and seed data...");
      
      // Create tables
      await db.execute(`
        CREATE TABLE IF NOT EXISTS users (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          name TEXT NOT NULL,
          username TEXT NOT NULL UNIQUE,
          email TEXT NOT NULL UNIQUE,
          password_hash TEXT NOT NULL,
          role TEXT NOT NULL DEFAULT 'editor',
          is_active INTEGER DEFAULT 1,
          last_login TEXT NULL,
          created_at TEXT DEFAULT CURRENT_TIMESTAMP,
          updated_at TEXT DEFAULT CURRENT_TIMESTAMP
        );
      `);

      await db.execute(`
        CREATE TABLE IF NOT EXISTS settings (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          setting_key TEXT NOT NULL UNIQUE,
          setting_value TEXT NULL,
          description TEXT NULL,
          updated_at TEXT DEFAULT CURRENT_TIMESTAMP
        );
      `);

      await db.execute(`
        CREATE TABLE IF NOT EXISTS posts (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          title TEXT NOT NULL,
          slug TEXT NOT NULL UNIQUE,
          category TEXT NOT NULL DEFAULT 'Berita',
          excerpt TEXT NULL,
          content TEXT NOT NULL,
          image TEXT NULL,
          author TEXT DEFAULT 'Pengurus DKM',
          status TEXT NOT NULL DEFAULT 'Terbit',
          views INTEGER DEFAULT 0,
          created_at TEXT DEFAULT CURRENT_TIMESTAMP,
          updated_at TEXT DEFAULT CURRENT_TIMESTAMP
        );
      `);

      await db.execute(`
        CREATE TABLE IF NOT EXISTS events (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          title TEXT NOT NULL,
          slug TEXT NOT NULL UNIQUE,
          description TEXT NOT NULL,
          image TEXT NULL,
          event_date TEXT NOT NULL,
          start_time TEXT DEFAULT '18:00',
          end_time TEXT DEFAULT 'Selesai',
          location TEXT DEFAULT 'Musholla Ar-rahman',
          category TEXT DEFAULT 'Rutin',
          status TEXT NOT NULL DEFAULT 'Mendatang',
          created_at TEXT DEFAULT CURRENT_TIMESTAMP,
          updated_at TEXT DEFAULT CURRENT_TIMESTAMP
        );
      `);

      await db.execute(`
        CREATE TABLE IF NOT EXISTS galleries (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          title TEXT NOT NULL,
          image TEXT NOT NULL,
          category TEXT DEFAULT 'Kegiatan',
          description TEXT NULL,
          created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );
      `);

      await db.execute(`
        CREATE TABLE IF NOT EXISTS financial_reports (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          transaction_date TEXT NOT NULL,
          title TEXT NOT NULL,
          type TEXT NOT NULL,
          amount REAL NOT NULL,
          category TEXT NOT NULL,
          notes TEXT NULL,
          created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );
      `);

      await db.execute(`
        CREATE TABLE IF NOT EXISTS contact_messages (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          name TEXT NOT NULL,
          email TEXT NULL,
          phone TEXT NOT NULL,
          subject TEXT NOT NULL,
          message TEXT NOT NULL,
          is_read INTEGER DEFAULT 0,
          created_at TEXT DEFAULT CURRENT_TIMESTAMP
        );
      `);

      // Seed from data.json if available
      const jsonPath = path.resolve(process.cwd(), "database", "data.json");
      if (fs.existsSync(jsonPath)) {
        const raw = fs.readFileSync(jsonPath, "utf-8");
        const data = JSON.parse(raw);

        for (const [table, rows] of Object.entries(data)) {
          if (Array.isArray(rows)) {
            for (const row of rows as Record<string, unknown>[]) {
              const keys = Object.keys(row);
              const placeholders = keys.map(() => "?").join(", ");
              const values = Object.values(row);
              await db.execute({
                sql: `INSERT OR IGNORE INTO ${table} (${keys.join(", ")}) VALUES (${placeholders})`,
                args: values as (string | number | null)[],
              });
            }
          }
        }
        console.log("Database seeded successfully from data.json!");
      }
    }
    isDbReady = true;
  } catch (error) {
    console.error("Database initialization error:", error);
  } finally {
    dbReadyPromise = null;
  }
})();

  return dbReadyPromise;
}
