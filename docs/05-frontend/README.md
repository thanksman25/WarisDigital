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
│   ├── Documents/
│   │   ├── Index.vue            ← Vault grid
│   │   ├── Show.vue             ← Detail dokumen
│   │   └── Create.vue           ← Upload form
│   ├── Assets/
│   │   ├── Index.vue            ← Aset mapper table
│   │   └── Create.vue
│   ├── Inheritance/
│   │   └── Index.vue            ← Simulasi waris
│   ├── TimeCapsule/
│   │   └── Index.vue
│   └── Notary/
│       └── Index.vue
│
├── Layouts/
│   ├── AppLayout.vue            ← Sidebar + main content (semua halaman auth)
│   └── AuthLayout.vue           ← Split layout login/register
│
├── Components/
│   ├── UI/
│   │   ├── Button.vue           ← btn-primary, btn-outline, btn-gold
│   │   ├── Modal.vue            ← Reusable modal dialog
│   │   ├── Badge.vue            ← Status badges (safe, warning, danger)
│   │   ├── Card.vue             ← Base card wrapper
│   │   ├── Alert.vue            ← Flash message
│   │   ├── Spinner.vue          ← Loading indicator
│   │   └── ConfirmDialog.vue    ← Konfirmasi sebelum hapus
│   ├── Vault/
│   │   ├── VaultCard.vue        ← Card per dokumen di grid
│   │   ├── UploadZone.vue       ← Drag & drop area
│   │   └── AccessManager.vue    ← UI kelola akses dokumen
│   └── Assets/
│       ├── AssetRow.vue         ← Baris di tabel aset
│       └── AssetTypeSummary.vue ← Summary bar 5 tipe aset
│
├── Composables/
│   ├── useDocuments.js          ← Fetch, upload, delete dokumen
│   ├── useAssets.js
│   └── useFlash.js              ← Handle flash messages
│
└── Types/
    └── index.d.ts               ← TypeScript interfaces
```

---

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
Warna utama:
  navy:    #1B2B4B  → bg-navy, text-navy, border-navy
  gold:    #C9A84C  → bg-gold, text-gold
  sage:    #4A7C6B  → bg-sage, text-sage
  ivory:   #F7F4EE  → bg-ivory
  slate:   #E8EDF5  → bg-slate-vault

Font:
  font-display  → Fraunces (semua heading h1-h3)
  font-sans     → Inter (body, label, button)

Border radius:
  rounded-card  → 14px (cards)
  rounded-btn   → 10px (buttons, inputs)
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
