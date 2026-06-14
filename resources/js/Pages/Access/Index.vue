<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <template #title>Akses Berjenjang</template>
    <template #subtitle>Kelola izin akses anggota keluarga.</template>

    <div class="access-page">
      <div class="access-header">
        <button class="wd-btn-primary">+ Tambah Pengguna</button>
      </div>

      <div class="wd-card">
        <table class="access-table">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Peran</th>
              <th>Akses</th>
              <th>Status</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td>Siti Rahayu</td>
              <td>Istri</td>
              <td>Semua Dokumen</td>
              <td><span class="wd-badge success">Aktif</span></td>
            </tr>

            <tr>
              <td>Budi Ahmad</td>
              <td>Anak</td>
              <td>Properti</td>
              <td><span class="wd-badge gold">Pending</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.access-page {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.access-header {
  display: flex;
  justify-content: flex-end;
}

.access-table {
  width: 100%;
  border-collapse: collapse;
}

.access-table th,
.access-table td {
  padding: 12px;
  border-bottom: 1px solid #eee;
}
</style>