import { createClient, Client } from "@libsql/client";
import path from "node:path";
import fs from "node:fs";
import os from "node:os";
import fallbackSeedData from "./seedData.json";

let dbInstance: Client | null = null;

function getLocalDatabaseUrl(): string {
  const isServerless =
    !!process.env.VERCEL ||
    !!process.env.AWS_LAMBDA_FUNCTION_NAME ||
    process.env.NODE_ENV === "production";

  if (isServerless) {
    const tmpDbPath = path.join(os.tmpdir(), "mushola.sqlite");

    // Copy initial database from bundle if exists and not yet in /tmp
    if (!fs.existsSync(tmpDbPath)) {
      const sourceDb = path.resolve(process.cwd(), "database", "mushola.sqlite");
      if (fs.existsSync(sourceDb)) {
        try {
          fs.copyFileSync(sourceDb, tmpDbPath);
        } catch (e) {
          console.warn("Could not copy bundled sqlite to /tmp:", e);
        }
      }
    }
    return `file:${tmpDbPath}`;
  }

  const dbPath = path.resolve(process.cwd(), "database", "mushola.sqlite");
  return `file:${dbPath}`;
}

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
    // Local / Serverless SQLite fallback
    dbInstance = createClient({
      url: getLocalDatabaseUrl(),
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

        // Create tables matching actual schema
        await db.execute(`
          CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            username TEXT NOT NULL UNIQUE,
            email TEXT NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            role TEXT NOT NULL DEFAULT 'editor',
            is_active INTEGER NOT NULL DEFAULT 1,
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
            alt_text TEXT NULL,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
          );
        `);

        await db.execute(`
          CREATE TABLE IF NOT EXISTS financial_reports (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            period_month INTEGER NOT NULL,
            period_year INTEGER NOT NULL,
            income REAL NOT NULL DEFAULT 0.00,
            expense REAL NOT NULL DEFAULT 0.00,
            balance REAL NOT NULL DEFAULT 0.00,
            description TEXT NULL,
            status TEXT NOT NULL DEFAULT 'Terbit',
            created_at TEXT DEFAULT CURRENT_TIMESTAMP,
            updated_at TEXT DEFAULT CURRENT_TIMESTAMP
          );
        `);

        await db.execute(`
          CREATE TABLE IF NOT EXISTS contact_messages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            phone TEXT NULL,
            email TEXT NULL,
            subject TEXT NOT NULL,
            message TEXT NOT NULL,
            is_read INTEGER NOT NULL DEFAULT 0,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
          );
        `);

        // Seed from disk data.json or embedded fallback
        let data: Record<string, unknown[]> | null = null;
        const jsonPath = path.resolve(process.cwd(), "database", "data.json");
        if (fs.existsSync(jsonPath)) {
          try {
            const raw = fs.readFileSync(jsonPath, "utf-8");
            data = JSON.parse(raw);
          } catch (e) {
            console.warn("Failed reading data.json from disk, using fallback:", e);
          }
        }

        if (!data) {
          data = fallbackSeedData as unknown as Record<string, unknown[]>;
        }

        if (data) {
          for (const [table, rows] of Object.entries(data)) {
            if (Array.isArray(rows)) {
              for (const row of rows as Record<string, unknown>[]) {
                const keys = Object.keys(row);
                const placeholders = keys.map(() => "?").join(", ");
                const values = Object.values(row);
                try {
                  await db.execute({
                    sql: `INSERT OR IGNORE INTO ${table} (${keys.join(", ")}) VALUES (${placeholders})`,
                    args: values as (string | number | null)[],
                  });
                } catch (insertErr) {
                  console.warn(`Error seeding table ${table}:`, insertErr);
                }
              }
            }
          }
          console.log("Database seeded successfully!");
        }
      }

      // Ensure default super admin account exists
      try {
        const adminCheck = await db.execute("SELECT id FROM users WHERE username = 'admin' LIMIT 1");
        if (adminCheck.rows.length === 0) {
          await db.execute({
            sql: `INSERT INTO users (name, username, email, password_hash, role, is_active) 
                  VALUES (?, ?, ?, ?, ?, 1)`,
            args: [
              "Super Admin DKM",
              "admin",
              "dkm.musholla.arrahman@gmail.com",
              "$2y$10$v.xOKU/RRBlCOUyJ4gwwL.R734Xj/ZpStFdy9r8J8wSH.H6EpntHO",
              "super_admin",
            ],
          });
        }
      } catch (adminErr) {
        console.warn("Error ensuring default admin user:", adminErr);
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
