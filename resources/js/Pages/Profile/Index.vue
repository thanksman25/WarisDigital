<script setup>
import { ref, reactive } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  user: Object,
})

const userData = reactive(props.user ?? {
  name: 'Ahmad Sutarjo',
  email: 'ahmad@email.com',
  phone: '0812-xxxx-xxxx',
  nik: '317xxxxxxxxxxxx',
  role: 'Kepala Keluarga',
  joined: 'Januari 2024',
  plan: 'Premium',
})

// Tab
const activeTab = ref('informasi')
const tabs = [
  { key: 'informasi', label: 'Informasi' },
  { key: 'keamanan', label: 'Keamanan' },
  { key: 'notifikasi', label: 'Notifikasi' },
  { key: 'paket', label: 'Paket' },
]

// Modal edit profil
const showEditModal = ref(false)
const editForm = reactive({ name: '', email: '', phone: '' })
const editLoading = ref(false)
const editSuccess = ref(false)
const editError = ref('')

const openEdit = () => {
  editForm.name = userData.name
  editForm.email = userData.email
  editForm.phone = userData.phone
  editError.value = ''
  editSuccess.value = false
  showEditModal.value = true
}

const closeEdit = () => { showEditModal.value = false }

const saveEdit = async () => {
  editError.value = ''
  if (!editForm.name.trim()) { editError.value = 'Nama tidak boleh kosong.'; return }
  if (!editForm.email.includes('@')) { editError.value = 'Email tidak valid.'; return }

  editLoading.value = true
  // nanti diganti axios.put('/api/profile', editForm)
  await new Promise(r => setTimeout(r, 800))
  userData.name = editForm.name
  userData.email = editForm.email
  userData.phone = editForm.phone
  editLoading.value = false
  editSuccess.value = true
  setTimeout(() => { showEditModal.value = false; editSuccess.value = false }, 1200)
}

// Modal ganti password
const showPasswordModal = ref(false)
const passForm = reactive({ current: '', new: '', confirm: '' })
const passLoading = ref(false)
const passSuccess = ref(false)
const passError = ref('')

const openPassword = () => {
  passForm.current = ''
  passForm.new = ''
  passForm.confirm = ''
  passError.value = ''
  passSuccess.value = false
  showPasswordModal.value = true
}

const savePassword = async () => {
  passError.value = ''
  if (!passForm.current) { passError.value = 'Password lama wajib diisi.'; return }
  if (passForm.new.length < 8) { passError.value = 'Password baru minimal 8 karakter.'; return }
  if (passForm.new !== passForm.confirm) { passError.value = 'Konfirmasi password tidak cocok.'; return }

  passLoading.value = true
  await new Promise(r => setTimeout(r, 800))
  passLoading.value = false
  passSuccess.value = true
  setTimeout(() => { showPasswordModal.value = false; passSuccess.value = false }, 1200)
}

// Notifikasi toggles
const notifs = reactive({
  email: true,
  reminder: true,
  activity: false,
  promo: false,
})

// 2FA toggle
const twofa = ref(true)
</script>

