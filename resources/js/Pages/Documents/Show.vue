<script setup>
import { computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  document: {
    type: Object,
    required: true,
  },
  reminder: {
    type: Object,
    default: null,
  },
})

const daysLeft = computed(() => {
  if (!props.reminder || !props.reminder.remind_at) return null
  const remindDate = new Date(props.reminder.remind_at)
  const diffTime = remindDate - new Date()
  const days = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
  return days > 0 ? days : 0
})

const formatBytes = (bytes) => {
  if (!bytes) return 'Tidak Diketahui'
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}
</script>

<template>
  <AppLayout>
    <template #title>Detail Dokumen</template>
    <template #subtitle>Informasi lengkap dokumen yang tersimpan di Vault.</template>

    <div class="show-page">
      <div class="wd-card preview-card">
        <div class="file-icon">📄</div>
        <h2>{{ document.title }}</h2>
        <span v-if="daysLeft !== null" class="wd-badge" :class="daysLeft <= 7 ? 'danger' : 'gold'">
          Akan kedaluwarsa {{ daysLeft }} hari lagi
        </span>
        <span v-else class="wd-badge success">Aktif & Aman</span>
      </div>

      <div class="wd-card detail-card">
        <h3>Informasi Dokumen</h3>

        <div class="detail-row">
          <span>Kategori</span>
          <strong>{{ document.file_type || 'Lainnya' }}</strong>
        </div>

        <div class="detail-row">
          <span>Berlaku Hingga</span>
          <strong>
            {{ reminder ? new Date(reminder.remind_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : 'Tidak Terbatas' }}
          </strong>
        </div>

        <div class="detail-row">
          <span>Upload</span>
          <strong>
            {{ new Date(document.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}
          </strong>
        </div>

        <div class="detail-row">
          <span>Ukuran Berkas</span>
          <strong>{{ formatBytes(document.file_size) }}</strong>
        </div>

        <div class="detail-row">
          <span>Visibilitas</span>
          <strong>Privat (Hanya Pemilik)</strong>
        </div>

        <div class="actions">
          <Link href="/documents" class="wd-btn-outline">Kembali</Link>
          <button class="wd-btn-primary">Unduh Dokumen</button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.show-page {
  display: grid;
  grid-template-columns: 1fr 1.4fr;
  gap: 18px;
  max-width: 980px;
  margin: 0 auto;
}

.preview-card {
  text-align: center;
  padding: 32px 20px;
}

.file-icon {
  font-size: 72px;
  margin-bottom: 12px;
}

.detail-card {
  padding: 24px;
}

.detail-card h3 {
  margin-top: 0;
  margin-bottom: 18px;
  color: var(--wd-dark);
}

.detail-row {
  display: flex;
  justify-content: space-between;
  padding: 14px 0;
  border-bottom: 1px solid var(--wd-border);
}

.detail-row span {
  color: var(--wd-muted);
}

.actions {
  margin-top: 24px;
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

.actions a {
  text-decoration: none;
  display: flex;
  align-items: center;
}

@media (max-width: 900px) {
  .show-page {
    grid-template-columns: 1fr;
  }
}
</style>