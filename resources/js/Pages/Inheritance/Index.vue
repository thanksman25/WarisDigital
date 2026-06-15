<script setup>
import { ref, reactive, watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  simulations: Array,
})

const savedSims = ref(props.simulations ?? [])

watch(() => props.simulations, (newSims) => {
  savedSims.value = newSims ?? []
})

const lawLabels = { islam: 'Hukum Islam', perdata: 'Hukum Perdata', adat: 'Hukum Adat' }
const relationLabels = {
  suami: 'Suami', istri: 'Istri',
  anak_laki: 'Anak Laki-laki', anak_perempuan: 'Anak Perempuan',
  ayah: 'Ayah', ibu: 'Ibu',
}

const step = ref('list') // 'list' | 'form' | 'result'
const result = ref(null)
const loading = ref(false)
const errorMsg = ref('')

const form = reactive({
  title: '',
  total_assets: '',
  law_type: 'islam',
  heirs: [{ name: '', relation: 'anak_laki' }],
})

const addHeir = () => form.heirs.push({ name: '', relation: 'anak_laki' })
const removeHeir = (i) => { if (form.heirs.length > 1) form.heirs.splice(i, 1) }

const formatRp = (val) => {
  if (!val) return 'Rp 0'
  return 'Rp ' + Number(val).toLocaleString('id-ID')
}

const formatInput = (e) => {
  const raw = e.target.value.replace(/\D/g, '')
  form.total_assets = raw
  e.target.value = raw ? Number(raw).toLocaleString('id-ID') : ''
}

const calculate = () => {
  errorMsg.value = ''
  if (!form.title.trim()) { errorMsg.value = 'Judul simulasi wajib diisi.'; return }
  if (!form.total_assets || Number(form.total_assets) <= 0) { errorMsg.value = 'Total aset harus lebih dari 0.'; return }
  if (form.heirs.some(h => !h.name.trim())) { errorMsg.value = 'Nama semua ahli waris wajib diisi.'; return }

  loading.value = true

  // Simulasi kalkulasi lokal (sama persis logika controller)
  const total = Number(form.total_assets)
  const heirs = form.heirs
  const lawType = form.law_type
  let calcResult = []

  if (lawType === 'islam') {
    const shares = { suami: 0.25, istri: 0.125, anak_laki: 2, anak_perempuan: 1, ayah: 1/6, ibu: 1/6 }
    let totalShare = heirs.reduce((s, h) => s + (shares[h.relation] ?? 0), 0)
    calcResult = heirs.map(h => ({
      name: h.name,
      relation: h.relation,
      amount: totalShare > 0 ? Math.round((shares[h.relation] ?? 0) / totalShare * total) : 0,
    }))
  } else {
    const portion = Math.round(total / heirs.length)
    calcResult = heirs.map(h => ({ name: h.name, relation: h.relation, amount: portion }))
  }

  setTimeout(() => {
    result.value = {
      title: form.title,
      total_assets: total,
      law_type: lawType,
      heirs: calcResult,
    }
    loading.value = false
    step.value = 'result'
  }, 600)
}

const reset = () => {
  form.title = ''
  form.total_assets = ''
  form.law_type = 'islam'
  form.heirs = [{ name: '', relation: 'anak_laki' }]
  result.value = null
  errorMsg.value = ''
  step.value = 'form'
}

const saveSimulation = () => {
  if (!result.value) return
  loading.value = true
  router.post('/inheritance', {
    title: result.value.title,
    total_assets: result.value.total_assets,
    law_type: result.value.law_type,
    heirs: form.heirs.map(h => ({ name: h.name, relation: h.relation })),
  }, {
    onFinish: () => {
      loading.value = false
    },
    onSuccess: () => {
      savedSims.value = props.simulations ?? []
      step.value = 'list'
    }
  })
}

const deleteSimulation = (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus simulasi ini secara permanen?')) {
    router.delete(`/inheritance/${id}`, {
      onSuccess: () => {
        savedSims.value = props.simulations ?? []
      }
    })
  }
}
</script>

