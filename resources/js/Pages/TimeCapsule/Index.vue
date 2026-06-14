<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const capsules = [
  {
    id: 1,
    icon: '📹',
    title: 'Pesan Video untuk Anak',
    description: 'Video pribadi yang hanya dapat dibuka oleh anak setelah status terverifikasi.',
    receiver: 'Budi & Dewi',
    condition: 'Terverifikasi meninggal',
    createdAt: '12 Jan 2024',
    status: 'Terkunci',
    badgeClass: 'gold',
    cardClass: 'locked',
  },
  {
    id: 2,
    icon: '📄',
    title: 'Surat Wasiat Digital',
    description: 'Pesan tertulis dan arahan awal mengenai dokumen waris keluarga.',
    receiver: 'Siti Rahayu',
    condition: 'Verifikasi notaris',
    createdAt: '20 Feb 2024',
    status: 'Terjadwal',
    badgeClass: 'success',
    cardClass: '',
  },
  {
    id: 3,
    icon: '📁',
    title: 'Dokumen Rahasia Keluarga',
    description: 'Dokumen tambahan yang hanya terbuka kepada penerima tertentu.',
    receiver: 'Notaris & Istri',
    condition: 'Persetujuan dua pihak',
    createdAt: '03 Mar 2024',
    status: 'Private',
    badgeClass: 'danger',
    cardClass: 'private',
  },
]
</script>

<template>
  <AppLayout>
    <template #title>Kapsul Waktu</template>
    <template #subtitle>Dokumen atau pesan akan terbuka otomatis saat kondisi tertentu terpenuhi.</template>

    <div class="capsule-page">
      <div class="capsule-hero wd-card">
        <div>
          <span class="wd-badge gold">⏰ Legacy Protection</span>
          <h2>Siapkan pesan dan dokumen penting untuk keluarga</h2>
          <p>
            Kapsul waktu membantu memastikan pesan pribadi, video, atau dokumen tertentu
            hanya terbuka kepada penerima yang dipilih setelah kondisi terverifikasi.
          </p>
        </div>

        <Link href="/time-capsule/create" class="create-btn">
          + Buat Kapsul
        </Link>
      </div>

      <div class="capsule-stats">
        <div class="wd-card stat-card">
          <span>🔒</span>
          <div>
            <h3>3</h3>
            <p>Kapsul Terkunci</p>
          </div>
        </div>

        <div class="wd-card stat-card">
          <span>👥</span>
          <div>
            <h3>5</h3>
            <p>Penerima Terdaftar</p>
          </div>
        </div>

        <div class="wd-card stat-card">
          <span>✅</span>
          <div>
            <h3>1</h3>
            <p>Siap Diverifikasi</p>
          </div>
        </div>
      </div>

      <div class="capsule-grid">
        <div
          v-for="capsule in capsules"
          :key="capsule.id"
          class="wd-card capsule-card"
          :class="capsule.cardClass"
        >
          <div class="capsule-top">
            <div class="capsule-icon">{{ capsule.icon }}</div>
            <span class="wd-badge" :class="capsule.badgeClass">
              {{ capsule.status }}
            </span>
          </div>

          <h3>{{ capsule.title }}</h3>
          <p>{{ capsule.description }}</p>

          <div class="capsule-meta">
            <span>👤 Penerima: {{ capsule.receiver }}</span>
            <span>🔐 Kondisi: {{ capsule.condition }}</span>
            <span>📅 Dibuat: {{ capsule.createdAt }}</span>
          </div>

          <Link :href="`/time-capsule/${capsule.id}`" class="detail-btn">
            Lihat Detail
          </Link>
        </div>
      </div>

      <div class="wd-card capsule-note">
        <strong>Catatan:</strong>
        Fitur ini masih berupa tampilan frontend. Validasi kondisi, verifikasi kematian,
        dan pembukaan kapsul otomatis akan disambungkan ke backend.
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.capsule-page {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.capsule-hero {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 24px;
}

.capsule-hero h2 {
  margin: 12px 0 8px;
  font-size: 24px;
  color: var(--wd-dark);
}

.capsule-hero p {
  margin: 0;
  color: var(--wd-muted);
  max-width: 720px;
}

.create-btn {
  background: var(--wd-gold);
  color: var(--wd-dark);
  padding: 10px 18px;
  border-radius: 12px;
  text-decoration: none;
  font-weight: 700;
  white-space: nowrap;
}

.capsule-stats,
.capsule-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 18px;
}

.stat-card {
  display: flex;
  align-items: center;
  gap: 14px;
}

.stat-card span,
.capsule-icon {
  width: 48px;
  height: 48px;
  border-radius: 14px;
  background: rgba(240, 173, 82, 0.18);
  display: grid;
  place-items: center;
  font-size: 24px;
}

.stat-card h3 {
  margin: 0;
  font-size: 24px;
}

.stat-card p {
  margin: 4px 0 0;
  color: var(--wd-muted);
}

.capsule-card {
  display: flex;
  flex-direction: column;
  gap: 14px;
  min-height: 300px;
}

.capsule-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.capsule-card h3 {
  margin: 0;
  color: var(--wd-dark);
}

.capsule-card p {
  margin: 0;
  color: var(--wd-muted);
  line-height: 1.5;
}

.capsule-meta {
  display: flex;
  flex-direction: column;
  gap: 7px;
  margin-top: auto;
  font-size: 13px;
  color: var(--wd-muted);
}

.detail-btn {
  text-align: center;
  padding: 10px;
  border-radius: 10px;
  border: 1px solid var(--wd-border);
  text-decoration: none;
  color: var(--wd-dark);
  font-weight: 700;
  background: #fff;
}

.locked {
  border-color: rgba(240, 173, 82, 0.45);
}

.private {
  border-color: rgba(192, 57, 43, 0.25);
}

.capsule-note {
  color: var(--wd-muted);
  line-height: 1.6;
}

@media (max-width: 1000px) {
  .capsule-grid,
  .capsule-stats {
    grid-template-columns: 1fr;
  }

  .capsule-hero {
    flex-direction: column;
    align-items: flex-start;
  }
}
</style>