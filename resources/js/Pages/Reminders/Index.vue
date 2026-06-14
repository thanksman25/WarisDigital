<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <template #title>Pengingat Dokumen</template>
    <template #subtitle>Pantau dokumen yang akan kedaluwarsa.</template>

    <div class="reminder-page">
      <div class="wd-card reminder danger">
        <h4>KTP Ahmad Sutarjo</h4>
        <p>Berakhir 17 Juni 2025</p>
        <span>⚠ 3 Hari Lagi</span>
      </div>

      <div class="wd-card reminder warning">
        <h4>BPKB Honda Civic</h4>
        <p>Berakhir 28 Juni 2025</p>
        <span>⏰ 14 Hari Lagi</span>
      </div>

      <div class="wd-card reminder success">
        <h4>Paspor Siti Rahayu</h4>
        <p>Berakhir 10 Maret 2026</p>
        <span>✅ Aman</span>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.reminder-page {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.reminder {
  border-left: 5px solid;
}

.danger {
  border-color: #e74c3c;
}

.warning {
  border-color: #f39c12;
}

.success {
  border-color: #27ae60;
}
</style>