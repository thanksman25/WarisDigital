<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
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

        <button class="wd-btn-primary">+ Buat Kapsul</button>
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
        <div class="wd-card capsule-card locked">
          <div class="capsule-top">
            <div class="capsule-icon">📹</div>
            <span class="wd-badge gold">Terkunci</span>
          </div>

          <h3>Pesan Video untuk Anak</h3>
          <p>Video pribadi yang hanya dapat dibuka oleh anak setelah status terverifikasi.</p>

          <div class="capsule-meta">
            <span>👤 Penerima: Budi & Dewi</span>
            <span>🔐 Kondisi: Terverifikasi meninggal</span>
            <span>📅 Dibuat: 12 Jan 2024</span>
          </div>

          <button class="wd-btn-outline">Lihat Detail</button>
        </div>

        <div class="wd-card capsule-card">
          <div class="capsule-top">
            <div class="capsule-icon">📄</div>
            <span class="wd-badge success">Terjadwal</span>
          </div>

          <h3>Surat Wasiat Digital</h3>
          <p>Pesan tertulis dan arahan awal mengenai dokumen waris keluarga.</p>

          <div class="capsule-meta">
            <span>👤 Penerima: Siti Rahayu</span>
            <span>🔐 Kondisi: Verifikasi notaris</span>
            <span>📅 Dibuat: 20 Feb 2024</span>
          </div>

          <button class="wd-btn-outline">Lihat Detail</button>
        </div>

        <div class="wd-card capsule-card private">
          <div class="capsule-top">
            <div class="capsule-icon">📁</div>
            <span class="wd-badge danger">Private</span>
          </div>

          <h3>Dokumen Rahasia Keluarga</h3>
          <p>Dokumen tambahan yang hanya terbuka kepada penerima tertentu.</p>

          <div class="capsule-meta">
            <span>👤 Penerima: Notaris & Istri</span>
            <span>🔐 Kondisi: Persetujuan dua pihak</span>
            <span>📅 Dibuat: 03 Mar 2024</span>
          </div>

          <button class="wd-btn-outline">Lihat Detail</button>
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

.capsule-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 18px;
}

.stat-card {
  display: flex;
  align-items: center;
  gap: 14px;
}

.stat-card span {
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

.capsule-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 18px;
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

.capsule-icon {
  width: 54px;
  height: 54px;
  border-radius: 14px;
  background: rgba(240, 173, 82, 0.18);
  display: grid;
  place-items: center;
  font-size: 26px;
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