---
name: warisdigital-agent
description: >
  Panduan kerja lengkap untuk AI agent yang bekerja pada proyek WarisDigital —
  platform brankas digital keluarga Indonesia berbasis Laravel 11 + Inertia.js + Vue 3 + Supabase.
  Gunakan skill ini SETIAP KALI ada permintaan yang berhubungan dengan:
  coding fitur baru, membuat migration, membuat controller, membuat Vue page/component,
  menulis query Eloquent, mengatur route, mengintegrasikan Supabase Storage,
  debugging error Laravel/Vue/Inertia, menulis test, atau mendiskusikan arsitektur proyek.
  Jangan pernah menulis kode untuk proyek ini tanpa membaca skill ini terlebih dahulu.
---

# WarisDigital — AI Agent SKILL.md

Kamu adalah AI agent yang bekerja penuh pada proyek **WarisDigital**, sebuah platform web
brankas digital keluarga Indonesia. Dokumen ini adalah sumber kebenaran tunggal (single source
of truth) untuk semua keputusan teknis, konvensi kode, batasan, dan aturan kerja.

**Baca seluruh SKILL.md ini sebelum menulis satu baris kode pun.**

---

## 1. RINGKASAN PROYEK

### Apa itu WarisDigital?
Platform web yang membantu keluarga Indonesia menyimpan, mengatur, dan mewariskan
dokumen dan aset secara digital. Tagline: *"Brankas digital keluarga Indonesia."*

### Masalah yang Dipecahkan
- 60% keluarga Indonesia tidak punya catatan aset terpusat
- Sengketa waris masuk top-3 perkara perdata nasional
- Ribuan rekening "tidur" triliunan rupiah tidak diklaim ahli waris
- Proses balik nama aset almarhum rata-rata 6–24 bulan

### Stack Teknologi (TIDAK BOLEH DIGANTI TANPA PERSETUJUAN EKSPLISIT)
| Layer | Teknologi | Versi |
|---|---|---|
| Backend | Laravel | 11.x |
| Frontend | Inertia.js + Vue 3 | Inertia ^1.0, Vue ^3.4 |
| Database | Supabase (PostgreSQL) | PostgreSQL 15 |
| Storage | Supabase Storage | — |
| Auth | Laravel Sanctum | ^4.0 |
| Styling | Tailwind CSS | ^3.4 |
| Build | Vite | ^5.0 |
| Queue | Laravel Queue (database driver) | — |
| Deploy | Railway | — |

> ⚠️ **LARANGAN KERAS**: Jangan pernah menyarankan atau menambahkan Redis, React, Next.js,
> Livewire, Alpine.js, Bootstrap, atau framework/library lain yang tidak ada di daftar ini
> tanpa diskusi eksplisit dengan tim terlebih dahulu.

---

## 2. ARSITEKTUR & STRUKTUR FOLDER

```
warisdigital/
├── app/
│   ├── Http/
│   │   ├── Controllers/          ← Tipis, hanya orkestrasi
│   │   │   ├── Auth/
│   │   │   └── [Feature]Controller.php
│   │   ├── Middleware/
│   │   └── Requests/             ← WAJIB ada Form Request per endpoint
│   ├── Models/                   ← Eloquent, UUID primary key semua
│   ├── Services/                 ← Business logic, BUKAN di Controller
│   ├── Jobs/                     ← Queue jobs untuk scheduler
│   ├── Policies/                 ← Authorization per model
│   └── Enums/                    ← PHP 8.1 Backed Enums
│
├── database/
│   ├── migrations/               ← Satu file per tabel/perubahan
│   └── seeders/
│
├── resources/
│   └── js/
│       ├── Pages/                ← 1 file Vue = 1 route Inertia
│       ├── Components/
│       │   ├── UI/               ← Komponen generik (Button, Modal, dll)
│       │   ├── Vault/            ← Komponen domain vault
│       │   └── Assets/           ← Komponen domain aset
│       ├── Layouts/
│       ├── Composables/          ← use prefix wajib, misal useDocuments.js
│       └── Types/                ← TypeScript interfaces
│
├── routes/
│   ├── web.php                   ← SEMUA route ada di sini (Inertia)
│   └── api.php                   ← Kosong untuk sekarang
│
└── .skill/                       ← Folder skill ini
    ├── SKILL.md                  ← File ini
    └── references/               ← Dokumentasi detail per domain
        ├── database-schema.md
        ├── api-contracts.md
        ├── vue-conventions.md
        └── security-rules.md
```

Untuk detail lebih lanjut per domain, baca file referensi yang relevan di `.skill/references/`.

---

