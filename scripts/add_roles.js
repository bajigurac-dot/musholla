const { createClient } = require('@libsql/client');
const path = require('path');
const bcrypt = require('bcryptjs');

const db = createClient({ url: 'file:' + path.resolve(__dirname, '..', 'database', 'mushola.sqlite') });

async function setup() {
  const sekHash = await bcrypt.hash('sekretaris123', 10);
  const benHash = await bcrypt.hash('bendahara123', 10);

  // Check if sekretaris exists
  const checkSek = await db.execute({
    sql: "SELECT id FROM users WHERE username = 'sekretaris'",
    args: []
  });
  if (checkSek.rows.length === 0) {
    await db.execute({
      sql: "INSERT INTO users (name, username, email, password_hash, role, is_active) VALUES (?, ?, ?, ?, ?, 1)",
      args: ['Sekretaris DKM', 'sekretaris', 'sekretaris@musholla-arrahman.id', sekHash, 'sekretaris']
    });
  } else {
    await db.execute({
      sql: "UPDATE users SET name=?, password_hash=?, role=? WHERE username='sekretaris'",
      args: ['Sekretaris DKM', sekHash, 'sekretaris']
    });
  }

  // Check if bendahara exists
  const checkBen = await db.execute({
    sql: "SELECT id FROM users WHERE username = 'bendahara'",
    args: []
  });
  if (checkBen.rows.length === 0) {
    await db.execute({
      sql: "INSERT INTO users (name, username, email, password_hash, role, is_active) VALUES (?, ?, ?, ?, ?, 1)",
      args: ['Bendahara DKM', 'bendahara', 'bendahara@musholla-arrahman.id', benHash, 'bendahara']
    });
  } else {
    await db.execute({
      sql: "UPDATE users SET name=?, password_hash=?, role=? WHERE username='bendahara'",
      args: ['Bendahara DKM', benHash, 'bendahara']
    });
  }

  const all = await db.execute('SELECT id, name, username, email, role FROM users');
  console.log('Updated users list:', all.rows);
}

setup().catch(console.error);
