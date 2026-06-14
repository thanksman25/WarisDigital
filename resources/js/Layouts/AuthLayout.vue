<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <div class="auth-shell">
    <!-- Sisi Kiri -->
    <div class="auth-visual">
      <div class="auth-visual-content">

        <Link href="/" class="auth-logo">
          <div class="auth-logo-icon">
            <svg width="18" height="18" viewBox="0 0 16 16" fill="none">
              <rect x="2" y="4" width="12" height="10" rx="2" fill="#2B0303"/>
              <rect x="4" y="6" width="8" height="6" rx="1" fill="#F0AD52" opacity="0.5"/>
              <circle cx="8" cy="9" r="1.5" fill="#2B0303"/>
              <rect x="6" y="2" width="4" height="3" rx="1" fill="#2B0303" stroke="#F0AD52" stroke-width="1"/>
            </svg>
          </div>
          <span>WarisDigital</span>
        </Link>

        <div class="auth-visual-body">
          <div class="auth-big-icon">
            <slot name="icon">🗄️</slot>
          </div>

          <h2>
            <slot name="visual-title">Selamat Datang</slot>
          </h2>

          <p class="auth-visual-desc">
            <slot name="visual-desc">Akses brankas digital keluarga Anda dengan aman</slot>
          </p>

          <div class="auth-trust-box">
            <slot name="trust">
              <p class="trust-item">🔒 Data terenkripsi AES-256</p>
              <p class="trust-item">✅ Sesi aman & terverifikasi</p>
              <p class="trust-item">🛡️ Tidak ada akses pihak ketiga</p>
            </slot>
          </div>

          <div class="auth-quote">
            <slot name="quote">"Warisan terbaik adalah persiapan yang matang."</slot>
          </div>
        </div>

      </div>
    </div>

    <!-- Sisi Kanan -->
    <div class="auth-form-side">
      <div class="auth-form-wrap">
        <slot />
      </div>
    </div>
  </div>
</template>

<style scoped>
.auth-shell {
  min-height: 100vh;
  display: grid;
  grid-template-columns: 1fr 1fr;
  background: var(--wd-bg);
}

/* ── KIRI ── */
.auth-visual {
  background: linear-gradient(160deg, #3d0505 0%, #2B0303 60%, #1a0202 100%);
  display: flex;
  flex-direction: column;
  padding: 36px 40px;
  position: relative;
  overflow: hidden;
}

/* Lingkaran dekoratif */
.auth-visual::before {
  content: '';
  position: absolute;
  width: 400px;
  height: 400px;
  border-radius: 50%;
  border: 1px solid rgba(240,173,82,0.12);
  top: -120px;
  right: -120px;
  pointer-events: none;
}
.auth-visual::after {
  content: '';
  position: absolute;
  width: 250px;
  height: 250px;
  border-radius: 50%;
  border: 1px solid rgba(240,173,82,0.08);
  bottom: 40px;
  left: -80px;
  pointer-events: none;
}

.auth-visual-content {
  display: flex;
  flex-direction: column;
  height: 100%;
  position: relative;
  z-index: 1;
}

.auth-logo {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
  margin-bottom: 0;
}
.auth-logo-icon {
  width: 36px;
  height: 36px;
  background: var(--wd-gold);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.auth-logo span {
  color: #ffffff;
  font-size: 18px;
  font-weight: 700;
  letter-spacing: -0.3px;
}

.auth-visual-body {
  margin: auto 0;
  padding: 40px 0 20px;
  text-align: center;
}

.auth-big-icon {
  font-size: 64px;
  margin-bottom: 20px;
  line-height: 1;
  filter: drop-shadow(0 4px 12px rgba(0,0,0,0.3));
}

.auth-visual-body h2 {
  color: #F0AD52;
  font-size: 26px;
  font-family: Georgia, serif;
  font-weight: 700;
  margin-bottom: 12px;
  line-height: 1.3;
  text-shadow: 0 2px 8px rgba(0,0,0,0.4);
}

.auth-visual-desc {
  color: rgba(255,255,255,0.80) !important;
  font-size: 14px !important;
  line-height: 1.7;
  margin-bottom: 24px;
}

.auth-trust-box {
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(240,173,82,0.25);
  border-radius: 12px;
  padding: 16px 20px;
  text-align: left;
  margin-bottom: 24px;
  backdrop-filter: blur(4px);
}

/* Override slot trust-item dari parent */
.auth-trust-box :deep(.trust-item),
.auth-trust-box p {
  color: rgba(255,255,255,0.85) !important;
  font-size: 13px !important;
  margin-bottom: 8px;
  line-height: 1.5;
  font-weight: 500;
}
.auth-trust-box :deep(.trust-item):last-child,
.auth-trust-box p:last-child {
  margin-bottom: 0;
}

.auth-quote {
  color: rgba(255,255,255,0.55);
  font-style: italic;
  font-size: 12px;
  border-top: 1px solid rgba(255,255,255,0.10);
  padding-top: 16px;
  line-height: 1.6;
}

/* ── KANAN ── */
.auth-form-side {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px 48px;
  background: var(--wd-bg);
}

.auth-form-wrap {
  width: 100%;
  max-width: 400px;
}

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
  .auth-shell {
    grid-template-columns: 1fr;
  }
  .auth-visual {
    display: none;
  }
  .auth-form-side {
    padding: 32px 24px;
    align-items: flex-start;
  }
}
</style>