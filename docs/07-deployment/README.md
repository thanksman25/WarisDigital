# 🚀 07 — Deployment Guide

## Overview

```
GitHub Repo
    │
    │  git push origin main
    ▼
Railway (auto-detect Laravel)
    │  composer install
    │  npm run build
    │  php artisan migrate
    ▼
App live di: https://warisdigital.up.railway.app
```

Satu deployment = FE + BE sekaligus. Tidak ada hosting terpisah.

---

## Langkah Setup Railway

### 1. Buat project di Railway
1. Buka [railway.app](https://railway.app) → New Project
2. "Deploy from GitHub" → pilih repo `warisdigital`
3. Railway otomatis deteksi Laravel

### 2. Set Environment Variables di Railway

Masuk ke: Project → Variables → Add Variables

```env
APP_NAME=WarisDigital
APP_ENV=production
APP_KEY=                    # ← generate: php artisan key:generate --show
APP_DEBUG=false
APP_URL=https://your-domain.up.railway.app

DB_CONNECTION=pgsql
DB_HOST=db.xxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=xxxx
DB_SSLMODE=require

SUPABASE_URL=https://xxxx.supabase.co
SUPABASE_ANON_KEY=xxxx
SUPABASE_SERVICE_ROLE_KEY=xxxx
SUPABASE_STORAGE_BUCKET=warisdigital-documents

QUEUE_CONNECTION=database
SESSION_DRIVER=database
CACHE_STORE=database

MAIL_MAILER=smtp
# ... isi sesuai provider email (Resend/Mailgun untuk production)
```

### 3. Setup Nixpacks (Railway build config)

Buat file `nixpacks.toml` di root project:

```toml
[phases.setup]
nixPkgs = ["php82", "php82Extensions.pdo_pgsql", "php82Extensions.mbstring",
           "php82Extensions.xml", "php82Extensions.curl", "php82Extensions.zip",
           "nodejs_20", "nodePackages.npm"]

[phases.install]
cmds = ["composer install --no-dev --optimize-autoloader", "npm ci"]

[phases.build]
cmds = ["npm run build", "php artisan config:cache", "php artisan route:cache", "php artisan view:cache"]

[start]
cmd = "php artisan serve --host=0.0.0.0 --port=$PORT"
```

### 4. Setup Supabase Storage Bucket

Di Supabase Dashboard:
1. Storage → Create bucket: `warisdigital-documents`
2. Set bucket ke **private** (bukan public)
3. RLS policies: hanya service role yang bisa akses

### 5. Jalankan Migrasi (pertama kali)

Di Railway → Deployments → Terminal:
```bash
php artisan migrate --seed
```

### 6. Setup Scheduler (Queue Worker)

Railway mendukung cron job. Buat service kedua di project yang sama:

```bash
# Command untuk queue worker
php artisan queue:work --sleep=3 --tries=3

# Command untuk scheduler (di cron, setiap menit)
php artisan schedule:run
```

---

## Domain Custom

1. Railway → Settings → Domains → Add Custom Domain
2. Tambahkan CNAME record di DNS provider:
   ```
   CNAME  app  →  your-app.up.railway.app
   ```
3. Railway otomatis provision SSL (Let's Encrypt)

---

## Local Development

```bash
# Start semua service sekaligus
php artisan serve &
npm run dev &
php artisan queue:work &

# Atau pakai Herd (Mac) / Laravel Sail (Docker)
```

---

## Checklist Sebelum Launch

- [ ] `APP_DEBUG=false` di production
- [ ] `APP_KEY` sudah di-generate dan disimpan
- [ ] Semua env variables sudah diset di Railway
- [ ] Supabase Storage bucket sudah private
- [ ] Migrasi sudah dijalankan
- [ ] Domain custom sudah terpasang SSL
- [ ] Test upload dokumen end-to-end
- [ ] Test email reminder (kirim test email)
- [ ] Test simulasi waris dengan berbagai kombinasi ahli waris
