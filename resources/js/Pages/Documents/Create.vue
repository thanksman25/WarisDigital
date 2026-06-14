<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <template #title>Upload Dokumen</template>
    <template #subtitle>Tambahkan dokumen penting ke Vault keluarga.</template>

    <div class="create-page wd-card">
      <h2>📤 Upload Dokumen Baru</h2>

      <div class="form-grid">
        <div class="form-field">
          <label>Nama Dokumen</label>
          <input type="text" value="KTP Ahmad Sutarjo" />
        </div>

        <div class="form-field">
          <label>Kategori</label>
          <select>
            <option>Identitas/KTP</option>
            <option>Properti</option>
            <option>Kendaraan</option>
            <option>Keuangan</option>
          </select>
        </div>

        <div class="form-field">
          <label>Berlaku Hingga</label>
          <input type="date" />
        </div>

        <div class="form-field">
          <label>Visibilitas</label>
          <select>
            <option>Privat</option>
            <option>Keluarga</option>
            <option>Notaris</option>
          </select>
        </div>
      </div>

      <div class="dropzone">
        <div class="dz-icon">📁</div>
        <p>Seret & lepas file di sini, atau klik untuk memilih</p>
        <small>PDF, JPG, PNG — Maks. 10MB</small>
      </div>

      <div class="actions">
        <a href="/documents" class="wd-btn-outline">Batal</a>
        <button class="wd-btn-primary">Upload Dokumen →</button>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.create-page {
  max-width: 900px;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
  margin-top: 18px;
}

.form-field label {
  display: block;
  color: var(--wd-muted);
  font-weight: 700;
  margin-bottom: 6px;
}

.form-field input,
.form-field select {
  width: 100%;
  border: 1px solid var(--wd-border);
  border-radius: 10px;
  padding: 11px 12px;
}

.dropzone {
  margin-top: 20px;
  border: 2px dashed rgba(167, 100, 48, 0.3);
  border-radius: 14px;
  background: var(--wd-bg);
  padding: 32px;
  text-align: center;
}

.dz-icon {
  font-size: 34px;
}

.actions {
  margin-top: 18px;
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}
</style>