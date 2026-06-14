<script setup>
const menuMain = [
  { label: 'Dashboard', icon: '🏠', href: '/dashboard' },
  { label: 'Vault Dokumen', icon: '🗄️', href: '/documents' },
  { label: 'Aset Mapper', icon: '🗺️', href: '/assets' },
  { label: 'Akses Berjenjang', icon: '👥', href: '/access' },
]

const menuPlan = [
  { label: 'Pengingat', icon: '⏰', href: '/reminders' },
  { label: 'Simulasi Waris', icon: '⚖️', href: '/inheritance' },
  { label: 'Kapsul Waktu', icon: '⏳', href: '/time-capsule' },
  { label: 'Mitra Notaris', icon: '⚖️', href: '/notary' },
]
</script>

<template>
  <div class="wd-app">
    <aside class="wd-sidebar">
      <div class="wd-brand">
        <div class="wd-logo"></div>
        <span>WarisDigital</span>
      </div>

      <div class="wd-user">
        <div class="wd-avatar">AS</div>
        <div>
          <h4>Ahmad Sutarjo</h4>
          <p>Kepala Keluarga</p>
        </div>
      </div>

      <nav class="wd-nav">
        <p class="wd-nav-title">Menu Utama</p>
        <a v-for="item in menuMain" :key="item.label" :href="item.href" class="wd-nav-item">
          <span>{{ item.icon }}</span>
          {{ item.label }}
        </a>

        <p class="wd-nav-title">Perencanaan</p>
        <a v-for="item in menuPlan" :key="item.label" :href="item.href" class="wd-nav-item">
          <span>{{ item.icon }}</span>
          {{ item.label }}
        </a>
      </nav>

      <div class="wd-sidebar-footer">
        <a href="/profile" class="wd-nav-item">⚙️ Pengaturan</a>
        <a href="/logout" class="wd-nav-item">🚪 Keluar</a>
      </div>
    </aside>

    <main class="wd-main">
      <header class="wd-topbar">
        <div>
          <h1><slot name="title">Selamat pagi, Bapak Ahmad 👋</slot></h1>
          <p><slot name="subtitle">Minggu, 14 Juni 2025 — Semua sistem berjalan normal</slot></p>
        </div>

        <div class="wd-top-actions">
          <button class="wd-notif">🔔</button>
          <div class="wd-avatar small">AS</div>
        </div>
      </header>

      <section class="wd-content">
        <slot />
      </section>
    </main>
  </div>
</template>