<template>
  <AppLayout>
    <template #title>Profil Pengguna</template>
    <template #subtitle>Kelola informasi akun, keamanan, dan paket WarisDigital.</template>

    <div class="profile-page">

      <!-- Banner -->
      <div class="profile-banner">
        <div class="profile-banner-info">
          <div class="profile-avatar">{{ userData.name.split(' ').map(w => w[0]).slice(0,2).join('') }}</div>
          <div>
            <div class="profile-name">{{ userData.name }}</div>
            <div class="profile-role">👨‍👩‍👧 {{ userData.role }}</div>
            <div class="profile-meta">📅 Bergabung: {{ userData.joined }} · {{ userData.plan }}</div>
          </div>
        </div>
        <button class="edit-btn" @click="openEdit">✏️ Edit Profil</button>
      </div>

      <!-- Tabs -->
      <div class="profile-tabs">
        <button
          v-for="tab in tabs"
          :key="tab.key"
          class="profile-tab"
          :class="{ active: activeTab === tab.key }"
          @click="activeTab = tab.key"
        >
          {{ tab.label }}
        </button>
      </div>

      <!-- Tab: Informasi -->
      <div v-if="activeTab === 'informasi'" class="profile-body wd-card">
        <div class="field-row">
          <div>
            <div class="field-label">Nama Lengkap</div>
            <div class="field-val">{{ userData.name }}</div>
          </div>
          <button class="field-edit-btn" @click="openEdit">✏️</button>
        </div>
        <div class="field-row">
          <div>
            <div class="field-label">Email</div>
            <div class="field-val">{{ userData.email }}</div>
          </div>
          <button class="field-edit-btn" @click="openEdit">✏️</button>
        </div>
        <div class="field-row">
          <div>
            <div class="field-label">No. Telepon</div>
            <div class="field-val">{{ userData.phone }}</div>
          </div>
          <button class="field-edit-btn" @click="openEdit">✏️</button>
        </div>
        <div class="field-row">
          <div>
            <div class="field-label">NIK</div>
            <div class="field-val">{{ userData.nik }}</div>
          </div>
          <span class="field-edit-btn">🔒</span>
        </div>
      </div>

      <!-- Tab: Keamanan -->
      <div v-if="activeTab === 'keamanan'" class="wd-card security-section">
        <div class="section-title">🔐 Keamanan Akun</div>

        <div class="security-row">
          <div>
            <div class="security-label">Autentikasi 2 Faktor</div>
            <div class="security-sub">via Google Authenticator</div>
          </div>
          <div class="toggle-wrap" @click="twofa = !twofa">
            <div class="toggle" :class="{ on: twofa }">
              <div class="toggle-knob"></div>
            </div>
            <span class="toggle-label" :class="{ active: twofa }">{{ twofa ? 'Aktif' : 'Nonaktif' }}</span>
          </div>
        </div>

        <div class="security-row">
          <div>
            <div class="security-label">Password</div>
            <div class="security-sub">Terakhir diubah 3 bulan lalu</div>
          </div>
          <button class="wd-btn-outline" @click="openPassword">Ubah</button>
        </div>
      </div>

      <!-- Tab: Notifikasi -->
      <div v-if="activeTab === 'notifikasi'" class="wd-card security-section">
        <div class="section-title">🔔 Pengaturan Notifikasi</div>

        <div class="security-row" v-for="(val, key) in notifs" :key="key">
          <div>
            <div class="security-label">{{ { email: 'Notifikasi Email', reminder: 'Pengingat Dokumen', activity: 'Aktivitas Akun', promo: 'Promo & Info' }[key] }}</div>
            <div class="security-sub">{{ { email: 'Kirim email untuk setiap aktivitas penting', reminder: 'Ingatkan jika dokumen hampir kedaluwarsa', activity: 'Login baru dan perubahan akun', promo: 'Penawaran dan fitur terbaru WarisDigital' }[key] }}</div>
          </div>
          <div class="toggle-wrap" @click="notifs[key] = !notifs[key]">
            <div class="toggle" :class="{ on: notifs[key] }">
              <div class="toggle-knob"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tab: Paket -->
      <div v-if="activeTab === 'paket'" class="wd-card security-section">
        <div class="section-title">💎 Paket Langganan</div>

        <div class="plan-current">
          <div class="plan-badge">✨ Premium</div>
          <div class="plan-info">
            <div class="security-label">Paket Aktif</div>
            <div class="plan-name">WarisDigital Premium</div>
            <div class="security-sub">Aktif hingga 31 Desember 2025 · Perpanjang otomatis</div>
          </div>
        </div>

        <div class="plan-features">
          <div class="plan-feat">✅ Vault Dokumen tidak terbatas</div>
          <div class="plan-feat">✅ Simulasi Waris semua metode</div>
          <div class="plan-feat">✅ Akses Kapsul Waktu</div>
          <div class="plan-feat">✅ Prioritas bantuan notaris</div>
          <div class="plan-feat">✅ Multi-ahli waris hingga 10 orang</div>
        </div>

        <button class="wd-btn-outline" style="width:100%; margin-top:14px;">Kelola Langganan</button>
      </div>

    </div>

    <!-- Modal Edit Profil -->
    <div v-if="showEditModal" class="modal-overlay" @click.self="closeEdit">
      <div class="modal">
        <div class="modal-header">
          <div class="modal-title">✏️ Edit Profil</div>
          <button class="modal-close" @click="closeEdit">✕</button>
        </div>

        <div class="modal-body">
          <div class="field mb-3">
            <label>Nama Lengkap</label>
            <input v-model="editForm.name" type="text" class="wd-input" placeholder="Nama lengkap" />
          </div>
          <div class="field mb-3">
            <label>Email</label>
            <input v-model="editForm.email" type="email" class="wd-input" placeholder="Email" />
          </div>
          <div class="field mb-3">
            <label>No. Telepon</label>
            <input v-model="editForm.phone" type="text" class="wd-input" placeholder="No. Telepon" />
          </div>

          <div v-if="editError" class="error-msg">⚠ {{ editError }}</div>
          <div v-if="editSuccess" class="success-msg">✅ Profil berhasil diperbarui!</div>
        </div>

        <div class="modal-footer">
          <button class="wd-btn-outline" @click="closeEdit">Batal</button>
          <button class="wd-btn-primary" @click="saveEdit" :disabled="editLoading">
            {{ editLoading ? 'Menyimpan...' : 'Simpan' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Ganti Password -->
    <div v-if="showPasswordModal" class="modal-overlay" @click.self="showPasswordModal = false">
      <div class="modal">
        <div class="modal-header">
          <div class="modal-title">🔑 Ganti Password</div>
          <button class="modal-close" @click="showPasswordModal = false">✕</button>
        </div>

        <div class="modal-body">
          <div class="field mb-3">
            <label>Password Lama</label>
            <input v-model="passForm.current" type="password" class="wd-input" placeholder="Password saat ini" />
          </div>
          <div class="field mb-3">
            <label>Password Baru</label>
            <input v-model="passForm.new" type="password" class="wd-input" placeholder="Minimal 8 karakter" />
          </div>
          <div class="field mb-3">
            <label>Konfirmasi Password Baru</label>
            <input v-model="passForm.confirm" type="password" class="wd-input" placeholder="Ulangi password baru" />
          </div>

          <div v-if="passError" class="error-msg">⚠ {{ passError }}</div>
          <div v-if="passSuccess" class="success-msg">✅ Password berhasil diubah!</div>
        </div>

        <div class="modal-footer">
          <button class="wd-btn-outline" @click="showPasswordModal = false">Batal</button>
          <button class="wd-btn-primary" @click="savePassword" :disabled="passLoading">
            {{ passLoading ? 'Menyimpan...' : 'Simpan' }}
          </button>
        </div>
      </div>
    </div>

  </AppLayout>
</template>

<style scoped>
.profile-page {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

/* Banner */
.profile-banner {
  background: var(--wd-dark);
  border-radius: 18px;
  padding: 24px;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  color: white;
}

.profile-banner-info {
  display: flex;
  align-items: center;
  gap: 16px;
}

.profile-avatar {
  width: 72px;
  height: 72px;
  border-radius: 50%;
  background: var(--wd-brown);
  border: 3px solid var(--wd-gold);
  display: grid;
  place-items: center;
  color: white;
  font-size: 22px;
  font-weight: 700;
}

.profile-name { font-size: 22px; font-weight: 700; }
.profile-role { margin-top: 5px; color: var(--wd-gold); font-size: 14px; }
.profile-meta { margin-top: 5px; color: rgba(255,255,255,0.55); font-size: 13px; }

.edit-btn {
  background: rgba(240,173,82,0.15);
  border: 1px solid rgba(240,173,82,0.3);
  color: var(--wd-gold);
  border-radius: 10px;
  padding: 9px 14px;
  font-weight: 700;
  cursor: pointer;
  font-family: inherit;
}

/* Tabs */
.profile-tabs {
  background: white;
  border: 1px solid var(--wd-border);
  border-radius: 14px;
  padding: 8px;
  display: flex;
  gap: 8px;
}

.profile-tab {
  border: none;
  background: transparent;
  color: var(--wd-muted);
  padding: 10px 16px;
  border-radius: 10px;
  font-weight: 700;
  cursor: pointer;
  font-family: inherit;
  font-size: 13px;
  transition: all 0.15s;
}

.profile-tab.active {
  background: rgba(240,173,82,0.18);
  color: var(--wd-dark);
}

/* Informasi */
.profile-body { padding: 8px 20px; }

.field-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 18px 0;
  border-bottom: 1px solid var(--wd-border);
}

.field-row:last-child { border-bottom: none; }

.field-label {
  color: var(--wd-muted);
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  margin-bottom: 4px;
}

.field-val { color: var(--wd-dark); font-weight: 700; font-size: 15px; }

.field-edit-btn {
  background: none;
  border: none;
  font-size: 16px;
  cursor: pointer;
  color: var(--wd-brown);
  padding: 4px;
}

/* Keamanan & Notifikasi */
.security-section { display: flex; flex-direction: column; gap: 4px; padding: 20px; }
.section-title { font-weight: 700; color: var(--wd-dark); margin-bottom: 6px; font-size: 14px; }

.security-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 14px 0;
  border-top: 1px solid var(--wd-border);
}

.security-label { font-weight: 700; color: var(--wd-dark); font-size: 14px; }
.security-sub { margin-top: 4px; color: var(--wd-muted); font-size: 12px; }

/* Toggle */
.toggle-wrap {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
}

.toggle {
  width: 42px;
  height: 24px;
  border-radius: 999px;
  background: #ddd;
  position: relative;
  transition: background 0.2s;
}

.toggle.on { background: var(--wd-gold); }

.toggle-knob {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  background: white;
  position: absolute;
  top: 3px;
  left: 3px;
  transition: left 0.2s;
  box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}

.toggle.on .toggle-knob { left: 21px; }

.toggle-label { font-size: 12px; font-weight: 700; color: var(--wd-muted); }
.toggle-label.active { color: var(--wd-brown); }

/* Paket */
.plan-current {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 16px;
  background: rgba(240,173,82,0.08);
  border: 1px solid rgba(240,173,82,0.25);
  border-radius: 10px;
  margin-bottom: 16px;
}

.plan-badge {
  font-size: 28px;
}

.plan-name { font-size: 15px; font-weight: 700; color: var(--wd-dark); margin: 4px 0; }

.plan-features { display: flex; flex-direction: column; gap: 8px; }
.plan-feat { font-size: 13px; color: #444; }

/* Modal */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.45);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
}

