<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <template #title>Detail Dokumen</template>
    <template #subtitle>Informasi lengkap dokumen yang tersimpan di Vault.</template>

    <div class="show-page">
      <div class="wd-card preview-card">
        <div class="file-icon">📄</div>
        <h2>KTP Ahmad Sutarjo</h2>
        <span class="wd-badge danger">Akan kedaluwarsa 3 hari lagi</span>
      </div>

      <div class="wd-card detail-card">
        <h3>Informasi Dokumen</h3>

        <div class="detail-row">
          <span>Kategori</span>
          <strong>Identitas</strong>
        </div>

        <div class="detail-row">
          <span>Berlaku Hingga</span>
          <strong>17 Juni 2025</strong>
        </div>

        <div class="detail-row">
          <span>Upload</span>
          <strong>12 Maret 2024</strong>
        </div>

        <div class="detail-row">
          <span>Visibilitas</span>
          <strong>Privat</strong>
        </div>

        <div class="actions">
          <a href="/documents" class="wd-btn-outline">Kembali</a>
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
}

.preview-card {
  text-align: center;
}

.file-icon {
  font-size: 72px;
  margin-bottom: 12px;
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
  margin-top: 18px;
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

@media (max-width: 900px) {
  .show-page {
    grid-template-columns: 1fr;
  }
}
</style>