# 🖥️ 05 — Frontend Guide (Vue 3 + Inertia)

## Struktur Pages

```
resources/js/
├── Pages/
│   ├── Landing.vue              ← Halaman publik
│   ├── Auth/
│   │   ├── Login.vue
│   │   └── Register.vue
│   ├── Dashboard/
│   │   └── Index.vue
│   │
│   ├── Documents/
│   │   ├── Index.vue            ← Vault grid
│   │   ├── Show.vue             ← Detail dokumen
│   │   └── Create.vue           ← Upload form
│   │
│   ├── Assets/
│   │   ├── Index.vue            ← Aset mapper table
│   │   └── Create.vue
│   │
│   ├── Access/
│   │   └── Index.vue            ← Akses Berjenjang
│   │
│   ├── Reminders/
│   │   └── Index.vue            ← Pengingat Dokumen
│   │
│   ├── Profile/
│   │   └── Index.vue            ← Profil Pengguna
│   │
│   ├── Inheritance/
│   │   └── Index.vue            ← Simulasi Waris
│   │
│   ├── TimeCapsule/
│   │   └── Index.vue            ← Kapsul Waktu
│   │
│   └── Notary/
│       └── Index.vue            ← Mitra Notaris
│
├── Layouts/
│   ├── AppLayout.vue            ← Sidebar + main content
│   └── AuthLayout.vue           ← Login & Register layout
│
├── Components/
│   ├── UI/
│   │   ├── Button.vue
│   │   ├── Modal.vue
│   │   ├── Badge.vue
│   │   ├── Card.vue
│   │   ├── Alert.vue
│   │   ├── Spinner.vue
│   │   └── ConfirmDialog.vue
│   │
│   ├── Vault/
│   │   ├── VaultCard.vue
│   │   ├── UploadZone.vue
│   │   └── AccessManager.vue
│   │
│   ├── Assets/
│   │   ├── AssetRow.vue
│   │   └── AssetTypeSummary.vue
│   │
│   ├── Access/
│   │   ├── UserPermissionCard.vue
│   │   ├── PermissionTable.vue
│   │   └── AccessLevelBadge.vue
│   │
│   ├── Reminders/
│   │   ├── ReminderCard.vue
│   │   ├── ReminderTable.vue
│   │   └── ExpiryBadge.vue
│   │
│   └── Profile/
│       ├── ProfileCard.vue
│       ├── AccountSecurity.vue
│       └── AvatarUploader.vue
│
├── Composables/
│   ├── useDocuments.js
│   ├── useAssets.js
│   ├── useAccess.js
│   ├── useReminders.js
│   ├── useProfile.js
│   └── useFlash.js
│
└── Types/
    └── index.d.ts
```

## Cara Pakai AppLayout

```vue
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <!-- Optional: custom header -->
    <template #header>
      <h1 class="font-display text-2xl text-navy">Dashboard</h1>
    </template>

    <!-- Content -->
    <div>Isi halaman...</div>
  </AppLayout>
</template>
```

---

## Cara Navigasi Inertia (tanpa full page reload)

```vue
<script setup>
import { Link, router } from '@inertiajs/vue3'
</script>

<template>
  <!-- Link biasa -->
  <Link href="/dashboard">Dashboard</Link>

  <!-- Link dengan named route (pakai Ziggy) -->
  <Link :href="route('documents.index')">Vault</Link>

  <!-- POST / DELETE programatik -->
  <button @click="router.delete(route('documents.destroy', doc.id))">
    Hapus
  </button>
</template>
```

---

## Cara Kirim Form

```vue
<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    title: '',
    type: 'lainnya',
    file: null,
})

function submit() {
    form.post(route('documents.store'), {
        onSuccess: () => form.reset(),
        forceFormData: true,   // wajib untuk upload file
    })
}
</script>

<template>
  <form @submit.prevent="submit">
    <input v-model="form.title" class="form-input" />

    <!-- Error handling otomatis dari Laravel -->
    <p v-if="form.errors.title" class="text-red-500 text-xs mt-1">
        {{ form.errors.title }}
    </p>

    <button type="submit" class="btn-primary" :disabled="form.processing">
        {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
    </button>
  </form>
</template>
```

---

## Design Tokens (via Tailwind)

```
Design Tokens (via CSS Custom + Bootstrap)

Warna utama:
  ivory:   #F8FAE5
  gold:    #F0AD52
  dark:    #2B0303
  brown:   #A76430

CSS global:
  resources/css/warisdigital.css

Layout:
  AppLayout.vue  → halaman setelah login
  AuthLayout.vue → login/register
  Landing.vue    → halaman publik
```

---

## Flash Messages

Controller Laravel:
```php
return redirect()->route('documents.index')
    ->with('success', 'Dokumen berhasil diupload.');
```

Tampil otomatis di AppLayout via `<Alert>` component.

---

## Konvensi Penamaan

| Jenis | Konvensi | Contoh |
|---|---|---|
| Pages | PascalCase | `Documents/Index.vue` |
| Components | PascalCase | `VaultCard.vue` |
| Composables | camelCase + use prefix | `useDocuments.js` |
| CSS classes | kebab-case (Tailwind) | `vault-card`, `btn-primary` |
| Props | camelCase | `documentId`, `groupName` |
