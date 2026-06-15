<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'

defineProps({
  permissions: {
    type: Array,
    default: () => []
  }
})

const revokeAccess = (id) => {
  if (confirm('Apakah Anda yakin ingin mencabut hak akses ini?')) {
    router.delete(`/access/${id}`)
  }
}
</script>

<template>
  <AppLayout>
    <template #title>Akses Berjenjang</template>
    <template #subtitle>Kelola izin akses anggota keluarga.</template>

    <div class="access-page">
      <div class="access-header">
        <Link href="/access/create" class="wd-btn-primary">
          + Tambah Hak Akses
        </Link>
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
              <th>Nama Dokumen</th>
              <th>Hak Akses</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="p in permissions" :key="p.id">
              <td><strong>{{ p.user?.name || 'Unknown User' }}</strong></td>
              <td>{{ p.document?.title || 'Unknown Document' }}</td>
              <td>
                <span class="role-badge child">{{ p.permission }}</span>
              </td>
              <td><span class="wd-badge success">Aktif</span></td>
              <td>
                <button
                  @click="revokeAccess(p.id)"
                  class="wd-btn-outline"
                  style="color:#c0392b; border-color:#fde8e8; background:#fde8e8; padding:5px 10px; font-size:12px; font-weight:700; border-radius:6px; cursor:pointer;"
                >
                  Cabut Akses
                </button>
              </td>
            </tr>
            <tr v-if="permissions.length === 0">
              <td colspan="5" style="text-align: center; color: #888;">Belum ada akses yang diberikan.</td>
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

.access-header Link,
.access-header a {
  text-decoration: none;
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

.child {
  background: #eef2ff;
  color: #4338ca;
  text-transform: uppercase;
}
</style>