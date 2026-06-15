<script setup>
import { ref, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  guides: Array,
})

const allGuides = props.guides || []

const institutionIcons = {
  Bank: '🏦', Asuransi: '🛡️', Properti: '🏠', Kendaraan: '🚗', BPJS: '💼',
}

const activeFilter = ref('Semua')
const activeGuide = ref(null)

const filters = computed(() => ['Semua', ...new Set(allGuides.map(g => g.institution))])

const filtered = computed(() =>
  activeFilter.value === 'Semua'
    ? allGuides
    : allGuides.filter(g => g.institution === activeFilter.value)
)
</script>

<template>
  <AppLayout>
    <template #title>📋 Panduan Klaim</template>
    <template #subtitle>Langkah-langkah resmi untuk mengurus aset dan dokumen almarhum</template>

    <div class="wd-content">

      <!-- Filter Tabs -->
      <div class="filter-tabs mb-4">
        <button
          v-for="f in filters"
          :key="f"
          class="filter-tab"
          :class="{ active: activeFilter === f }"
          @click="activeFilter = f; activeGuide = null"
        >
          {{ institutionIcons[f] ?? '📋' }} {{ f }}
        </button>
      </div>

      <div class="claims-layout">

        <!-- List Panel -->
        <div class="guide-list">
          <div
            v-for="guide in filtered"
            :key="guide.id"
            class="wd-card guide-item"
            :class="{ 'guide-active': activeGuide?.id === guide.id }"
            @click="activeGuide = guide"
          >
            <div class="guide-item-header">
              <span class="guide-icon">{{ institutionIcons[guide.institution] ?? '📋' }}</span>
              <div>
                <div class="guide-item-title">{{ guide.title }}</div>
                <div class="guide-item-inst">{{ guide.institution }}</div>
              </div>
            </div>
            <div class="guide-item-time">⏱ {{ guide.estimated_time }}</div>
          </div>
        </div>

        <!-- Detail Panel -->
        <div class="guide-detail">

          <div v-if="!activeGuide" class="wd-card detail-empty">
            <div class="empty-icon">👈</div>
            <div class="empty-title">Pilih panduan di sebelah kiri</div>
            <div class="empty-desc">Klik salah satu panduan untuk melihat langkah-langkah lengkapnya</div>
          </div>

          <div v-else class="wd-card detail-card">
            <div class="detail-header">
              <span class="detail-icon-big">{{ institutionIcons[activeGuide.institution] ?? '📋' }}</span>
              <div>
                <div class="detail-title">{{ activeGuide.title }}</div>
                <div class="detail-meta">
                  <span class="wd-badge gold">{{ activeGuide.institution }}</span>
                  <span class="detail-time">⏱ {{ activeGuide.estimated_time }}</span>
                </div>
              </div>
            </div>

            <p class="detail-desc">{{ activeGuide.description }}</p>

            <div class="detail-section-title">📌 Langkah-langkah</div>
            <div class="steps-list">
              <div v-for="(step, i) in activeGuide.steps" :key="i" class="step-item">
                <div class="step-num">{{ i + 1 }}</div>
                <div class="step-text">{{ step }}</div>
              </div>
            </div>

            <div class="detail-section-title mt-4">📁 Dokumen yang Dibutuhkan</div>
            <div class="docs-list">
              <div v-for="(doc, i) in activeGuide.documents_required" :key="i" class="doc-item">
                <span class="doc-check">✓</span>
                <span>{{ doc }}</span>
              </div>
            </div>

            <div class="detail-cta">
              <a href="/documents" class="wd-btn-primary" style="text-decoration:none;">
                📤 Upload Dokumen Sekarang
              </a>
              <a href="/notary" class="wd-btn-outline" style="text-decoration:none;">
                🤝 Konsultasi Notaris
              </a>
            </div>
          </div>

        </div>

      </div>

    </div>
  </AppLayout>
