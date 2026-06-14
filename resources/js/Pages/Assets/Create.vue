<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <template #title>Tambah Aset</template>
    <template #subtitle>Tambahkan aset keluarga ke dalam Asset Mapper.</template>

    <div class="asset-create wd-card">
      <h2>🏦 Tambah Aset Baru</h2>

      <div class="form-grid">
        <div class="form-field">
          <label>Nama Aset</label>
          <input type="text" placeholder="Contoh: Rumah Banda Aceh" />
        </div>

        <div class="form-field">
          <label>Jenis Aset</label>
          <select>
            <option>Properti</option>
            <option>Kendaraan</option>
            <option>Tabungan</option>
            <option>Investasi</option>
            <option>Lainnya</option>
          </select>
        </div>

        <div class="form-field">
          <label>Nilai Aset</label>
          <input type="number" placeholder="500000000" />
        </div>

        <div class="form-field">
          <label>Pemilik</label>
          <input type="text" placeholder="Nama Pemilik" />
        </div>
      </div>

      <div class="form-field">
        <label>Keterangan</label>
        <textarea rows="4" placeholder="Informasi tambahan mengenai aset..."></textarea>
      </div>

      <div class="actions">
        <a href="/assets" class="wd-btn-outline">
          Batal
        </a>

        <button class="wd-btn-primary">
          Simpan Aset →
        </button>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.asset-create {
  max-width: 900px;
}

.asset-create h2 {
  margin-bottom: 20px;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
}

.form-field {
  margin-bottom: 16px;
}

.form-field label {
  display: block;
  margin-bottom: 6px;
  font-size: 13px;
  font-weight: 600;
  color: var(--wd-dark);
}

.form-field input,
.form-field select,
.form-field textarea {
  width: 100%;
  border: 1px solid var(--wd-border);
  border-radius: 10px;
  padding: 10px 12px;
}

.actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 20px;
}

@media (max-width: 768px) {
  .form-grid {
    grid-template-columns: 1fr;
  }
}
</style>