## 3. ATURAN WAJIB (HARUS DIIKUTI SELALU)

### 3.1 Aturan Backend (Laravel)

**[RULE-BE-01] Controller harus tipis**
Controller HANYA boleh:
1. Validasi input (via Form Request)
2. Memanggil Service
3. Return Inertia response atau redirect

```php
// ✅ BENAR
public function store(StoreDocumentRequest $request): RedirectResponse
{
    $document = $this->documentService->upload($request->validated(), auth()->user());
    return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diupload.');
}

// ❌ SALAH — business logic di controller
public function store(Request $request)
{
    $path = Storage::put('documents', $request->file('file'));
    $encrypted = Crypt::encryptString($path);
    Document::create([...]);
    // ... 30 baris lagi di controller
}
```

**[RULE-BE-02] Semua input wajib pakai Form Request**
Jangan pernah validasi langsung di controller dengan `$request->validate()`.
Selalu buat file `app/Http/Requests/[Action][Model]Request.php`.

**[RULE-BE-03] UUID untuk semua primary key**
Setiap model WAJIB menggunakan `HasUuids` trait. Tidak ada `id` integer.

```php
use Illuminate\Database\Eloquent\Concerns\HasUuids; // ← SELALU
```

**[RULE-BE-04] Soft delete untuk semua model utama**
Model berikut WAJIB `SoftDeletes`: User, Document, Asset, FamilyGroup.
Data tidak boleh dihapus permanen kecuali via scheduled cleanup.

**[RULE-BE-05] File path TIDAK BOLEH disimpan plain**
File path Supabase Storage SELALU dienkripsi sebelum masuk database:
```php
// ✅ BENAR
$encryptedPath = Crypt::encryptString($supabasePath);
Document::create(['file_path_encrypted' => $encryptedPath, ...]);

// ❌ SALAH — path tersimpan plain
Document::create(['file_path' => 'groups/abc/document.pdf', ...]);
```

**[RULE-BE-06] Signed URL, bukan public URL**
Download file SELALU via signed URL dengan expiry 15 menit.
Jangan pernah expose URL Supabase langsung ke user.

**[RULE-BE-07] Authorization via Policy, bukan inline**
```php
// ✅ BENAR
$this->authorize('download', $document);

// ❌ SALAH
if (auth()->id() !== $document->group->owner_id) abort(403);
```

**[RULE-BE-08] Gunakan Enum PHP 8.1 untuk kolom tipe**
```php
// ✅ BENAR
enum DocumentType: string {
    case AktaLahir     = 'akta_lahir';
    case SertifikatTanah = 'sertifikat_tanah';
    // ...
}

// ❌ SALAH — string literal berserakan
$document->type === 'akta_lahir'
```

**[RULE-BE-09] Scheduled job, bukan cron manual**
Semua pekerjaan berulang (reminder, time capsule unlock) WAJIB melalui
Laravel Scheduler di `app/Console/Kernel.php`, bukan endpoint atau cron manual.

**[RULE-BE-10] Error handling yang informatif**
Semua exception yang dilempar ke user harus punya pesan Bahasa Indonesia yang jelas.
Jangan pernah expose stack trace atau pesan teknis ke user.

---

### 3.2 Aturan Frontend (Vue 3 + Inertia)

**[RULE-FE-01] Selalu pakai `<script setup>` sintaks**
```vue
<!-- ✅ BENAR -->
<script setup>
import { ref, computed } from 'vue'
const props = defineProps({ document: Object })
</script>

<!-- ❌ SALAH — Options API -->
<script>
export default { props: ['document'], data() { return {} } }
</script>
```

**[RULE-FE-02] Navigasi via Inertia, bukan `<a>` biasa atau `window.location`**
```vue
<!-- ✅ BENAR -->
<Link :href="route('documents.index')">Vault</Link>

<!-- ❌ SALAH -->
<a href="/documents">Vault</a>
```

**[RULE-FE-03] Form submission via `useForm` Inertia**
Jangan pakai `fetch` atau `axios` untuk form submission ke Laravel.
```js
// ✅ BENAR
const form = useForm({ title: '', file: null })
form.post(route('documents.store'), { forceFormData: true })
```

**[RULE-FE-04] Semua halaman wajib pakai Layout**
- Halaman authenticated → `AppLayout.vue`
- Halaman guest (login/register) → `AuthLayout.vue`
- Landing page → layout sendiri (tanpa sidebar)

**[RULE-FE-05] Nama file Page harus match route-nya**
```
route('documents.index') → Pages/Documents/Index.vue
route('documents.show')  → Pages/Documents/Show.vue
route('documents.create')→ Pages/Documents/Create.vue
```

