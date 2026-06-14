<script setup>
import { ref, computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  notaries: Array,
})

const list = props.notaries ?? [
  { id: 1, name: 'Dr. Hendra Wijaya, S.H., M.Kn.', city: 'Jakarta Selatan', province: 'DKI Jakarta', specialization: 'Waris & Properti', phone: '0812-3456-7890', email: 'hendra@notaris.id', rating: 4.9, review_count: 128 },
  { id: 2, name: 'Siti Rahayu, S.H., M.Kn.', city: 'Surabaya', province: 'Jawa Timur', specialization: 'Balik Nama & Akta', phone: '0813-9876-5432', email: 'siti@notaris.id', rating: 4.7, review_count: 94 },
  { id: 3, name: 'Bambang Santoso, S.H.', city: 'Bandung', province: 'Jawa Barat', specialization: 'Waris Islam & Adat', phone: '0811-2233-4455', email: 'bambang@notaris.id', rating: 4.6, review_count: 76 },
  { id: 4, name: 'Dewi Kusuma, S.H., M.Kn.', city: 'Medan', province: 'Sumatera Utara', specialization: 'Properti & Korporasi', phone: '0822-5566-7788', email: 'dewi@notaris.id', rating: 4.5, review_count: 61 },
  { id: 5, name: 'Ahmad Fauzi, S.H.', city: 'Makassar', province: 'Sulawesi Selatan', specialization: 'Waris & Akta Lahir', phone: '0833-1122-3344', email: 'fauzi@notaris.id', rating: 4.4, review_count: 43 },
  { id: 6, name: 'Rina Marlina, S.H., M.Kn.', city: 'Yogyakarta', province: 'DI Yogyakarta', specialization: 'Balik Nama Properti', phone: '0856-6677-8899', email: 'rina@notaris.id', rating: 4.8, review_count: 110 },
]

const searchCity = ref('')
const searchSpec = ref('')

const filtered = computed(() => {
  return list.filter(n => {
    const matchCity = n.city.toLowerCase().includes(searchCity.value.toLowerCase())
    const matchSpec = n.specialization.toLowerCase().includes(searchSpec.value.toLowerCase())
    return matchCity && matchSpec
  })
})

const renderStars = (rating) => {
  const full = Math.floor(rating)
  const half = rating % 1 >= 0.5
  let stars = '★'.repeat(full)
  if (half) stars += '½'
  return stars
}
</script>

<template>
  <AppLayout>
    <template #title>🤝 Mitra Notaris</template>
    <template #subtitle>Temukan notaris terverifikasi untuk kebutuhan legalisasi dokumen waris Anda</template>

    <div class="wd-content">

      <!-- Search Bar -->
      <div class="wd-card search-bar mb-4">
        <div class="search-grid">
          <div class="search-field">
            <label>🏙️ Kota / Kabupaten</label>
            <input
              v-model="searchCity"
              type="text"
              placeholder="Cari berdasarkan kota..."
              class="wd-input"
            />
          </div>
          <div class="search-field">
            <label>⚖️ Spesialisasi</label>
            <input
              v-model="searchSpec"
              type="text"
              placeholder="Cari berdasarkan spesialisasi..."
              class="wd-input"
            />
          </div>
        </div>
        <div class="search-meta">
          Menampilkan <strong>{{ filtered.length }}</strong> notaris terverifikasi
        </div>
      </div>

      <!-- Notary Grid -->
      <div v-if="filtered.length > 0" class="notary-grid">
        <div v-for="n in filtered" :key="n.id" class="wd-card notary-card">

          <div class="notary-header">
            <div class="notary-avatar">{{ n.name.charAt(0) }}</div>
            <div class="notary-meta">
              <div class="notary-name">{{ n.name }}</div>
              <div class="notary-location">📍 {{ n.city }}, {{ n.province }}</div>
            </div>
            <div class="verified-badge">✅ Terverifikasi</div>
          </div>

          <div class="notary-spec">
            <span class="wd-badge gold">{{ n.specialization }}</span>
          </div>

          <div class="notary-rating">
            <span class="stars">{{ renderStars(n.rating) }}</span>
            <span class="rating-num">{{ n.rating }}</span>
            <span class="rating-count">({{ n.review_count }} ulasan)</span>
          </div>

          <div class="notary-contacts">
            <a :href="`tel:${n.phone}`" class="contact-btn">📞 {{ n.phone }}</a>
            <a :href="`mailto:${n.email}`" class="contact-btn">✉️ Email</a>
          </div>

        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="wd-card empty-state">
        <div class="empty-icon">🔍</div>
        <div class="empty-title">Tidak ada notaris ditemukan</div>
        <div class="empty-desc">Coba ubah filter kota atau spesialisasi</div>
      </div>

    </div>
  </AppLayout>
