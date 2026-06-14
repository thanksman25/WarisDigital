<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function submit() {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <AuthLayout>
    <template #icon>🗄️</template>
    <template #visual-title>Selamat Datang<br>Kembali</template>
    <template #visual-desc>Akses brankas digital keluarga Anda dengan aman dan terenkripsi</template>
    <template #trust>
      <p class="trust-item">🔒 Data terenkripsi AES-256</p>
      <p class="trust-item">✅ Sesi aman & terverifikasi</p>
      <p class="trust-item">🛡️ Tidak ada akses pihak ketiga</p>
    </template>
    <template #quote>"Warisan terbaik adalah persiapan yang matang." — WarisDigital</template>

    <div class="login-header">
      <div class="login-logo">
        <div class="login-logo-dot"></div>
        <span>WarisDigital</span>
      </div>
      <h1>Masuk ke Akun</h1>
      <p>Masuk ke brankas digital Anda</p>
    </div>

    <form @submit.prevent="submit" class="login-form">
      <div class="form-group">
        <label for="email">Email</label>
        <input
          id="email"
          v-model="form.email"
          type="email"
          class="form-input"
          :class="{ 'input-error': form.errors.email }"
          placeholder="nama@email.com"
          autocomplete="email"
          autofocus
        />
        <p v-if="form.errors.email" class="error-msg">{{ form.errors.email }}</p>
      </div>

      <div class="form-group">
        <div class="label-row">
          <label for="password">Password</label>
          <Link href="/forgot-password" class="forgot-link">Lupa Password?</Link>
        </div>
        <input
          id="password"
          v-model="form.password"
          type="password"
          class="form-input"
          :class="{ 'input-error': form.errors.password }"
          placeholder="••••••••••"
          autocomplete="current-password"
        />
        <p v-if="form.errors.password" class="error-msg">{{ form.errors.password }}</p>
      </div>

      <div class="remember-row">
        <label class="remember-label">
          <input type="checkbox" v-model="form.remember" class="remember-check" />
          <span>Ingat saya</span>
        </label>
      </div>

      <button type="submit" class="btn-submit" :disabled="form.processing">
        {{ form.processing ? 'Memproses...' : 'Masuk ke Dashboard →' }}
      </button>

      <div class="divider"><span>atau</span></div>

      <button type="button" class="btn-google">
        <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
        Masuk dengan Google
      </button>
    </form>

    <p class="form-footer">
      Belum punya akun?
      <Link href="/register" class="footer-link">Daftar di sini</Link>
    </p>
  </AuthLayout>
</template>

<style scoped>
.login-header { margin-bottom: 28px; }
.login-logo { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
.login-logo-dot { width: 24px; height: 24px; background: var(--wd-dark); border-radius: 5px; }
.login-logo span { font-size: 14px; font-weight: 700; color: var(--wd-dark); }
.login-header h1 { font-size: 22px; font-weight: 700; color: var(--wd-dark); font-family: Georgia, serif; margin-bottom: 4px; }
.login-header p { font-size: 13px; color: var(--wd-muted); }

.login-form { display: flex; flex-direction: column; }
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 11px; font-weight: 600; color: var(--wd-dark); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
.label-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
.label-row label { margin-bottom: 0; }
.forgot-link { font-size: 11px; color: var(--wd-brown); text-decoration: none; }
.forgot-link:hover { text-decoration: underline; }

.form-input { width: 100%; background: #fff; border: 1px solid var(--wd-border); border-radius: 8px; padding: 10px 12px; font-size: 13px; color: var(--wd-dark); transition: border-color 0.2s; outline: none; font-family: inherit; }
.form-input:focus { border-color: var(--wd-gold); box-shadow: 0 0 0 3px rgba(240,173,82,0.12); }
.form-input::placeholder { color: #ccc; }
.input-error { border-color: #e74c3c !important; }
.error-msg { font-size: 11px; color: #e74c3c; margin-top: 4px; }

.remember-row { margin-bottom: 20px; }
.remember-label { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--wd-muted); cursor: pointer; }
.remember-check { accent-color: var(--wd-gold); width: 14px; height: 14px; }

.btn-submit { width: 100%; background: var(--wd-gold); color: var(--wd-dark); font-size: 14px; font-weight: 700; padding: 11px; border-radius: 8px; border: none; cursor: pointer; transition: opacity 0.2s; font-family: inherit; margin-bottom: 14px; }
.btn-submit:hover { opacity: 0.9; }
.btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }

.divider { text-align: center; font-size: 11px; color: #ccc; margin: 4px 0 12px; position: relative; }
.divider::before, .divider::after { content: ''; position: absolute; top: 50%; width: 42%; height: 1px; background: #e8e0d0; }
.divider::before { left: 0; } .divider::after { right: 0; }
.divider span { background: var(--wd-bg); padding: 0 8px; position: relative; z-index: 1; }

.btn-google { width: 100%; background: #fff; border: 1px solid #e0d8cc; border-radius: 8px; padding: 10px; font-size: 13px; color: #444; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; font-family: inherit; transition: border-color 0.2s; }
.btn-google:hover { border-color: var(--wd-brown); }

.form-footer { text-align: center; font-size: 12px; color: var(--wd-muted); margin-top: 20px; }
.footer-link { color: var(--wd-brown); font-weight: 600; text-decoration: none; }
.footer-link:hover { text-decoration: underline; }
</style>