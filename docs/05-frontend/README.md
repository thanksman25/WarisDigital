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

```
## Layout yang Digunakan
```
AppLayout.vue  → halaman setelah login
AuthLayout.vue → login dan register
Landing.vue    → halaman publik, tidak memakai AppLayout

Halaman seperti Dashboard, Vault Dokumen, Aset Mapper, Akses Berjenjang, Pengingat, Profil, Kapsul Waktu, Simulasi Waris, dan Mitra Notaris menggunakan AppLayout.

Login dan Register menggunakan AuthLayout.

Landing Page menggunakan layout sendiri.
```

## Cara Pakai AppLayout

```vue
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <template #title>Vault Dokumen</template>
    <template #subtitle>Kelola dokumen penting keluarga dalam satu tempat.</template>

    <div class="wd-card">
      Isi halaman...
    </div>
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

## Styling
```
Frontend menggunakan kombinasi:

Vue 3 + Inertia
Bootstrap 5
CSS custom WarisDigital

CSS global disimpan di:

resources/css/warisdigital.css

CSS global digunakan untuk elemen bersama seperti:

AppLayout
Sidebar
Header
Card
Button
Badge
Background
Typography dasar

CSS khusus halaman boleh ditulis di masing-masing file .vue menggunakan:

<style scoped>
/* CSS khusus halaman */
</style>
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

| Jenis              | Konvensi               | Contoh                                     |
| ------------------ | ---------------------- | ------------------------------------------ |
| Pages              | PascalCase             | `Documents/Index.vue`                      |
| Components         | PascalCase             | `VaultCard.vue`                            |
| Composables        | camelCase + use prefix | `useDocuments.js`                          |
| CSS global         | prefix `wd-`           | `wd-card`, `wd-btn-primary`                |
| CSS khusus halaman | kebab-case             | `vault-card`, `asset-row`, `reminder-item` |
| Props              | camelCase              | `documentId`, `groupName`                  |
