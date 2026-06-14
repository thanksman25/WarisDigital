<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  user: Object,
  stats: Object,
  recentActivities: Array,
  upcomingDocuments: Array,
  documentCompleteness: Object,
})

// Fallback data buat preview (nanti diganti dari controller)
const userData = props.user ?? {
  name: 'Ahmad Sutarjo',
  initials: 'AS',
  role: 'Kepala Keluarga',
}

const statsData = props.stats ?? {
  totalDokumen: 12,
  totalDokumenTrend: '↑ 3 dokumen bulan ini',
  totalAset: 5,
  totalAsetNilai: 'Rp 3,4 M total nilai',
  ahliWaris: 3,
  ahliWarisTrend: '1 menunggu konfirmasi',
  jatuhTempo: 2,
}

const activities = props.recentActivities ?? [
  { text: 'KTP Ahmad Sutarjo diperbarui', time: '2 jam lalu', color: '#F0AD52' },
  { text: 'Dewi Ahmad ditambahkan sebagai ahli waris', time: 'Kemarin, 15:30', color: '#A76430' },
  { text: 'SHM Properti Bogor diunggah', time: '3 hari lalu', color: '#2B0303' },
  { text: 'Simulasi waris dibuat & disimpan', time: '5 hari lalu', color: '#ccc' },
]

const documents = props.upcomingDocuments ?? [
  { name: 'KTP Ahmad Sutarjo', expiry: '17 Jun 2025', label: '3 hari', urgency: 'danger' },
  { name: 'BPKB Honda Civic', expiry: '28 Jun 2025', label: '14 hari', urgency: 'warn' },
  { name: 'Paspor Siti Rahayu', expiry: '10 Jul 2025', label: '26 hari', urgency: 'success' },
]

const completeness = props.documentCompleteness ?? [
  { label: 'Identitas & KTP', value: 100, color: '#27ae60' },
  { label: 'Properti', value: 75, color: '#F0AD52' },
  { label: 'Keuangan', value: 50, color: '#e67e22' },
  { label: 'Kendaraan', value: 100, color: '#27ae60' },
]

const today = new Date().toLocaleDateString('id-ID', {
  weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
})

const urgencyDotColor = {
  danger: '#e74c3c',
  warn: '#e67e22',
  success: '#27ae60',
}

const urgencyBadgeStyle = {
  danger: 'background:#fde8e8; color:#c0392b;',
  warn: 'background:#fef3e2; color:#d35400;',
  success: 'background:#e9f7ef; color:#1e8449;',
}
</script>

<template>
  <AppLayout>
    <template #title>Selamat pagi, Bapak {{ userData.name.split(' ')[0] }} 👋</template>
    <template #subtitle>{{ today }} — Semua sistem berjalan normal</template>

    <div class="wd-content">

      <!-- Stats Row -->
      <div class="stats-row mb-4">
        <div class="wd-card stat-card">
          <div class="stat-label">Total Dokumen</div>
          <div class="stat-top">
            <div class="stat-num">{{ statsData.totalDokumen }}</div>
            <div class="stat-icon" style="background:rgba(240,173,82,0.12);">📄</div>
          </div>
          <div class="stat-trend text-success">{{ statsData.totalDokumenTrend }}</div>
        </div>

        <div class="wd-card stat-card">
          <div class="stat-label">Aset Terdaftar</div>
          <div class="stat-top">
            <div class="stat-num">{{ statsData.totalAset }}</div>
            <div class="stat-icon" style="background:rgba(43,3,3,0.06);">💰</div>
          </div>
          <div class="stat-trend text-muted">{{ statsData.totalAsetNilai }}</div>
        </div>

        <div class="wd-card stat-card">
          <div class="stat-label">Ahli Waris</div>
          <div class="stat-top">
            <div class="stat-num">{{ statsData.ahliWaris }}</div>
            <div class="stat-icon" style="background:rgba(167,100,48,0.08);">👥</div>
          </div>
          <div class="stat-trend text-muted">{{ statsData.ahliWarisTrend }}</div>
        </div>

        <div class="wd-card stat-card">
          <div class="stat-label">Jatuh Tempo</div>
          <div class="stat-top">
            <div class="stat-num" style="color:#e67e22;">{{ statsData.jatuhTempo }}</div>
            <div class="stat-icon" style="background:rgba(230,126,34,0.1);">⏰</div>
          </div>
          <div class="stat-trend" style="color:#e67e22;">⚠ Perlu perhatian segera</div>
        </div>
      </div>

      <!-- Row 1: Aktivitas + Jatuh Tempo -->
      <div class="grid-2 mb-3">

        <div class="wd-card">
          <div class="widget-title">🕐 Aktivitas Terbaru <span class="text-muted" style="font-size:11px;">7 hari terakhir</span></div>
          <div v-for="(item, i) in activities" :key="i" class="timeline-item">
            <div class="tl-dot" :style="`background:${item.color};`"></div>
            <div>
              <div class="tl-text">{{ item.text }}</div>
              <div class="tl-time">{{ item.time }}</div>
            </div>
          </div>
        </div>

        <div class="wd-card">
          <div class="widget-title">⏰ Dokumen Jatuh Tempo <span class="text-muted" style="font-size:11px;">30 hari ke depan</span></div>
          <div v-for="(doc, i) in documents" :key="i" class="reminder-item">
            <div class="rem-dot" :style="`background:${urgencyDotColor[doc.urgency]};`"></div>
            <div class="rem-info">
              <div class="rem-name">{{ doc.name }}</div>
              <div class="rem-date">Habis: {{ doc.expiry }}</div>
            </div>
            <div class="rem-badge" :style="urgencyBadgeStyle[doc.urgency]">{{ doc.label }}</div>
          </div>
        </div>

      </div>

      <!-- Row 2: Kelengkapan + Aksi Cepat -->
      <div class="grid-2">

        <div class="wd-card">
          <div class="widget-title">📊 Kelengkapan Dokumen</div>
          <div v-for="(item, i) in completeness" :key="i" class="prog-item">
            <div class="prog-label">
              <span>{{ item.label }}</span>
              <span :style="`color:${item.color};`">{{ item.value }}%</span>
            </div>
            <div class="prog-bar">
              <div class="prog-fill" :style="`width:${item.value}%; background:${item.color};`"></div>
            </div>
          </div>
        </div>

        <div class="wd-card">
          <div class="widget-title">⚡ Aksi Cepat</div>
            <div class="shortcut-grid">
            <a href="/documents" class="shortcut-btn">
                <span class="sc-icon">📤</span>Upload Dokumen
            </a>
            <a href="/assets" class="shortcut-btn">
                <span class="sc-icon">💰</span>Tambah Aset
            </a>
            <a href="/access" class="shortcut-btn">
                <span class="sc-icon">👤</span>Undang Ahli Waris
            </a>
            <a href="/inheritance" class="shortcut-btn">
                <span class="sc-icon">⚖️</span>Simulasi Waris
            </a>
            </div>
        </div>

      </div>

    </div>
  </AppLayout>
