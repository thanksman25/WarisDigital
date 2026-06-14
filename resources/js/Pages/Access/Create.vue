<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <template #title>Tambah Pengguna</template>
    <template #subtitle>Undang anggota keluarga dan atur hak akses.</template>

    <div class="wd-card access-form">
      <h2>👥 Tambah Pengguna</h2>

      <div class="form-grid">
        <div class="form-field">
          <label>Nama</label>
          <input type="text" placeholder="Nama anggota keluarga">
        </div>

        <div class="form-field">
          <label>Email</label>
          <input type="email" placeholder="email@example.com">
        </div>

        <div class="form-field">
          <label>Peran</label>
          <select>
            <option>Istri</option>
            <option>Anak</option>
            <option>Saudara</option>
            <option>Notaris</option>
          </select>
        </div>

        <div class="form-field">
          <label>Hak Akses</label>
          <select>
            <option>Semua Dokumen</option>
            <option>Properti</option>
            <option>Keuangan</option>
            <option>Kendaraan</option>
          </select>
        </div>
      </div>

      <div class="actions">
        <a href="/access" class="wd-btn-outline">Batal</a>
        <button class="wd-btn-primary">Kirim Undangan →</button>
      </div>
    </div>
  </AppLayout>
</template>

<style>
.access-form {
  max-width: 900px;
  margin: 0 auto;
}

.access-form h2 {
  margin-bottom: 20px;
  color: var(--wd-dark);
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 18px;
}

.form-field {
  display: flex;
  flex-direction: column;
}

.form-field label {
  margin-bottom: 6px;
  font-size: 13px;
  font-weight: 600;
  color: var(--wd-dark);
}

.form-field input,
.form-field select {
  border: 1px solid var(--wd-border);
  border-radius: 10px;
  padding: 10px 12px;
  background: white;
}

.form-field input:focus,
.form-field select:focus {
  outline: none;
  border-color: var(--wd-gold);
}

.actions {
  margin-top: 24px;
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

@media (max-width: 768px) {
  .form-grid {
    grid-template-columns: 1fr;
  }

  .actions {
    flex-direction: column;
  }
}
</style>