</template>

<style scoped>
.mb-4 { margin-bottom: 20px; }
.mt-4 { margin-top: 20px; }

/* Filter Tabs */
.filter-tabs {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.filter-tab {
  padding: 7px 14px;
  border: 1px solid var(--wd-border);
  border-radius: 999px;
  background: white;
  font-size: 12px;
  font-weight: 600;
  color: var(--wd-muted);
  cursor: pointer;
  transition: all 0.15s;
  font-family: inherit;
}

.filter-tab.active {
  background: var(--wd-gold);
  color: var(--wd-dark);
  border-color: var(--wd-gold);
}

/* Layout */
.claims-layout {
  display: grid;
  grid-template-columns: 300px 1fr;
  gap: 14px;
  align-items: flex-start;
}

/* Guide List */
.guide-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.guide-item {
  padding: 14px;
  cursor: pointer;
  transition: all 0.15s;
}

.guide-item:hover {
  border-color: var(--wd-gold);
}

.guide-active {
  border-color: var(--wd-gold) !important;
  background: rgba(240,173,82,0.06) !important;
}

.guide-item-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 8px;
}

.guide-icon { font-size: 22px; }

.guide-item-title {
  font-size: 13px;
  font-weight: 700;
  color: var(--wd-dark);
}

.guide-item-inst {
  font-size: 11px;
  color: var(--wd-muted);
  margin-top: 2px;
}

.guide-item-time {
  font-size: 11px;
  color: var(--wd-brown);
  font-weight: 600;
}

/* Detail */
.detail-empty {
  padding: 60px 20px;
  text-align: center;
}

.detail-card { padding: 24px; }

.detail-header {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  margin-bottom: 16px;
}

.detail-icon-big { font-size: 36px; }

.detail-title {
  font-size: 18px;
  font-weight: 700;
  color: var(--wd-dark);
  margin-bottom: 8px;
}

.detail-meta {
  display: flex;
  align-items: center;
  gap: 10px;
}

.detail-time {
  font-size: 12px;
  color: var(--wd-muted);
  font-weight: 600;
}

.detail-desc {
  font-size: 13px;
  color: var(--wd-muted);
  line-height: 1.6;
  margin-bottom: 20px;
}

.detail-section-title {
  font-size: 13px;
  font-weight: 700;
  color: var(--wd-dark);
  padding-bottom: 8px;
  border-bottom: 1px solid var(--wd-border);
  margin-bottom: 14px;
}

/* Steps */
.steps-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.step-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
}

.step-num {
  width: 26px;
  height: 26px;
  border-radius: 50%;
  background: var(--wd-gold);
  color: var(--wd-dark);
  display: grid;
  place-items: center;
  font-size: 12px;
  font-weight: 700;
  flex-shrink: 0;
}

.step-text {
  font-size: 13px;
  color: #444;
  line-height: 1.5;
  padding-top: 4px;
}

/* Docs */
.docs-list {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
}

.doc-item {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 12px;
  color: #444;
  background: var(--wd-bg);
  padding: 8px 10px;
  border-radius: 6px;
  border: 1px solid var(--wd-border);
}

.doc-check {
  color: #27ae60;
  font-weight: 700;
}

/* CTA */
.detail-cta {
  display: flex;
  gap: 10px;
  margin-top: 24px;
}

.detail-cta a {
  flex: 1;
  text-align: center;
  padding: 11px;
}

/* Empty */
.empty-icon { font-size: 48px; margin-bottom: 12px; }
.empty-title { font-size: 16px; font-weight: 700; color: var(--wd-dark); margin-bottom: 6px; }
.empty-desc { font-size: 13px; color: var(--wd-muted); }

@media (max-width: 900px) {
  .claims-layout { grid-template-columns: 1fr; }
  .docs-list { grid-template-columns: 1fr; }
  .detail-cta { flex-direction: column; }
}
</style>