<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth?.user)

const initials = computed(() => {
  if (!user.value || !user.value.name) return 'WD'
  return user.value.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase()
})

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
  { label: 'Panduan Klaim', icon: '📋', href: '/claims' },
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
        <div class="wd-avatar">{{ initials }}</div>
        <div>
          <h4>{{ user ? user.name : 'Tamu' }}</h4>
          <p>Kepala Keluarga</p>
        </div>
      </div>

      <nav class="wd-nav">
        <p class="wd-nav-title">Menu Utama</p>
        <Link
          v-for="item in menuMain"
          :key="item.label"
          :href="item.href"
          class="wd-nav-item"
          :class="{ active: $page.url === item.href || $page.url.startsWith(item.href + '/') }"
        >
          <span>{{ item.icon }}</span>
          {{ item.label }}
        </Link>

        <p class="wd-nav-title">Perencanaan</p>
        <Link
          v-for="item in menuPlan"
          :key="item.label"
          :href="item.href"
          class="wd-nav-item"
          :class="{ active: $page.url === item.href || $page.url.startsWith(item.href + '/') }"
        >
          <span>{{ item.icon }}</span>
          {{ item.label }}
        </Link>
      </nav>

      <div class="wd-sidebar-footer">
        <Link href="/profile" class="wd-nav-item" :class="{ active: $page.url === '/profile' }">⚙️ Pengaturan</Link>
        <Link href="/logout" method="post" as="button" class="wd-nav-item" style="background:none; border:none; text-align:left; cursor:pointer; width:100%; font-family:inherit;">
          🚪 Keluar
        </Link>
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
          <div class="wd-avatar small">{{ initials }}</div>
        </div>
      </header>

      <section class="wd-content">
        <!-- Flash Message Notification -->
        <div v-if="page.props.flash?.success" style="background:#e9f7ef; color:#1e8449; padding:12px; border-radius:8px; margin-bottom:18px; border:1px solid #d4edda; font-size:14px;">
          ✅ {{ page.props.flash.success }}
        </div>
        <div v-if="page.props.flash?.error" style="background:#fde8e8; color:#c0392b; padding:12px; border-radius:8px; margin-bottom:18px; border:1px solid #f8d7da; font-size:14px;">
          ❌ {{ page.props.flash.error }}
        </div>
        <slot />
      </section>
    </main>
  </div>
</template>