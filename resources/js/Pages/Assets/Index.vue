<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <template #title>Aset Mapper</template>
    <template #subtitle>Kelola seluruh aset keluarga dalam satu tempat.</template>

    <div class="asset-page">
      <div class="asset-header">
        <button class="wd-btn-primary">+ Tambah Aset</button>
      </div>

      <div class="summary-grid">
        <div class="wd-card summary-card">
          <h4>Total Aset</h4>
          <h2>Rp 2,3 Miliar</h2>
        </div>

        <div class="wd-card summary-card">
          <h4>Properti</h4>
          <h2>2</h2>
        </div>

        <div class="wd-card summary-card">
          <h4>Kendaraan</h4>
          <h2>1</h2>
        </div>

        <div class="wd-card summary-card">
          <h4>Keuangan</h4>
          <h2>3</h2>
        </div>
      </div>

      <div class="wd-card">
        <table class="asset-table">
          <thead>
            <tr>
              <th>Nama Aset</th>
              <th>Kategori</th>
              <th>Nilai</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td>Rumah Jl. Merdeka</td>
              <td>Properti</td>
              <td>Rp 1,2 M</td>
            </tr>

            <tr>
              <td>Honda Civic</td>
              <td>Kendaraan</td>
              <td>Rp 320 Jt</td>
            </tr>

            <tr>
              <td>Rekening BCA</td>
              <td>Keuangan</td>
              <td>Rp 95 Jt</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.asset-page {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.asset-header {
  display: flex;
  justify-content: flex-end;
}

.summary-grid {
  display: grid;
  grid-template-columns: repeat(4,1fr);
  gap: 16px;
}

.summary-card h4 {
  margin: 0;
  color: var(--wd-muted);
}

.asset-table {
  width: 100%;
  border-collapse: collapse;
}

.asset-table th,
.asset-table td {
  padding: 12px;
  border-bottom: 1px solid #eee;
}
</style>