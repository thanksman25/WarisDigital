<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  capsule: {
    type: Object,
    required: true,
  },
})

const getConditionLabel = (cond) => {
  if (cond === 'date') return 'Tanggal Tertentu (Otomatis)'
  if (cond === 'death') return 'Kematian Terverifikasi (Verifikasi Admin)'
  return 'Buka Manual oleh Pemilik'
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
            <span class="status-badge" :class="capsule.is_unlocked ? 'success-badge' : 'locked-badge'">
              {{ capsule.is_unlocked ? '🔓 Terbuka' : '🔒 Terkunci' }}
            </span>
            <h2>{{ capsule.title }}</h2>
          </div>

          <Link href="/time-capsule" class="secondary-btn">
            Kembali
          </Link>
        </div>

        <div class="detail-grid">
          <div class="info-box">
            <span>Penerima</span>
            <strong>Ahli Waris Utama</strong>
          </div>

          <div class="info-box">
            <span>Kondisi Pembukaan</span>
            <strong>{{ getConditionLabel(capsule.unlock_condition) }}</strong>
          </div>

          <div class="info-box" v-if="capsule.unlock_condition === 'date'">
            <span>Waktu Terbuka</span>
            <strong>{{ new Date(capsule.unlock_at).toLocaleString('id-ID') }}</strong>
          </div>

          <div class="info-box">
            <span>Dibuat Pada</span>
            <strong>{{ new Date(capsule.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}</strong>
          </div>
        </div>

        <div class="capsule-content-section mb-4">
          <h3>Pesan / Catatan Tertulis</h3>
          <div class="message-content">
            {{ capsule.message || 'Tidak ada pesan tertulis.' }}
          </div>
        </div>

        <div class="file-preview" v-if="capsule.document">
          <div class="file-icon">📄</div>
          <div>
            <h3>{{ capsule.document.title }}</h3>
            <p v-if="!capsule.is_unlocked">File ini terhubung ke kapsul waktu dan dalam keadaan terenkripsi aman.</p>
            <p v-else>File dapat diunduh sekarang.</p>
          </div>
          <div style="margin-left: auto;" v-if="capsule.is_unlocked">
            <a :href="`/documents/show?id=${capsule.document.id}`" class="primary-btn" style="text-decoration: none;">Lihat File</a>
          </div>
        </div>

        <div class="note-box mt-3">
          <strong>Keamanan Legacy Protection:</strong>
          Kapsul waktu dienkripsi secara aman menggunakan kunci privat. Hanya penerima sah yang dapat membukanya setelah kondisi pembukaan diverifikasi oleh sistem.
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.capsule-page {
  max-width: 1100px;
  margin: 0 auto;
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
  padding: 6px 12px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 700;
  margin-bottom: 10px;
}

.locked-badge {
  background: #fff3df;
  color: var(--wd-brown);
}

.success-badge {
  background: #e9f7ef;
  color: #1e8449;
}

.detail-header h2 {
  margin: 0;
  color: var(--wd-dark);
}

.detail-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
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

.capsule-content-section h3 {
  font-size: 15px;
  font-weight: 700;
  margin-bottom: 10px;
}

.message-content {
  background: var(--wd-bg);
  border: 1px solid var(--wd-border);
  border-radius: 12px;
  padding: 16px;
  line-height: 1.6;
  font-size: 14px;
  color: #444;
}

.file-preview {
  display: flex;
  gap: 14px;
  align-items: center;
  border: 1px dashed var(--wd-border);
  border-radius: 14px;
  padding: 18px;
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
  font-size: 14px;
}

.file-preview p {
  margin: 5px 0 0;
  color: var(--wd-muted);
  font-size: 12px;
}

.note-box {
  padding: 16px;
  border-radius: 12px;
  background: #fffaf2;
  color: var(--wd-muted);
  border: 1px solid var(--wd-border);
  font-size: 13px;
}

.primary-btn {
  background: var(--wd-gold);
  color: var(--wd-dark);
  padding: 8px 14px;
  border-radius: 8px;
  font-weight: 700;
  font-size: 12px;
  border: none;
  cursor: pointer;
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

.mb-4 { margin-bottom: 18px; }
.mt-3 { margin-top: 14px; }

@media (max-width: 900px) {
  .detail-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 700px) {
  .detail-header {
    flex-direction: column;
  }

  .secondary-btn {
    width: 100%;
    text-align: center;
  }
}
</style>