</template>

<style scoped>
.mb-4 { margin-bottom: 20px; }

.search-bar { padding: 20px; }

.search-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
  margin-bottom: 12px;
}

.search-field label {
  display: block;
  font-size: 12px;
  font-weight: 600;
  color: var(--wd-muted);
  margin-bottom: 6px;
}

.wd-input {
  width: 100%;
  border: 1px solid var(--wd-border);
  border-radius: 8px;
  padding: 9px 12px;
  font-size: 13px;
  color: var(--wd-dark);
  background: var(--wd-bg);
  outline: none;
  font-family: inherit;
}

.wd-input:focus {
  border-color: var(--wd-gold);
}

.search-meta {
  font-size: 12px;
  color: var(--wd-muted);
}

.notary-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 14px;
}

.notary-card { padding: 18px; }

.notary-header {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  margin-bottom: 12px;
}

.notary-avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: var(--wd-brown);
  color: white;
  display: grid;
  place-items: center;
  font-size: 18px;
  font-weight: 700;
  flex-shrink: 0;
}

.notary-meta { flex: 1; }

.notary-name {
  font-size: 13px;
  font-weight: 700;
  color: var(--wd-dark);
  line-height: 1.3;
}

.notary-location {
  font-size: 11px;
  color: var(--wd-muted);
  margin-top: 3px;
}

.verified-badge {
  font-size: 10px;
  color: #1e8449;
  background: #e9f7ef;
  padding: 3px 8px;
  border-radius: 999px;
  font-weight: 700;
  white-space: nowrap;
}

.notary-spec { margin-bottom: 10px; }

.notary-rating {
  display: flex;
  align-items: center;
  gap: 5px;
  margin-bottom: 14px;
}

.stars {
  color: var(--wd-gold);
  font-size: 14px;
  letter-spacing: 1px;
}

.rating-num {
  font-size: 13px;
  font-weight: 700;
  color: var(--wd-dark);
}

.rating-count {
  font-size: 11px;
  color: var(--wd-muted);
}

.notary-contacts {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
}

.contact-btn {
  display: block;
  text-align: center;
  padding: 8px;
  border: 1px solid var(--wd-border);
  border-radius: 8px;
  font-size: 11px;
  font-weight: 600;
  color: var(--wd-dark);
  text-decoration: none;
  background: var(--wd-bg);
  transition: background 0.15s;
}

.contact-btn:hover {
  background: rgba(240,173,82,0.12);
  color: var(--wd-brown);
}

.empty-state {
  text-align: center;
  padding: 60px 20px;
}

.empty-icon { font-size: 48px; margin-bottom: 12px; }
.empty-title { font-size: 16px; font-weight: 700; color: var(--wd-dark); margin-bottom: 6px; }
.empty-desc { font-size: 13px; color: var(--wd-muted); }

@media (max-width: 900px) {
  .notary-grid { grid-template-columns: 1fr; }
  .search-grid { grid-template-columns: 1fr; }
}
</style>