<template>
  <AppLayout>
    <template #title>⚖️ Simulasi Waris</template>
    <template #subtitle>Hitung pembagian waris berdasarkan hukum Islam, perdata, atau adat</template>

    <div class="wd-content">

      <!-- LIST SIMULASI TERSIMPAN -->
      <div v-if="step === 'list'">
        <div class="list-header mb-3">
          <div class="list-title">Simulasi Tersimpan</div>
          <button class="wd-btn-primary" @click="step = 'form'">+ Buat Simulasi Baru</button>
        </div>

        <div v-if="savedSims.length === 0" class="wd-card empty-state">
          <div class="empty-icon">⚖️</div>
          <div class="empty-title">Belum ada simulasi</div>
          <div class="empty-desc">Buat simulasi pertama Anda untuk melihat perkiraan pembagian waris</div>
          <button class="wd-btn-primary mt-3" @click="step = 'form'">Buat Simulasi</button>
        </div>

        <div v-else class="sim-grid">
          <div v-for="sim in savedSims" :key="sim.id" class="wd-card sim-card">
            <div class="sim-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
              <div class="sim-title" style="margin-bottom: 0;">{{ sim.title }}</div>
              <button class="delete-sim-btn" @click="deleteSimulation(sim.id)" style="background: none; border: none; color: #c0392b; cursor: pointer; font-size: 14px; padding: 0 4px;" title="Hapus Simulasi">🗑</button>
            </div>
            <div class="sim-meta">
              <span class="wd-badge gold">{{ lawLabels[sim.law_type] }}</span>
              <span class="sim-total">{{ formatRp(sim.total_assets) }}</span>
            </div>
            <div class="sim-heirs">
              <div v-for="(h, i) in (sim.result ?? [])" :key="i" class="sim-heir-row">
                <span>{{ h.name }} <span class="heir-rel">({{ relationLabels[h.relation] ?? h.relation }})</span></span>
                <span class="heir-amount">{{ formatRp(h.amount) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- FORM SIMULASI -->
      <div v-if="step === 'form'">
        <div class="list-header mb-3">
          <button class="back-btn" @click="step = 'list'">← Kembali</button>
          <div class="list-title">Buat Simulasi Baru</div>
        </div>

        <div class="form-grid">

          <!-- Kolom Kiri: Input -->
          <div class="wd-card form-card">
            <div class="form-section-title">📋 Informasi Simulasi</div>

            <div class="field mb-3">
              <label>Judul Simulasi</label>
              <input v-model="form.title" type="text" placeholder="mis: Pembagian Waris Ayah 2025" class="wd-input" />
            </div>

            <div class="field mb-3">
              <label>Total Aset (Rp)</label>
              <input
                type="text"
                :placeholder="'mis: 1.000.000.000'"
                class="wd-input"
                @input="formatInput"
              />
            </div>

            <div class="field mb-4">
              <label>Hukum Waris</label>
              <div class="law-options">
                <label v-for="opt in ['islam','perdata','adat']" :key="opt" class="law-option" :class="{ active: form.law_type === opt }">
                  <input type="radio" v-model="form.law_type" :value="opt" hidden />
                  {{ lawLabels[opt] }}
                </label>
              </div>
            </div>

            <div class="form-section-title">👥 Daftar Ahli Waris</div>

            <div v-for="(heir, i) in form.heirs" :key="i" class="heir-input mb-2">
              <input v-model="heir.name" type="text" placeholder="Nama ahli waris" class="wd-input" />
              <select v-model="heir.relation" class="wd-input wd-select">
                <option value="suami">Suami</option>
                <option value="istri">Istri</option>
                <option value="anak_laki">Anak Laki-laki</option>
                <option value="anak_perempuan">Anak Perempuan</option>
                <option value="ayah">Ayah</option>
                <option value="ibu">Ibu</option>
              </select>
              <button v-if="form.heirs.length > 1" @click="removeHeir(i)" class="remove-btn">✕</button>
            </div>

            <button @click="addHeir" class="add-heir-btn">+ Tambah Ahli Waris</button>

            <div v-if="errorMsg" class="error-msg mt-3">⚠ {{ errorMsg }}</div>

            <button @click="calculate" class="wd-btn-primary calc-btn mt-4" :disabled="loading">
              {{ loading ? 'Menghitung...' : '⚖️ Hitung Pembagian' }}
            </button>
          </div>

          <!-- Kolom Kanan: Info Hukum -->
          <div class="wd-card info-card">
            <div class="form-section-title">📖 Panduan Singkat</div>

            <div class="info-block" :class="{ 'info-active': form.law_type === 'islam' }">
              <div class="info-label">⚖️ Hukum Islam</div>
              <p>Pembagian berdasarkan Al-Qur'an & Hadits. Suami mendapat ¼ (jika ada anak), istri mendapat ⅛. Anak laki mendapat 2x bagian anak perempuan.</p>
            </div>

            <div class="info-block" :class="{ 'info-active': form.law_type === 'perdata' }">
              <div class="info-label">📜 Hukum Perdata</div>
              <p>Berdasarkan KUH Perdata. Aset dibagi rata di antara semua ahli waris yang terdaftar.</p>
            </div>

            <div class="info-block" :class="{ 'info-active': form.law_type === 'adat' }">
              <div class="info-label">🏡 Hukum Adat</div>
              <p>Mengikuti kesepakatan keluarga & tradisi setempat. Secara default dihitung rata seperti perdata.</p>
            </div>

            <div class="disclaimer mt-3">
              ⚠️ Hasil simulasi ini bersifat estimasi. Untuk kepastian hukum, konsultasikan dengan notaris atau pengadilan agama.
            </div>
          </div>

        </div>
      </div>

      <!-- HASIL SIMULASI -->
      <div v-if="step === 'result' && result">
        <div class="list-header mb-3">
          <button class="back-btn" @click="step = 'form'">← Ubah Input</button>
          <div class="list-title">Hasil Simulasi</div>
        </div>

        <div class="result-grid">

          <div class="wd-card result-summary">
            <div class="result-title">{{ result.title }}</div>
            <div class="result-meta">
              <span class="wd-badge gold">{{ lawLabels[result.law_type] }}</span>
              <span class="result-total">Total Aset: <strong>{{ formatRp(result.total_assets) }}</strong></span>
            </div>

            <div class="result-list mt-3">
              <div v-for="(h, i) in result.heirs" :key="i" class="result-row">
                <div class="result-heir">
                  <div class="result-avatar">{{ h.name.charAt(0) }}</div>
                  <div>
                    <div class="result-name">{{ h.name }}</div>
                    <div class="result-rel">{{ relationLabels[h.relation] ?? h.relation }}</div>
                  </div>
                </div>
                <div class="result-amount">{{ formatRp(h.amount) }}</div>
              </div>
            </div>
          </div>

          <div class="result-actions">
            <div class="wd-card action-card">
              <div class="form-section-title">Langkah Selanjutnya</div>
              <p style="font-size:13px; color:var(--wd-muted); line-height:1.6;">Simulasi ini sudah menggambarkan perkiraan pembagian. Untuk proses resmi, Anda perlu:</p>
              <ul class="next-steps">
                <li>📋 Kumpulkan semua dokumen aset</li>
                <li>⚖️ Konsultasi dengan notaris atau pengadilan agama</li>
                <li>✍️ Buat surat keterangan waris resmi</li>
                <li>🏦 Proses balik nama aset ke masing-masing ahli waris</li>
              </ul>
              <a href="/notary" class="wd-btn-primary" style="display:block; text-align:center; text-decoration:none; margin-top:14px;">
                🤝 Cari Mitra Notaris
              </a>
            </div>

            <div class="wd-card action-card mt-2">
              <button class="wd-btn-primary" style="width:100%; margin-bottom: 8px;" @click="saveSimulation" :disabled="loading">
                {{ loading ? 'Menyimpan...' : '💾 Simpan Simulasi ke Database' }}
              </button>
              <button class="wd-btn-outline" style="width:100%;" @click="reset">
                + Buat Simulasi Baru
              </button>
            </div>
          </div>

        </div>
      </div>

    </div>
  </AppLayout>
</template>

<style scoped>
.mb-2 { margin-bottom: 8px; }
.mb-3 { margin-bottom: 14px; }
.mb-4 { margin-bottom: 20px; }
.mt-2 { margin-top: 8px; }
.mt-3 { margin-top: 14px; }
.mt-4 { margin-top: 20px; }

.list-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.list-title {
  font-size: 16px;
  font-weight: 700;
  color: var(--wd-dark);
}

.back-btn {
  background: none;
  border: none;
  font-size: 13px;
  color: var(--wd-brown);
  cursor: pointer;
  font-weight: 600;
  padding: 0;
}

/* List */
.sim-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 14px;
}

.sim-card { padding: 16px; }

.sim-title {
  font-size: 14px;
  font-weight: 700;
  color: var(--wd-dark);
  margin-bottom: 8px;
}

.sim-meta {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 12px;
}

.sim-total {
  font-size: 12px;
  font-weight: 700;
  color: var(--wd-brown);
}

.sim-heir-row {
  display: flex;
  justify-content: space-between;
  font-size: 12px;
  color: #555;
  padding: 5px 0;
  border-bottom: 1px solid #f5f0e8;
}

.sim-heir-row:last-child { border-bottom: none; }

.heir-rel { color: var(--wd-muted); font-size: 11px; }

.heir-amount { font-weight: 700; color: var(--wd-dark); }

/* Form */
.form-grid {
  display: grid;
  grid-template-columns: 1.4fr 1fr;
  gap: 14px;
}

.form-card, .info-card { padding: 20px; }

.form-section-title {
  font-size: 13px;
  font-weight: 700;
  color: var(--wd-dark);
  margin-bottom: 14px;
  padding-bottom: 8px;
  border-bottom: 1px solid var(--wd-border);
}

.field label {
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

.wd-input:focus { border-color: var(--wd-gold); }

.wd-select { cursor: pointer; }

.law-options {
  display: flex;
  gap: 8px;
}

.law-option {
  flex: 1;
  text-align: center;
  padding: 9px;
  border: 1px solid var(--wd-border);
  border-radius: 8px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  color: var(--wd-muted);
  background: var(--wd-bg);
  transition: all 0.15s;
}

.law-option.active {
  border-color: var(--wd-gold);
  background: rgba(240,173,82,0.12);
  color: var(--wd-brown);
}

.heir-input {
  display: grid;
  grid-template-columns: 1fr 1fr auto;
  gap: 8px;
  align-items: center;
}

.remove-btn {
  width: 32px;
  height: 32px;
  border: 1px solid #fde8e8;
  background: #fde8e8;
  color: #c0392b;
  border-radius: 6px;
  cursor: pointer;
  font-size: 12px;
  flex-shrink: 0;
}

.add-heir-btn {
  background: none;
  border: 1px dashed var(--wd-border);
  border-radius: 8px;
  width: 100%;
  padding: 9px;
  font-size: 12px;
  font-weight: 600;
  color: var(--wd-brown);
  cursor: pointer;
  margin-top: 4px;
}

.add-heir-btn:hover { background: rgba(240,173,82,0.08); }

.error-msg {
  font-size: 12px;
  color: #c0392b;
  background: #fde8e8;
  padding: 8px 12px;
  border-radius: 8px;
}

.calc-btn {
  width: 100%;
  padding: 12px;
  font-size: 14px;
}

.calc-btn:disabled { opacity: 0.6; cursor: not-allowed; }

/* Info Card */
.info-block {
  padding: 12px;
  border-radius: 8px;
  border: 1px solid var(--wd-border);
  margin-bottom: 10px;
  transition: all 0.15s;
}

.info-block.info-active {
  border-color: var(--wd-gold);
  background: rgba(240,173,82,0.06);
}

.info-label {
  font-size: 12px;
  font-weight: 700;
  color: var(--wd-dark);
  margin-bottom: 5px;
}

.info-block p {
  font-size: 12px;
  color: var(--wd-muted);
  line-height: 1.5;
  margin: 0;
}

.disclaimer {
  font-size: 11px;
  color: var(--wd-muted);
  background: #fffbe8;
  border: 1px solid rgba(240,173,82,0.3);
  border-radius: 8px;
  padding: 10px 12px;
  line-height: 1.5;
}

/* Result */
.result-grid {
  display: grid;
  grid-template-columns: 1.6fr 1fr;
  gap: 14px;
}

.result-summary { padding: 20px; }

.result-title {
  font-size: 18px;
  font-weight: 700;
  color: var(--wd-dark);
  margin-bottom: 10px;
}

.result-meta {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 4px;
}

.result-total { font-size: 13px; color: var(--wd-muted); }

.result-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px 0;
  border-bottom: 1px solid #f5f0e8;
}

.result-row:last-child { border-bottom: none; }

.result-heir { display: flex; align-items: center; gap: 10px; }

.result-avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: var(--wd-brown);
  color: white;
  display: grid;
  place-items: center;
  font-weight: 700;
  font-size: 14px;
}

.result-name { font-size: 13px; font-weight: 600; color: var(--wd-dark); }

.result-rel { font-size: 11px; color: var(--wd-muted); }

.result-amount { font-size: 15px; font-weight: 700; color: var(--wd-brown); }

.action-card { padding: 18px; }

.next-steps {
  list-style: none;
  padding: 0;
  margin: 12px 0 0;
}

.next-steps li {
  font-size: 13px;
  color: #555;
  padding: 7px 0;
  border-bottom: 1px solid #f5f0e8;
  line-height: 1.4;
}

.next-steps li:last-child { border-bottom: none; }

/* Empty */
.empty-state { text-align: center; padding: 60px 20px; }
.empty-icon { font-size: 48px; margin-bottom: 12px; }
.empty-title { font-size: 16px; font-weight: 700; color: var(--wd-dark); margin-bottom: 6px; }
.empty-desc { font-size: 13px; color: var(--wd-muted); }

@media (max-width: 900px) {
  .sim-grid, .form-grid, .result-grid { grid-template-columns: 1fr; }
  .law-options { flex-direction: column; }
  .heir-input { grid-template-columns: 1fr 1fr; }
  .heir-input .remove-btn { grid-column: span 2; width: 100%; }
}
</style>