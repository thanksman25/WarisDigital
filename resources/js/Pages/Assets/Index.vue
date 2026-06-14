<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <template #title>Aset Mapper</template>
    <template #subtitle>Kelola seluruh aset keluarga dalam satu tempat.</template>

    <div class="asset-page">
        <div class="asset-header">
        <a href="/assets/create" class="wd-btn-primary">
            + Tambah Aset
        </a>
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
        <div class="asset-table-header">
        <div>
            <h3>📋 Daftar Aset Keluarga</h3>
            <p>Ringkasan seluruh aset yang telah terdaftar.</p>
        </div>
        </div>
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
            <td>🏠 Rumah Jl. Merdeka</td>

            <td>
                <span class="cat-badge property">
                Properti
                </span>
            </td>

            <td>
                <span class="asset-value">
                Rp 1,2 M
                </span>
            </td>
            </tr>

            <tr>
            <td>🚗 Honda Civic</td>

            <td>
                <span class="cat-badge vehicle">
                Kendaraan
                </span>
            </td>

            <td>
                <span class="asset-value">
                Rp 320 Jt
                </span>
            </td>
            </tr>

            <tr>
            <td>🏦 Rekening BCA</td>

            <td>
                <span class="cat-badge finance">
                Keuangan
                </span>
            </td>

            <td>
                <span class="asset-value">
                Rp 95 Jt
                </span>
            </td>
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

.asset-table-header {
  margin-bottom: 16px;
}

.asset-table-header h3 {
  margin: 0;
}

.asset-table-header p {
  margin-top: 4px;
  color: var(--wd-muted);
}

.asset-table {
  width: 100%;
  border-collapse: collapse;
}

.asset-table th {
  text-align: left;
  padding: 14px;
  border-bottom: 2px solid var(--wd-border);
}

.asset-table td {
  padding: 14px;
  border-bottom: 1px solid var(--wd-border);
}

.asset-table tbody tr:hover {
  background: #faf8ef;
}

.asset-value {
  background: rgba(240,173,82,.15);
  color: var(--wd-brown);
  padding: 4px 10px;
  border-radius: 999px;
  font-weight: 700;
}

.cat-badge {
  padding: 4px 10px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 600;
}

.property {
  background: #e9f7ef;
  color: #1e8449;
}

.vehicle {
  background: #fef3e2;
  color: #d35400;
}

.finance {
  background: #eef2ff;
  color: #4338ca;
}

.action-cell {
  white-space: nowrap;
  cursor: pointer;
}
</style>