</template>

<style scoped>
.stats-row {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
}

.stat-card {
  padding: 16px;
}

.stat-top {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin: 6px 0 8px;
}

.stat-num {
  font-size: 28px;
  font-weight: 700;
  color: var(--wd-dark);
}

.stat-icon {
  width: 38px;
  height: 38px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
}

.stat-label {
  font-size: 12px;
  color: var(--wd-muted);
}

.stat-trend {
  font-size: 11px;
  color: var(--wd-muted);
}

.grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
}

.mb-3 { margin-bottom: 14px; }
.mb-4 { margin-bottom: 18px; }

.widget-title {
  font-size: 13px;
  font-weight: 700;
  color: var(--wd-dark);
  margin-bottom: 12px;
}

/* Timeline */
.timeline-item {
  display: flex;
  gap: 10px;
  margin-bottom: 10px;
  align-items: flex-start;
}

.tl-dot {
  width: 9px;
  height: 9px;
  border-radius: 50%;
  flex-shrink: 0;
  margin-top: 3px;
}

.tl-text {
  font-size: 13px;
  color: #444;
  line-height: 1.4;
}

.tl-time {
  font-size: 11px;
  color: #bbb;
  margin-top: 2px;
}

/* Reminder */
.reminder-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 0;
  border-bottom: 1px solid #f5f0e8;
}

.reminder-item:last-child {
  border-bottom: none;
}

.rem-dot {
  width: 9px;
  height: 9px;
  border-radius: 50%;
  flex-shrink: 0;
}

.rem-info { flex: 1; }

.rem-name {
  font-size: 13px;
  font-weight: 600;
  color: var(--wd-dark);
}

.rem-date {
  font-size: 11px;
  color: #aaa;
  margin-top: 2px;
}

.rem-badge {
  font-size: 11px;
  padding: 3px 10px;
  border-radius: 999px;
  font-weight: 700;
}

/* Progress */
.prog-item {
  margin-bottom: 12px;
}

.prog-label {
  display: flex;
  justify-content: space-between;
  font-size: 12px;
  color: #555;
  margin-bottom: 5px;
}

.prog-bar {
  height: 6px;
  background: #f0ece4;
  border-radius: 4px;
  overflow: hidden;
}

.prog-fill {
  height: 100%;
  border-radius: 4px;
  transition: width 0.4s ease;
}

/* Shortcut */
.shortcut-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
}

.shortcut-btn {
  background: var(--wd-bg);
  border: 1px solid var(--wd-border);
  border-radius: 8px;
  padding: 12px 8px;
  text-align: center;
  font-size: 12px;
  font-weight: 600;
  color: var(--wd-dark);
  text-decoration: none;
  display: block;
  transition: background 0.15s;
}

.shortcut-btn:hover {
  background: rgba(240,173,82,0.12);
  color: var(--wd-brown);
}

.sc-icon {
  font-size: 20px;
  display: block;
  margin-bottom: 5px;
}

@media (max-width: 900px) {
  .stats-row {
    grid-template-columns: 1fr 1fr;
  }

  .grid-2 {
    grid-template-columns: 1fr;
  }
}
</style>