<script setup>
import { ref, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  documents: {
    type: Array,
    default: () => []
  }
})

const activeCategory = ref('Semua')
const searchQuery = ref('')

const filteredDocuments = computed(() => {
  let list = props.documents
  
  if (activeCategory.value !== 'Semua') {
    list = list.filter(d => d.file_type === activeCategory.value)
  }
  
  if (searchQuery.value.trim() !== '') {
    const query = searchQuery.value.toLowerCase()
    list = list.filter(d => {
      const matchTitle = d.title.toLowerCase().includes(query)
      const matchDesc = (d.description || '').toLowerCase().includes(query)
      return matchTitle || matchDesc
    })
  }
  
  return list
})

function editDocument(id) {
  alert('Fitur edit belum disambungkan ke backend untuk ID: ' + id)
}

function deleteDocument(id) {
  if (confirm('Apakah Anda yakin ingin menghapus dokumen ini secara permanen?')) {
    router.delete(`/documents/${id}`)
  }
}
</script>

<template>
  <AppLayout>
    <template #title>Vault Dokumen</template>
    <template #subtitle>12 dokumen tersimpan dengan aman • Terenkripsi AES-256</template>

    <div class="vault-page">
      <div class="vault-header wd-card">
        <div>
          <h2>🗄️ Vault Dokumen</h2>
          <p>Kelola dokumen penting keluarga dalam satu tempat.</p>
        </div>

        <a href="/documents/create" class="wd-btn-primary">
          + Upload Dokumen
        </a>
      </div>

        <div class="vault-tabs">
          <button
            class="vault-tab"
            :class="{ active: activeCategory === 'Semua' }"
            @click="activeCategory = 'Semua'"
          >
            Semua
          </button>

          <button
            class="vault-tab"
            :class="{ active: activeCategory === 'Identitas' }"
            @click="activeCategory = 'Identitas'"
          >
            KTP/Identitas
          </button>

          <button
            class="vault-tab"
            :class="{ active: activeCategory === 'Properti' }"
            @click="activeCategory = 'Properti'"
          >
            Properti
          </button>

          <button
            class="vault-tab"
            :class="{ active: activeCategory === 'Kendaraan' }"
            @click="activeCategory = 'Kendaraan'"
          >
            Kendaraan
          </button>

          <button
            class="vault-tab"
            :class="{ active: activeCategory === 'Keuangan' }"
            @click="activeCategory = 'Keuangan'"
          >
            Keuangan
          </button>

          <button
            class="vault-tab"
            :class="{ active: activeCategory === 'Lainnya' }"
            @click="activeCategory = 'Lainnya'"
          >
            Lainnya
          </button>
        </div>

      <div class="vault-toolbar">
        <input v-model="searchQuery" type="text" placeholder="🔍 Cari nama dokumen..." style="flex: 1; border: 1px solid var(--wd-border); border-radius: 10px; padding: 11px 14px; font-family: inherit; font-size: 14px; outline: none; background: white;" />
        <button class="wd-btn-outline">Filter ▾</button>
        <button class="wd-btn-outline">Urutkan ▾</button>
      </div>

      <div class="doc-grid" v-if="filteredDocuments.length > 0">
        <div class="doc-card" v-for="doc in filteredDocuments" :key="doc.id">
          <div class="doc-card-top">
            <div class="doc-file-icon icon-red">📄</div>
            <div>
              <div class="doc-name">{{ doc.title }}</div>
              <div class="doc-cat">{{ doc.file_type || 'Umum' }}</div>
              <div class="doc-note">{{ doc.description || 'Tidak ada deskripsi' }}</div>
            </div>
          </div>

          <div class="doc-card-bot">
            <div>
              <div class="doc-date">Upload: {{ new Date(doc.created_at).toLocaleDateString() }}</div>
              <div class="doc-status status-ok">✅ Aktif</div>
            </div>

            <div class="doc-actions">
              <a :href="`/documents/show?id=${doc.id}`" class="doc-action">👁</a>
              <button class="doc-action" @click="editDocument(doc.id)">✏️</button>
              <button class="doc-action" @click="deleteDocument(doc.id)">🗑</button>
            </div>
          </div>
        </div>
      </div>
      <div v-else style="text-align: center; padding: 40px; color: #888; border: 1px dashed #ccc; border-radius: 10px; background: white;">
        Belum ada dokumen.
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.vault-page {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.vault-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.vault-header h2 {
  margin: 0;
  font-size: 22px;
}

.vault-header p {
  margin: 6px 0 0;
  color: var(--wd-muted);
  font-size: 14px;
}

.vault-tabs {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.vault-tab {
  border: 1px solid var(--wd-border);
  background: white;
  color: var(--wd-muted);
  border-radius: 999px;
  padding: 8px 14px;
  font-size: 13px;
  cursor: pointer;
}

.vault-tab.active {
  background: var(--wd-dark);
  color: var(--wd-gold);
  border-color: var(--wd-dark);
}

.vault-toolbar {
  display: flex;
  gap: 10px;
  align-items: center;
}

.vault-search {
  flex: 1;
  background: white;
  border: 1px solid var(--wd-border);
  border-radius: 10px;
  padding: 11px 14px;
  color: var(--wd-muted);
  font-size: 14px;
}

.doc-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 16px;
}

.doc-card {
  background: white;
  border: 1px solid var(--wd-border);
  border-radius: 14px;
  overflow: hidden;
}

.doc-card-top {
  padding: 18px;
  display: flex;
  gap: 14px;
  border-bottom: 1px solid var(--wd-border);
}

.doc-file-icon {
  width: 46px;
  height: 54px;
  border-radius: 10px;
  display: grid;
  place-items: center;
  font-size: 22px;
}

.icon-red {
  background: #fde8e8;
}

.icon-green {
  background: #e9f7ef;
}

.icon-orange {
  background: #fef3e2;
}

.doc-name {
  font-size: 15px;
  font-weight: 700;
  color: var(--wd-dark);
}

.doc-cat {
  display: inline-block;
  margin-top: 5px;
  background: rgba(167, 100, 48, 0.1);
  color: var(--wd-brown);
  font-size: 12px;
  padding: 3px 9px;
  border-radius: 999px;
}

.doc-note,
.doc-date {
  color: var(--wd-muted);
  font-size: 12px;
  margin-top: 6px;
}

.doc-card-bot {
  padding: 14px 18px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.doc-status {
  display: inline-block;
  margin-top: 6px;
  font-size: 12px;
  padding: 4px 9px;
  border-radius: 999px;
  font-weight: 700;
}

.status-ok {
  background: #e9f7ef;
  color: #1e8449;
}

.status-warn {
  background: #fef3e2;
  color: #d35400;
}

.status-exp {
  background: #fde8e8;
  color: #c0392b;
}

.doc-actions {
  display: flex;
  gap: 10px;
  align-items: center;
}

.doc-action {
  border: none;
  background: transparent;
  text-decoration: none;
  cursor: pointer;
  font-size: 14px;
  padding: 0;
}

@media (max-width: 1100px) {
  .doc-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 700px) {
  .vault-header,
  .vault-toolbar {
    flex-direction: column;
    align-items: stretch;
  }
}
</style>