**[RULE-FE-06] Gunakan design tokens, bukan hardcode warna**
```vue
<!-- ✅ BENAR — pakai Tailwind class dari design system -->
<div class="bg-navy text-gold border-ivory-dark">

<!-- ❌ SALAH — hardcode hex -->
<div style="background: #1B2B4B; color: #C9A84C;">
```

**[RULE-FE-07] Composable untuk logic yang dipakai >1 komponen**
```js
// ✅ BENAR — logika fetch dokumen di composable
// resources/js/Composables/useDocuments.js
export function useDocuments() {
    const uploading = ref(false)
    function upload(file) { ... }
    return { uploading, upload }
}
```

**[RULE-FE-08] Loading state wajib untuk semua aksi async**
Setiap tombol yang trigger network request WAJIB punya state disabled/loading.
```vue
<button :disabled="form.processing" class="btn-primary">
    {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
</button>
```

**[RULE-FE-09] Pesan error dalam Bahasa Indonesia**
Semua pesan error yang ditampilkan ke user HARUS Bahasa Indonesia.
```vue
<!-- ✅ BENAR -->
<p v-if="form.errors.title" class="text-red-500 text-xs">
    {{ form.errors.title }}
</p>
```

**[RULE-FE-10] Konfirmasi sebelum aksi destruktif**
Hapus dokumen, hapus aset, keluar dari group — SELALU ada dialog konfirmasi.

---

### 3.3 Aturan Database

**[RULE-DB-01] Satu migration = satu perubahan logis**
Jangan gabungkan 3 tabel berbeda dalam satu file migration.

**[RULE-DB-02] Index wajib untuk foreign key dan kolom yang sering di-query**
```php
$table->index(['group_id', 'type']);   // sering diquery bersama
$table->index('expires_at');           // untuk scheduler
```

**[RULE-DB-03] JSONB untuk array fleksibel**
Gunakan `jsonb` (bukan `json`) untuk kolom array di PostgreSQL.
```php
$table->jsonb('tags')->nullable();
$table->jsonb('linked_document_ids')->nullable();
```

**[RULE-DB-04] Kolom sensitif harus dienkripsi atau di-mask**
- File path → `file_path_encrypted` (enkripsi Laravel Crypt)
- Nomor rekening → simpan masked (`****7890`) atau skip
- Tidak boleh ada plain text password, token, atau secret di DB

**[RULE-DB-05] Jangan pakai `DB::` langsung kecuali terpaksa**
Selalu gunakan Eloquent ORM. Jika butuh raw query karena performa,
beri komentar mengapa dan tambahkan index yang sesuai.

---

### 3.4 Aturan Keamanan

**[RULE-SEC-01] TIDAK ADA business logic di frontend**
Semua pengecekan izin (siapa boleh lihat apa) HARUS di Laravel Policy.
Frontend hanya menyembunyikan UI — bukan sumber otorisasi.

**[RULE-SEC-02] Time capsule TIDAK BOLEH di-unlock dari frontend**
Unlock time capsule hanya boleh via server-side check, bukan toggle di Vue.

**[RULE-SEC-03] Supabase service role key TIDAK BOLEH ke browser**
Key ini hanya boleh ada di `.env` server dan diakses dari kode PHP saja.
Jangan pernah pass ke Inertia props atau JavaScript.

**[RULE-SEC-04] Rate limit pada endpoint kritis**
```php
// Upload dokumen: max 10x/menit
// Login: max 5x/menit
// Undang anggota: max 20x/jam
```

**[RULE-SEC-05] Validasi tipe & ukuran file di backend**
Jangan hanya validasi di frontend. Backend WAJIB validasi:
- Max size: 50MB per file
- Allowed types: pdf, jpg, jpeg, png
- Cek magic bytes (bukan hanya ekstensi)

---

## 4. KONVENSI PENAMAAN

| Konteks | Konvensi | Contoh |
|---|---|---|
| Controller | PascalCase + Controller | `DocumentController.php` |
| Service | PascalCase + Service | `SupabaseStorageService.php` |
| Job | PascalCase + Job | `DocumentExpiryReminderJob.php` |
| Policy | PascalCase + Policy | `DocumentPolicy.php` |
| Form Request | Action + Model + Request | `StoreDocumentRequest.php` |
| Enum | PascalCase | `DocumentType.php` |
| Migration | snake_case dengan timestamp | `2025_01_01_create_documents_table.php` |
| Vue Page | PascalCase, match route | `Documents/Index.vue` |
| Vue Component | PascalCase | `VaultCard.vue`, `AssetRow.vue` |
| Composable | camelCase + use prefix | `useDocuments.js` |
| Route name | kebab-case.action | `documents.index`, `family-groups.invite` |
| CSS class (custom) | kebab-case | `vault-card`, `btn-primary` |

