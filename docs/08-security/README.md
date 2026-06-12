# 🔐 08 — Keamanan & Enkripsi

## Prinsip Utama

1. **File path tidak pernah exposed** — selalu di-generate ulang sebagai Signed URL
2. **Enkripsi berlapis** — storage Supabase (at-rest) + Laravel Crypt (path di DB)
3. **Authorization di setiap level** — middleware, policy, dan service layer
4. **Signed URLs expire** — 15 menit, tidak bisa di-share atau di-cache

---

## Alur Upload & Download Dokumen

```
UPLOAD:
User → Browser → Laravel Controller
    → Validasi file (type, size)
    → Upload ke Supabase Storage (HTTPS)
    → Encrypt path dengan Laravel Crypt
    → Simpan encrypted path ke DB
    → ✅ Selesai (raw path tidak pernah ke user)

DOWNLOAD:
User request download → Laravel Controller
    → Cek auth (user login?)
    → Cek document access (user punya izin?)
    → Cek time capsule (dokumen terkunci?)
    → Decrypt path dari DB
    → Minta Signed URL dari Supabase (15 menit)
    → Redirect user ke Signed URL
    → ✅ File didownload langsung dari Supabase
```

---

## Laravel Authorization (Policies)

```php
// app/Policies/DocumentPolicy.php

public function view(User $user, Document $document): bool
{
    return $user->id === $document->group->owner_id
        || $document->accesses()
                    ->where('user_id', $user->id)
                    ->whereIn('permission', ['view', 'download', 'manage'])
                    ->exists();
}

public function download(User $user, Document $document): bool
{
    if ($document->isLocked()) return false;

    return $user->id === $document->group->owner_id
        || $document->accesses()
                    ->where('user_id', $user->id)
                    ->whereIn('permission', ['download', 'manage'])
                    ->exists();
}
```

---

## Input Validation

Semua input dari user divalidasi via Form Request Laravel:

```php
// app/Http/Requests/StoreDocumentRequest.php
public function rules(): array
{
    return [
        'title'     => 'required|string|max:255',
        'type'      => 'required|in:akta_lahir,sertifikat_tanah,...',
        'file'      => 'required|file|max:51200|mimes:pdf,jpg,jpeg,png',
        'expires_at'=> 'nullable|date|after:today',
    ];
}
```

---

## Rate Limiting

```php
// routes/web.php — untuk upload
Route::post('/documents', ...)->middleware('throttle:10,1'); // 10x per menit

// Auth routes
Route::post('/login', ...)->middleware('throttle:5,1');      // 5x per menit
```

---

## Headers Keamanan

Tambahkan di `app/Http/Middleware/SecurityHeaders.php`:

```php
$response->headers->set('X-Frame-Options', 'DENY');
$response->headers->set('X-Content-Type-Options', 'nosniff');
$response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
$response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
```

---

## Checklist Keamanan MVP

- [x] File path dienkripsi di database
- [x] Signed URL dengan expiry 15 menit
- [x] Authorization policy di setiap controller
- [x] Input validation di semua endpoint
- [x] CSRF protection (bawaan Laravel + Inertia)
- [x] SQL injection protection (Eloquent ORM)
- [x] XSS protection (Vue auto-escape)
- [ ] Rate limiting (Phase 2)
- [ ] 2FA untuk akun notaris (Phase 2)
- [ ] Audit log (siapa akses dokumen apa kapan) (Phase 3)
- [ ] Penetration testing (sebelum launch)
