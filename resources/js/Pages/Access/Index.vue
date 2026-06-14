<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <template #title>Akses Berjenjang</template>
    <template #subtitle>Kelola izin akses anggota keluarga.</template>

    <div class="access-page">
      <div class="access-header">
        <a href="/access/create" class="wd-btn-primary">
          + Tambah Pengguna
        </a>
      </div>

      <div class="wd-card access-card">
        <div class="access-title">
          <h3>Daftar Pengguna</h3>
          <p>Pengguna yang memiliki akses ke dokumen dan aset keluarga.</p>
        </div>

        <table class="access-table">
          <thead>
            <tr>
              <th>Nama Pengguna</th>
              <th>Peran</th>
              <th>Hak Akses</th>
              <th>Status</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td><strong>Siti Rahayu</strong></td>
              <td><span class="role-badge wife">Istri</span></td>
              <td>Semua Dokumen</td>
              <td><span class="wd-badge success">Aktif</span></td>
            </tr>

            <tr>
              <td><strong>Budi Ahmad</strong></td>
              <td><span class="role-badge child">Anak</span></td>
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

.access-card {
  padding: 24px;
  max-width: 980px;
  margin: 0 auto;
  width: 100%;
}

.access-title {
  margin-bottom: 18px;
}

.access-title h3 {
  margin: 0;
  color: var(--wd-dark);
}

.access-title p {
  margin-top: 4px;
  color: var(--wd-muted);
  font-size: 14px;
}

.access-table {
  width: 100%;
  border-collapse: collapse;
}

.access-table th {
  text-align: left;
  color: var(--wd-dark);
  font-size: 14px;
  font-weight: 700;
  padding: 14px 16px;
  border-bottom: 2px solid var(--wd-border);
}

.access-table td {
  padding: 14px 16px;
  border-bottom: 1px solid var(--wd-border);
  vertical-align: middle;
}

.access-table tbody tr:hover {
  background: #faf8ef;
}

.role-badge {
  padding: 4px 10px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 600;
}

.wife {
  background: #fde8e8;
  color: #c0392b;
}

.child {
  background: #eef2ff;
  color: #4338ca;
}
</style>