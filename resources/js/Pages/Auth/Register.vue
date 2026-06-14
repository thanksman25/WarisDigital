<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'
import { ref } from 'vue'

const step = ref(1)

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  phone: '',
  role: 'individual',
})

function nextStep() {
  if (!form.name || !form.email || !form.password || !form.password_confirmation) return
  step.value = 2
}

function submit() {
  form.post('/register', {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}

const roleOptions = [
  { value: 'individual', label: '👨‍👩‍👧 Kepala Keluarga' },
  { value: 'ahli_waris', label: '👤 Ahli Waris' },
  { value: 'notaris', label: '⚖️ Notaris' },
]
</script>

<template>
  <AuthLayout>
    <template #icon>👨‍👩‍👧</template>
    <template #visual-title>Bergabung<br>Bersama Kami</template>
    <template #visual-desc>Mulai siapkan warisan digital keluarga Anda hari ini</template>
    <template #trust>
      <p class="trust-item">✓ Gratis 30 hari pertama</p>
      <p class="trust-item">✓ Tidak perlu kartu kredit</p>
      <p class="trust-item">✓ Enkripsi penuh sejak hari pertama</p>
    </template>
    <template #quote>"Satu langkah kecil hari ini, ketenangan besar untuk keluarga."</template>

    <div class="reg-header">
      <div class="reg-logo">
        <div class="reg-logo-dot"></div>
        <span>WarisDigital</span>
      </div>
      <div class="step-bar">
        <div class="step-seg" :class="{ active: step === 1, done: step > 1 }">
          <div class="step-dot">{{ step > 1 ? '✓' : '1' }}</div>
          <p>Data Akun</p>
        </div>
        <div class="step-line"></div>
        <div class="step-seg" :class="{ active: step === 2 }">
          <div class="step-dot">2</div>
          <p>Peran & Konfirmasi</p>
        </div>
      </div>
    </div>

    <!-- STEP 1 -->
    <form v-if="step === 1" @submit.prevent="nextStep" class="reg-form">
      <h1>Buat Akun Baru</h1>
      <p class="reg-sub">Isi data dasar untuk mulai</p>

      <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <input id="name" v-model="form.name" type="text" class="form-input" :class="{ 'input-error': form.errors.name }" placeholder="Ahmad Sutarjo" autofocus />
        <p v-if="form.errors.name" class="error-msg">{{ form.errors.name }}</p>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" v-model="form.email" type="email" class="form-input" :class="{ 'input-error': form.errors.email }" placeholder="nama@email.com" />
        <p v-if="form.errors.email" class="error-msg">{{ form.errors.email }}</p>
      </div>

      <div class="form-group">
        <label for="phone">Nomor HP <span class="optional">(opsional)</span></label>
        <input id="phone" v-model="form.phone" type="tel" class="form-input" placeholder="08xxxxxxxxxx" />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input id="password" v-model="form.password" type="password" class="form-input" :class="{ 'input-error': form.errors.password }" placeholder="Minimal 8 karakter" />
        <p v-if="form.errors.password" class="error-msg">{{ form.errors.password }}</p>
      </div>

      <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input id="password_confirmation" v-model="form.password_confirmation" type="password" class="form-input" placeholder="Ulangi password" />
      </div>

      <button type="submit" class="btn-submit">Lanjut →</button>

      <p class="form-footer">
        Sudah punya akun?
        <Link href="/login" class="footer-link">Masuk di sini</Link>
      </p>
    </form>

    <!-- STEP 2 -->
    <form v-if="step === 2" @submit.prevent="submit" class="reg-form">
      <h1>Satu Langkah Lagi</h1>
      <p class="reg-sub">Pilih peran Anda di WarisDigital</p>

      <div class="form-group">
        <label>Peran Anda</label>
        <div class="role-grid">
          <div
            v-for="opt in roleOptions"
            :key="opt.value"
            class="role-opt"
            :class="{ selected: form.role === opt.value }"
            @click="form.role = opt.value"
          >
            {{ opt.label }}
          </div>
        </div>
        <p v-if="form.errors.role" class="error-msg">{{ form.errors.role }}</p>
      </div>

      <div class="reg-summary">
        <div class="summary-row">
          <span class="summary-label">Nama</span>
          <span class="summary-val">{{ form.name }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Email</span>
          <span class="summary-val">{{ form.email }}</span>
        </div>
        <div class="summary-row" v-if="form.phone">
          <span class="summary-label">HP</span>
          <span class="summary-val">{{ form.phone }}</span>
        </div>
      </div>

      <div class="reg-agree">
        <p>Dengan mendaftar, kamu menyetujui
          <a href="/privacy" class="footer-link">Kebijakan Privasi</a> dan
          <a href="/terms" class="footer-link">Syarat & Ketentuan</a> WarisDigital.
        </p>
      </div>

      <button type="submit" class="btn-submit" :disabled="form.processing">
        {{ form.processing ? 'Memproses...' : 'Daftar & Mulai Gratis →' }}
      </button>

      <button type="button" class="btn-back" @click="step = 1">← Kembali</button>

      <p class="form-footer">
        Sudah punya akun?
        <Link href="/login" class="footer-link">Masuk di sini</Link>
      </p>
    </form>
  </AuthLayout>
</template>

<style scoped>
.reg-header { margin-bottom: 24px; }
.reg-logo { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
.reg-logo-dot { width: 24px; height: 24px; background: var(--wd-dark); border-radius: 5px; }
.reg-logo span { font-size: 14px; font-weight: 700; color: var(--wd-dark); }

.step-bar { display: flex; align-items: center; }
.step-seg { text-align: center; }
.step-dot { width: 28px; height: 28px; border-radius: 50%; background: #e0d8cc; color: #999; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto 4px; transition: background 0.2s, color 0.2s; }
.step-seg p { font-size: 10px; color: #aaa; white-space: nowrap; }
.step-seg.active .step-dot { background: var(--wd-gold); color: var(--wd-dark); }
.step-seg.active p { color: var(--wd-dark); font-weight: 600; }
.step-seg.done .step-dot { background: var(--wd-dark); color: var(--wd-gold); }
.step-line { flex: 1; height: 1px; border-top: 2px dashed #ddd; margin: 0 10px 14px; }

.reg-form h1 { font-size: 20px; font-weight: 700; color: var(--wd-dark); font-family: Georgia, serif; margin-bottom: 4px; }
.reg-sub { font-size: 13px; color: var(--wd-muted); margin-bottom: 20px; }

.form-group { margin-bottom: 14px; }
.form-group label { display: block; font-size: 11px; font-weight: 600; color: var(--wd-dark); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
.optional { font-weight: 400; text-transform: none; color: var(--wd-muted); letter-spacing: 0; font-size: 10px; }

.form-input { width: 100%; background: #fff; border: 1px solid var(--wd-border); border-radius: 8px; padding: 10px 12px; font-size: 13px; color: var(--wd-dark); transition: border-color 0.2s; outline: none; font-family: inherit; }
.form-input:focus { border-color: var(--wd-gold); box-shadow: 0 0 0 3px rgba(240,173,82,0.12); }
.form-input::placeholder { color: #ccc; }
.input-error { border-color: #e74c3c !important; }
.error-msg { font-size: 11px; color: #e74c3c; margin-top: 4px; }

.role-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
.role-opt { border: 1px solid var(--wd-border); border-radius: 8px; padding: 10px 6px; text-align: center; font-size: 11px; color: var(--wd-muted); cursor: pointer; transition: all 0.2s; line-height: 1.4; }
.role-opt:hover { border-color: var(--wd-gold); color: var(--wd-dark); }
.role-opt.selected { border-color: var(--wd-gold); background: rgba(240,173,82,0.10); color: var(--wd-dark); font-weight: 600; }

.reg-summary { background: #fff; border: 1px solid var(--wd-border); border-radius: 8px; padding: 12px 14px; margin-bottom: 14px; }
.summary-row { display: flex; justify-content: space-between; font-size: 12px; padding: 4px 0; border-bottom: 1px solid #f5f0e8; }
.summary-row:last-child { border-bottom: none; }
.summary-label { color: var(--wd-muted); }
.summary-val { color: var(--wd-dark); font-weight: 600; }

.reg-agree { margin-bottom: 16px; }
.reg-agree p { font-size: 11px; color: var(--wd-muted); line-height: 1.6; }

.btn-submit { width: 100%; background: var(--wd-gold); color: var(--wd-dark); font-size: 14px; font-weight: 700; padding: 11px; border-radius: 8px; border: none; cursor: pointer; transition: opacity 0.2s; font-family: inherit; margin-bottom: 10px; }
.btn-submit:hover { opacity: 0.9; }
.btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }

.btn-back { width: 100%; background: transparent; color: var(--wd-muted); font-size: 13px; padding: 9px; border-radius: 8px; border: 1px solid var(--wd-border); cursor: pointer; font-family: inherit; margin-bottom: 10px; transition: border-color 0.2s; }
.btn-back:hover { border-color: var(--wd-brown); color: var(--wd-dark); }

.form-footer { text-align: center; font-size: 12px; color: var(--wd-muted); margin-top: 8px; }
.footer-link { color: var(--wd-brown); font-weight: 600; text-decoration: none; }
.footer-link:hover { text-decoration: underline; }
</style>