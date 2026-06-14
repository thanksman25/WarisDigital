<script setup>
import { computed, ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const isLoading = ref(false)

const todayDate = 14

const reminders = ref([
  {
    id: 1,
    title: 'KTP Ahmad Sutarjo',
    expiredText: '17 Juni 2025',
    expiredDay: 17,
    daysLeft: 3,
    status: 'urgent',
  },
  {
    id: 2,
    title: 'BPKB Honda Civic',
    expiredText: '28 Juni 2025',
    expiredDay: 28,
    daysLeft: 14,
    status: 'soon',
  },
  {
    id: 3,
    title: 'Paspor Siti Rahayu',
    expiredText: '10 Maret 2026',
    expiredDay: null,
    daysLeft: 270,
    status: 'safe',
  },
])

const calendarDays = [
  null, null, null, null,
  1, 2, 3,
  4, 5, 6, 7, 8, 9, 10,
  11, 12, 13, 14, 15, 16, 17,
  18, 19, 20, 21, 22, 23, 24,
  25, 26, 27, 28, 29, 30, null,
]

const groupedReminders = computed(() => ({
  urgent: reminders.value.filter((item) => item.status === 'urgent'),
  soon: reminders.value.filter((item) => item.status === 'soon'),
  safe: reminders.value.filter((item) => item.status === 'safe'),
}))

const getDayClass = (day) => {
  if (!day) return ''

  const reminder = reminders.value.find((item) => item.expiredDay === day)

  if (day === todayDate) return 'today'
  if (reminder?.status === 'urgent') return 'urgent'
  if (reminder?.status === 'soon') return 'soon'

  return ''
}

const reminderSections = [
  {
    key: 'urgent',
    title: '🔴 MENDESAK — ≤7 HARI',
    titleClass: 'danger-title',
    cardClass: 'danger',
    badgeClass: 'danger',
  },
  {
    key: 'soon',
    title: '🟡 SEGERA — 8–30 HARI',
    titleClass: 'warning-title',
    cardClass: 'warning',
    badgeClass: 'gold',
  },
  {
    key: 'safe',
    title: '🟢 AMAN — >30 HARI',
    titleClass: 'safe-title',
    cardClass: 'safe',
    badgeClass: 'success',
  },
]
</script>

<template>
  <AppLayout>
    <template #title>Pengingat Dokumen</template>
    <template #subtitle>Pantau dokumen yang akan kedaluwarsa.</template>

    <div class="reminder-page">
      <div class="calendar-card wd-card">
        <div class="calendar-head">
          <h3>Juni 2025</h3>
          <div class="calendar-nav">◀ ▶</div>
        </div>

        <div class="calendar-grid">
          <div class="day-name">S</div>
          <div class="day-name">S</div>
          <div class="day-name">R</div>
          <div class="day-name">K</div>
          <div class="day-name">J</div>
          <div class="day-name">S</div>
          <div class="day-name">M</div>

          <div
            v-for="(day, index) in calendarDays"
            :key="index"
            class="day-wrapper"
          >
            <div
              v-if="day"
              class="day"
              :class="getDayClass(day)"
            >
              {{ day }}
            </div>
          </div>
        </div>

        <div class="calendar-legend">
          <span><b class="box urgent-box"></b> Mendesak</span>
          <span><b class="box soon-box"></b> Segera</span>
          <span><b class="box today-box"></b> Hari ini</span>
        </div>
      </div>

      <div v-if="isLoading" class="wd-card empty-state">
        Memuat data pengingat...
      </div>

      <template v-else>
        <div
          v-for="section in reminderSections"
          :key="section.key"
          class="reminder-section"
        >
          <h4 :class="section.titleClass">
            {{ section.title }}
          </h4>

          <div
            v-if="groupedReminders[section.key].length === 0"
            class="wd-card empty-state"
          >
            Tidak ada dokumen pada kategori ini.
          </div>

          <div
            v-for="item in groupedReminders[section.key]"
            :key="item.id"
            class="wd-card reminder-card"
            :class="section.cardClass"
          >
            <div>
              <h3>{{ item.title }}</h3>
              <p>Habis: {{ item.expiredText }}</p>
            </div>

            <span class="wd-badge" :class="section.badgeClass">
              {{ item.daysLeft }} hari
            </span>
          </div>
        </div>
      </template>
    </div>
  </AppLayout>
</template>

<style scoped>
.reminder-page {
  display: flex;
  flex-direction: column;
  gap: 18px;
  max-width: 980px;
}

.calendar-card {
  padding: 22px;
}

.calendar-head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

.calendar-head h3 {
  margin: 0;
  color: var(--wd-dark);
}

.calendar-nav {
  color: var(--wd-brown);
  font-weight: 700;
}

.calendar-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 8px;
}

.day-name {
  text-align: center;
  color: var(--wd-muted);
  font-size: 13px;
  font-weight: 700;
}

.day-wrapper {
  min-height: 38px;
}

.day {
  text-align: center;
  padding: 9px 0;
  border-radius: 10px;
  background: #fff;
  border: 1px solid var(--wd-border);
  color: var(--wd-dark);
  cursor: pointer;
  transition: 0.2s ease;
}

.day:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 14px rgba(61, 7, 7, 0.08);
}

.today {
  background: var(--wd-dark);
  color: var(--wd-gold);
  font-weight: 700;
}

.urgent {
  background: #fde8e8;
  color: #c0392b;
  font-weight: 700;
}

.soon {
  background: #fef3e2;
  color: #d35400;
  font-weight: 700;
}

.calendar-legend {
  display: flex;
  gap: 18px;
  flex-wrap: wrap;
  margin-top: 16px;
  color: var(--wd-muted);
  font-size: 13px;
}

.box {
  width: 12px;
  height: 12px;
  display: inline-block;
  border-radius: 3px;
  margin-right: 5px;
}

.urgent-box {
  background: #fde8e8;
}

.soon-box {
  background: #fef3e2;
}

.today-box {
  background: var(--wd-dark);
}

.reminder-section {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.reminder-section h4 {
  margin-bottom: 0;
  font-size: 14px;
  letter-spacing: 0.5px;
}

.danger-title {
  color: #c0392b;
}

.warning-title {
  color: #d35400;
}

.safe-title {
  color: #1e8449;
}

.reminder-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-left: 5px solid;
  transition: 0.2s ease;
}

.reminder-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 18px rgba(61, 7, 7, 0.08);
}

.reminder-card h3 {
  margin: 0;
  color: var(--wd-dark);
}

.reminder-card p {
  margin: 5px 0 0;
  color: var(--wd-muted);
}

.reminder-card.danger {
  border-left-color: #e74c3c;
}

.reminder-card.warning {
  border-left-color: #f39c12;
}

.reminder-card.safe {
  border-left-color: #27ae60;
}

.empty-state {
  padding: 18px;
  color: var(--wd-muted);
  font-size: 14px;
}

@media (max-width: 700px) {
  .reminder-page {
    max-width: 100%;
  }

  .calendar-card {
    padding: 16px;
  }

  .calendar-grid {
    gap: 5px;
  }

  .day-wrapper {
    min-height: 34px;
  }

  .day {
    padding: 7px 0;
    font-size: 13px;
  }

  .calendar-legend {
    gap: 10px;
  }

  .reminder-card {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }
}
</style>