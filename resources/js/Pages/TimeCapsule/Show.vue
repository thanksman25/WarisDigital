<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

const capsule = {
  id: 1,
  title: 'Pesan Video untuk Anak',
  type: 'Pesan Video',
  status: 'Terkunci',
  receiver: 'Budi & Dewi',
  condition: 'Terverifikasi meninggal',
  createdAt: '12 Jan 2024',
  description: 'Video pribadi yang hanya dapat dibuka oleh anak setelah status terverifikasi.',
  fileName: 'pesan-video-keluarga.mp4',
}
</script>

<template>
  <AppLayout>
    <template #title>Detail Kapsul Waktu</template>
    <template #subtitle>Lihat informasi lengkap kapsul waktu yang telah dibuat.</template>

    <div class="capsule-page">
      <div class="wd-card detail-card">
        <div class="detail-header">
          <div>
            <span class="status-badge">🔒 {{ capsule.status }}</span>
            <h2>{{ capsule.title }}</h2>
            <p>{{ capsule.description }}</p>
          </div>

          <Link href="/time-capsule" class="secondary-btn">
            Kembali
          </Link>
        </div>

        <div class="detail-grid">
          <div class="info-box">
            <span>Jenis Kapsul</span>
            <strong>{{ capsule.type }}</strong>
          </div>

          <div class="info-box">
            <span>Penerima</span>
            <strong>{{ capsule.receiver }}</strong>
          </div>

          <div class="info-box">
            <span>Kondisi Pembukaan</span>
            <strong>{{ capsule.condition }}</strong>
          </div>

          <div class="info-box">
            <span>Dibuat Pada</span>
            <strong>{{ capsule.createdAt }}</strong>
          </div>
        </div>

        <div class="file-preview">
          <div class="file-icon">🎥</div>
          <div>
            <h3>{{ capsule.fileName }}</h3>
            <p>File masih terkunci dan hanya akan terbuka jika kondisi terpenuhi.</p>
          </div>
        </div>

        <div class="note-box">
          <strong>Catatan:</strong>
          Tampilan ini masih berupa frontend. Validasi status, pembukaan kapsul, dan akses file akan dihubungkan dengan backend.
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.capsule-page {
  max-width: 1100px;
}

.detail-card {
  padding: 24px;
}

.detail-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 20px;
  margin-bottom: 24px;
}

.status-badge {
  display: inline-block;
  background: #fff3df;
  color: var(--wd-brown);
  padding: 6px 12px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 700;
  margin-bottom: 10px;
}

.detail-header h2 {
  margin: 0;
  color: var(--wd-dark);
}

.detail-header p {
  margin: 8px 0 0;
  color: var(--wd-muted);
  max-width: 650px;
}

.detail-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
  margin-bottom: 22px;
}

.info-box {
  background: #fffaf2;
  border: 1px solid var(--wd-border);
  border-radius: 14px;
  padding: 16px;
}

.info-box span {
  display: block;
  color: var(--wd-muted);
  font-size: 13px;
  margin-bottom: 6px;
}

.info-box strong {
  color: var(--wd-dark);
}

.file-preview {
  display: flex;
  gap: 14px;
  align-items: center;
  border: 1px dashed var(--wd-border);
  border-radius: 14px;
  padding: 18px;
  margin-bottom: 18px;
  background: #fff;
}

.file-icon {
  width: 52px;
  height: 52px;
  border-radius: 14px;
  background: #fff3df;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 26px;
}

.file-preview h3 {
  margin: 0;
  color: var(--wd-dark);
}

.file-preview p {
  margin: 5px 0 0;
  color: var(--wd-muted);
}

.note-box {
  padding: 16px;
  border-radius: 12px;
  background: #fffaf2;
  color: var(--wd-muted);
  border: 1px solid var(--wd-border);
}

.secondary-btn {
  border-radius: 10px;
  padding: 11px 18px;
  font-weight: 700;
  text-decoration: none;
  background: #fff;
  color: var(--wd-dark);
  border: 1px solid var(--wd-border);
}

@media (max-width: 900px) {
  .detail-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 700px) {
  .detail-header {
    flex-direction: column;
  }

  .detail-grid {
    grid-template-columns: 1fr;
  }

  .secondary-btn {
    width: 100%;
    text-align: center;
  }
}
</style>