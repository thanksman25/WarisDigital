<script setup>
import { computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  assets: {
    type: Array,
    default: () => []
  }
})

const totalValue = computed(() => {
  return props.assets.reduce((sum, asset) => sum + (asset.value || 0), 0)
})

const countProperty = computed(() => props.assets.filter(a => a.type === 'rumah' || a.type === 'tanah').length)
const countVehicle = computed(() => props.assets.filter(a => a.type === 'kendaraan').length)
const countFinance = computed(() => props.assets.filter(a => a.type === 'tabungan' || a.type === 'investasi').length)

const formatRupiah = (number) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number)
}
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
          <h2>{{ formatRupiah(totalValue) }}</h2>
        </div>

        <div class="wd-card summary-card">
          <h4>Properti</h4>
          <h2>{{ countProperty }}</h2>
        </div>

        <div class="wd-card summary-card">
          <h4>Kendaraan</h4>
          <h2>{{ countVehicle }}</h2>
        </div>

        <div class="wd-card summary-card">
          <h4>Keuangan</h4>
          <h2>{{ countFinance }}</h2>
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
            <tr v-for="asset in assets" :key="asset.id">
            <td>{{ asset.name }}</td>

            <td>
                <span class="cat-badge" :class="asset.type === 'kendaraan' ? 'vehicle' : (asset.type === 'tabungan' || asset.type === 'investasi' ? 'finance' : 'property')">
                {{ asset.type }}
                </span>
            </td>

            <td>
                <span class="asset-value">
                {{ formatRupiah(asset.value) }}
                </span>
            </td>
            </tr>
            <tr v-if="assets.length === 0">
              <td colspan="3" style="text-align: center; color: #888;">Belum ada aset terdaftar.</td>
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