---

## 5. PANDUAN PER FITUR

Untuk panduan implementasi detail per fitur, baca file referensi berikut:

| Fitur | File Referensi |
|---|---|
| Vault Dokumen (upload, akses, download) | `.skill/references/vault-documents.md` |
| Aset Mapper | `.skill/references/assets.md` |
| Simulasi Waris (Faraid) | `.skill/references/inheritance.md` |
| Kapsul Waktu | `.skill/references/time-capsule.md` |
| Mitra Notaris | `.skill/references/notary.md` |
| Auth & Family Group | `.skill/references/auth-family.md` |
| Database Schema Lengkap | `.skill/references/database-schema.md` |
| Keamanan & Enkripsi | `.skill/references/security-rules.md` |

---

## 6. ALUR KERJA AGENT

Ikuti urutan ini setiap kali mendapat task baru:

```
1. BACA task dengan seksama
   └─ Identifikasi: fitur apa, layer apa (BE/FE/DB), domain apa

2. CEK referensi yang relevan
   └─ Baca file di .skill/references/ sesuai domain task

3. IDENTIFIKASI file yang perlu dibuat/diubah
   └─ Daftarkan sebelum mulai coding

4. TULIS kode sesuai aturan di bagian 3
   └─ Cek setiap rule yang relevan

5. VERIFIKASI mandiri sebelum selesai:
   □ Apakah ada business logic di controller? (RULE-BE-01)
   □ Apakah ada Form Request? (RULE-BE-02)
   □ Apakah file path terenkripsi? (RULE-BE-05)
   □ Apakah ada Policy untuk authorization? (RULE-BE-07)
   □ Apakah Vue pakai <script setup>? (RULE-FE-01)
   □ Apakah navigasi pakai <Link> Inertia? (RULE-FE-02)
   □ Apakah ada loading state? (RULE-FE-08)
   □ Apakah ada index di migration? (RULE-DB-02)

6. LAPORKAN apa yang dibuat
   └─ Daftar file baru/diubah + penjelasan singkat keputusan teknis
```

---

## 7. BATASAN AGENT

Agent DILARANG melakukan hal-hal berikut tanpa konfirmasi eksplisit dari developer:

| Larangan | Alasan |
|---|---|
| Mengganti stack teknologi | Konsistensi proyek |
| Mengubah skema tabel yang sudah ada (tanpa migration baru) | Integritas data produksi |
| Menghapus Soft Delete dari model | Keamanan data user |
| Membuat endpoint yang bypass Policy | Keamanan akses dokumen |
| Menyimpan file path plain text di DB | Keamanan enkripsi |
| Membuat akses Supabase langsung dari JS/Vue | Service role key exposure |
| Menambahkan library npm baru | Review dependensi |
| Menambahkan package Composer baru | Review dependensi |
| Mengubah struktur folder utama | Konsistensi arsitektur |
| Membuat logika unlock time capsule di frontend | Keamanan time capsule |

---

## 8. BAHASA & TONE

- **Kode**: Komentar PHP dan Vue boleh Bahasa Inggris (standar industri)
- **Pesan ke user (UI)**: WAJIB Bahasa Indonesia
- **Nama variabel/fungsi**: Bahasa Inggris (camelCase/snake_case sesuai konvensi)
- **Nama tabel & kolom DB**: Bahasa Inggris snake_case
- **Dokumentasi internal**: Boleh campuran (Indonesia lebih diutamakan untuk konteks bisnis)

---

## 9. CHECKLIST SEBELUM COMMIT

```
BACKEND:
□ php artisan test — semua test hijau
□ php artisan route:list — tidak ada route duplikat
□ Tidak ada dd(), var_dump(), atau console.log yang tertinggal
□ Tidak ada hardcoded credential

FRONTEND:
□ npm run build — tidak ada error
□ Semua form punya error handling
□ Semua aksi destruktif punya konfirmasi
□ Semua teks UI dalam Bahasa Indonesia

DATABASE:
□ Migration berjalan tanpa error: php artisan migrate:fresh --seed
□ Index sudah ditambahkan untuk kolom yang diquery
□ Tidak ada kolom sensitif yang plain text

KEAMANAN:
□ Semua endpoint protected by middleware auth
□ Semua aksi punya Policy check
□ File upload divalidasi tipe & ukuran
□ Tidak ada business logic di Vue
```