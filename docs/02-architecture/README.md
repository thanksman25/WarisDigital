# 🏗️ 02 — Arsitektur Sistem

## Stack Decision

| Layer | Teknologi | Alasan |
|---|---|---|
| Backend | Laravel 11 | Full-featured, ekosistem terbaik untuk PHP Indonesia |
| Frontend | Inertia.js + Vue 3 | Satu deployment, tidak butuh REST API terpisah |
| Database | Supabase (PostgreSQL) | Managed, gratis tier besar, built-in realtime |
| Storage | Supabase Storage | Terintegrasi langsung dengan DB, S3-compatible |
| Auth | Laravel Sanctum | Cookie-based, aman untuk SPA + Inertia |
| Styling | Tailwind CSS v3 | Utility-first, konsisten dengan design system |
| Queue | Laravel Queue (DB) | Tidak perlu Redis untuk MVP |
| Deploy | Railway | Support PHP, auto-deploy dari GitHub |

---

## Deployment Architecture

```
┌─────────────────────────────────────────────────────────┐
│                    USER (Browser)                       │
└───────────────────────┬─────────────────────────────────┘
                        │ HTTPS
┌───────────────────────▼─────────────────────────────────┐
│              Railway (1 Instance)                       │
│                                                         │
│  ┌─────────────────────────────────────────────────┐   │
│  │            Laravel 11 Application               │   │
│  │                                                 │   │
│  │  ┌─────────────┐    ┌──────────────────────┐   │   │
│  │  │  Inertia.js  │    │   Laravel Queue      │   │   │
│  │  │  + Vue 3     │    │   (Scheduler, Jobs)  │   │   │
│  │  └─────────────┘    └──────────────────────┘   │   │
│  └─────────────────────────────────────────────────┘   │
└──────────────┬─────────────────────┬───────────────────┘
               │                     │
       ┌───────▼──────┐    ┌─────────▼────────┐
       │   Supabase    │    │    Supabase       │
       │  (PostgreSQL) │    │    (Storage)      │
       │  - All tables │    │  - Documents      │
       │  - Sessions   │    │  - Capsule files  │
       └───────────────┘    └──────────────────┘
```

**Catatan penting:**
- Satu `git push` → Railway auto-build dan deploy semua (BE + FE sekaligus)
- Tidak ada CORS issue karena FE dan BE dalam 1 process
- Supabase hanya diakses dari server Laravel, tidak pernah dari browser langsung

---

## Request Lifecycle (Inertia.js)

```
Browser                    Laravel                      Vue
   │                          │                          │
   │──── GET /dashboard ──────►│                          │
   │                          │ Auth middleware check    │
   │                          │ DashboardController      │
   │                          │ return Inertia::render() │
   │◄─── HTML + JSON props ───│                          │
   │                          │                          │
   │──────────────────────────────────────── Mount Vue ──►│
   │                                                      │
   │                          │◄── Inertia AJAX (XHR) ───│
   │                          │ (navigasi antar halaman) │
   │                          │──── JSON props ──────────►│
   │                                         Update DOM  │
```

---

## Layer Arsitektur Internal

```
routes/web.php
    │
    ▼
Middleware (auth, role, plan_check)
    │
    ▼
Controller  ──► Request Validation (Form Request)
    │
    ▼
Service Layer  ──► Business logic, enkripsi, kalkulasi
    │
    ▼
Model (Eloquent)  ──► Supabase PostgreSQL
    │
    ▼
Inertia::render('PageName', $props)
    │
    ▼
Vue 3 Page Component (resources/js/Pages/...)
```

---

## Shared Data (Inertia)

Data yang tersedia di semua halaman via `usePage().props`:

```javascript
{
  auth: {
    user: { id, name, email, plan, plan_label, avatar }
  },
  badges: {
    documents_expiring: 2,   // dokumen expiring dalam 30 hari
    reminders_count: 3,      // unread reminders
  },
  flash: {
    success: "Dokumen berhasil diupload",
    error: null,
  }
}
```

Didefinisikan di `app/Http/Middleware/HandleInertiaRequests.php`.
