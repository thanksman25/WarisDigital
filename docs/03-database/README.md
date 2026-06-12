# 🗄️ 03 — Database Schema & ERD

## ERD Ringkas

```
users ─────────────────────────────────────────────────────┐
  id (UUID, PK)                                            │
  name, email, phone, password                            │
  role: individual | notaris | admin                       │
  plan: free | keluarga | premium                          │
  plan_expires_at                                          │
                                                           │
  ├── owns ──► family_groups                               │
  │              id (UUID, PK)                             │
  │              name, description                         │
  │              owner_id → users                          │
  │                                                        │
  │              ├── has many ──► family_group_members     │
  │              │                 group_id, user_id       │
  │              │                 role: owner|member|...  │
  │              │                                         │
  │              ├── has many ──► documents                │
  │              │                 id (UUID)               │
  │              │                 title, type (enum)      │
  │              │                 file_path_encrypted     │
  │              │                 file_name, file_size    │
  │              │                 is_time_capsule (bool)  │
  │              │                 unlock_condition        │
  │              │                 unlock_at               │
  │              │                 expires_at              │
  │              │                                         │
  │              │                 ├─► document_accesses   │
  │              │                       document_id       │
  │              │                       user_id           │
  │              │                       permission        │
  │              │                                         │
  │              └── has many ──► assets                   │
  │                                id (UUID)               │
  │                                name, type (enum)       │
  │                                estimated_value         │
  │                                location                │
  │                                linked_document_ids[]   │
  │                                                        │
  ├── has many ──► reminders                               │
  │                 user_id, document_id?, asset_id?       │
  │                 type, remind_at, is_sent               │
  │                                                        │
  └── has one ──► notary_partners (jika role=notaris)      │
                    license_number, city, province          │
                    specializations[], rating               │
                    verified_at                             │
```

---

## Tabel Detail

### `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | UUID | Primary key |
| name | VARCHAR(255) | Nama lengkap |
| email | VARCHAR(255) | Unique |
| phone | VARCHAR(20) | Nullable |
| password | VARCHAR(255) | Hashed (bcrypt) |
| role | ENUM | individual / notaris / admin |
| plan | ENUM | free / keluarga / premium |
| plan_expires_at | TIMESTAMP | Null = tidak pernah expire |

### `documents`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | UUID | Primary key |
| group_id | UUID | FK → family_groups |
| uploaded_by | UUID | FK → users |
| title | VARCHAR(255) | Nama dokumen |
| type | ENUM | Lihat enum list di bawah |
| file_path_encrypted | TEXT | Path Supabase Storage, dienkripsi Laravel Crypt |
| file_name | VARCHAR(255) | Nama asli file |
| file_size | BIGINT | Bytes |
| mime_type | VARCHAR(100) | application/pdf, image/jpeg, dll |
| is_time_capsule | BOOLEAN | Default false |
| unlock_condition | ENUM | death_verification / date / manual |
| unlock_at | TIMESTAMP | Untuk kondisi 'date' |
| expires_at | DATE | Untuk reminder expiry |

### `assets`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | UUID | Primary key |
| type | ENUM | properti / kendaraan / rekening / saham / emas / usaha / lainnya |
| estimated_value | DECIMAL(18,2) | Estimasi nilai dalam rupiah |
| linked_document_ids | JSONB | Array UUID dokumen terkait |

---

## Enum Values

```php
// Document types
'akta_lahir', 'sertifikat_tanah', 'bpkb', 'polis_asuransi',
'kk', 'surat_wasiat', 'ktp', 'npwp', 'lainnya'

// Asset types
'properti', 'kendaraan', 'rekening', 'saham', 'emas', 'usaha', 'lainnya'

// Member roles
'owner', 'member', 'notaris', 'viewer'

// Inheritance methods
'islam', 'perdata', 'adat'
```

---

## Index Strategy

```sql
-- Dokumen per group + type (query vault paling sering)
CREATE INDEX idx_documents_group_type ON documents(group_id, type);

-- Dokumen yang akan expired (untuk scheduler)
CREATE INDEX idx_documents_expires ON documents(expires_at);

-- Reminder belum terkirim (untuk scheduler)
CREATE INDEX idx_reminders_pending ON reminders(user_id, is_sent, remind_at);

-- Aset per group + type
CREATE INDEX idx_assets_group_type ON assets(group_id, type);
```

---

## Catatan Keamanan Database

1. **File path tidak pernah disimpan plain** — selalu melalui `Crypt::encryptString()` Laravel
2. **Nomor rekening di assets** — disimpan masked (contoh: `****7890`) atau dienkripsi
3. **Soft delete** di semua tabel utama — data tidak langsung dihapus
4. **Supabase RLS** — meski Laravel yang manage akses, aktifkan Row Level Security sebagai defense in depth