.modal {
  background: white;
  border-radius: 16px;
  width: 100%;
  max-width: 440px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0,0,0,0.2);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 18px 20px;
  border-bottom: 1px solid var(--wd-border);
}

.modal-title { font-size: 15px; font-weight: 700; color: var(--wd-dark); }

.modal-close {
  background: none;
  border: none;
  font-size: 16px;
  cursor: pointer;
  color: var(--wd-muted);
}

.modal-body { padding: 20px; }
.modal-footer {
  padding: 14px 20px;
  border-top: 1px solid var(--wd-border);
  display: flex;
  gap: 10px;
  justify-content: flex-end;
}

/* Form */
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

.mb-3 { margin-bottom: 12px; }

.error-msg {
  font-size: 12px;
  color: #c0392b;
  background: #fde8e8;
  padding: 8px 12px;
  border-radius: 8px;
  margin-top: 8px;
}

.success-msg {
  font-size: 12px;
  color: #1e8449;
  background: #e9f7ef;
  padding: 8px 12px;
  border-radius: 8px;
  margin-top: 8px;
}

@media (max-width: 700px) {
  .profile-banner, .security-row { flex-direction: column; gap: 14px; align-items: flex-start; }
  .profile-tabs { flex-wrap: wrap; }
  .modal { margin: 16px; }
}
</style>