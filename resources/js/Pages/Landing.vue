<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <!-- NAVBAR -->
  <nav class="wd-navbar">
    <div class="wd-nav-logo">
      <div class="wd-nav-logo-icon">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
          <rect x="2" y="4" width="12" height="10" rx="2" fill="#2B0303"/>
          <rect x="4" y="6" width="8" height="6" rx="1" fill="#F0AD52" opacity="0.5"/>
          <circle cx="8" cy="9" r="1.5" fill="#2B0303"/>
          <rect x="6" y="2" width="4" height="3" rx="1" fill="#2B0303" stroke="#F0AD52" stroke-width="1"/>
        </svg>
      </div>
      <span>WarisDigital</span>
    </div>
    <div class="wd-nav-links">
      <a href="#fitur">Fitur</a>
      <a href="#harga">Harga</a>
      <a href="#tentang">Tentang</a>
      <Link href="/login" class="wd-btn-nav-masuk">Masuk</Link>
      <Link href="/register" class="wd-btn-nav-daftar">Daftar</Link>
    </div>
  </nav>

  <!-- HERO -->
  <section class="wd-hero">
    <div class="wd-hero-left">
      <div class="wd-hero-badge">🔒 Platform Waris Digital Terpercaya</div>
      <h1>Siapkan Warisan<br>Keluarga Anda<br>Hari Ini</h1>
      <p>Simpan, kelola, dan wariskan aset & dokumen penting keluarga secara aman, terstruktur, dan terlindungi.</p>
      <div class="wd-hero-btns">
        <Link href="/register" class="wd-btn-cta">Mulai Gratis →</Link>
        <a href="#cara-kerja" class="wd-btn-demo">Lihat Demo</a>
      </div>
    </div>
    <div class="wd-hero-visual">
      <div class="wd-vault-icon">🗄️</div>
      <p class="wd-vault-title">Brankas Digital Keluarga</p>
      <p class="wd-vault-sub">Dokumen & aset tersimpan aman</p>
      <div class="wd-doc-pills">
        <span class="wd-doc-pill">📄 KTP</span>
        <span class="wd-doc-pill">🏠 SHM</span>
        <span class="wd-doc-pill">🚗 BPKB</span>
        <span class="wd-doc-pill">💰 Tabungan</span>
        <span class="wd-doc-pill">📋 Akta</span>
      </div>
    </div>
  </section>

  <!-- TRUST BAR -->
  <div class="wd-trust-bar">
    <div class="wd-trust-item"><span>🔒 Enkripsi AES-256</span></div>
    <div class="wd-trust-item"><span>⚖️ Bermitra Notaris Resmi</span></div>
    <div class="wd-trust-item"><span>🏛️ Terdaftar Kominfo</span></div>
    <div class="wd-trust-item"><span>👨‍👩‍👧 10.000+ Keluarga</span></div>
  </div>

  <!-- FITUR -->
  <section class="wd-features" id="fitur">
    <h2 class="wd-section-title">Semua yang Anda Butuhkan</h2>
    <p class="wd-section-sub">Fitur lengkap untuk perencanaan waris digital yang komprehensif</p>
    <div class="wd-features-grid">
      <div class="wd-feature-card" v-for="fitur in fiturList" :key="fitur.judul">
        <div class="wd-feature-icon">{{ fitur.icon }}</div>
        <h4>{{ fitur.judul }}</h4>
        <p>{{ fitur.deskripsi }}</p>
      </div>
    </div>
  </section>

  <!-- CARA KERJA -->
  <section class="wd-steps" id="cara-kerja">
    <h2 class="wd-section-title">Cara Kerja WarisDigital</h2>
    <div class="wd-steps-row">
      <div class="wd-step-item" v-for="(step, i) in steps" :key="i">
        <div class="wd-step-num">{{ i + 1 }}</div>
        <h5>{{ step.judul }}</h5>
        <p>{{ step.deskripsi }}</p>
      </div>
      <div class="wd-step-line" v-if="i < steps.length - 1" :key="'line-' + i" />
    </div>
  </section>

  <!-- CTA BANNER -->
  <section class="wd-cta-banner">
    <h2>Mulai Lindungi Warisan Keluarga Anda</h2>
    <p>Bergabung dengan ribuan keluarga yang telah mempercayai WarisDigital</p>
    <Link href="/register" class="wd-btn-cta wd-btn-cta-lg">Daftar Sekarang — Gratis</Link>
  </section>

  <!-- FOOTER -->
  <footer class="wd-footer">
    <div class="wd-footer-inner">
      <div class="wd-footer-brand">
        <div class="wd-footer-logo">
          <div class="wd-nav-logo-icon" style="width:22px;height:22px;border-radius:5px;flex-shrink:0;"></div>
          <span>WarisDigital</span>
        </div>
        <p>Platform brankas digital keluarga untuk menyimpan dan mewariskan dokumen penting.</p>
      </div>
      <div>
        <h5>Fitur</h5>
        <a href="#">Vault Dokumen</a>
        <a href="#">Aset Mapper</a>
        <a href="#">Simulasi Waris</a>
        <a href="#">Mitra Notaris</a>
      </div>
      <div>
        <h5>Perusahaan</h5>
        <a href="#">Tentang Kami</a>
        <a href="#">Blog</a>
        <a href="#">Karier</a>
        <a href="#">Kontak</a>
      </div>
      <div>
        <h5>Dukungan</h5>
        <a href="#">Pusat Bantuan</a>
        <a href="#">Kebijakan Privasi</a>
        <a href="#">Syarat & Ketentuan</a>
      </div>
    </div>
    <div class="wd-footer-copy">
      <p>© 2026 WarisDigital. Hak Cipta Dilindungi.</p>
    </div>
  </footer>
</template>

<script>
export default {
  data() {
    return {
      fiturList: [
        { icon: '🗄️', judul: 'Vault Dokumen', deskripsi: 'Simpan semua dokumen penting dalam satu tempat yang aman dan terenkripsi' },
        { icon: '🗺️', judul: 'Aset Mapper', deskripsi: 'Petakan semua aset keluarga dengan visualisasi yang mudah dipahami' },
        { icon: '👥', judul: 'Akses Berjenjang', deskripsi: 'Atur siapa saja yang dapat mengakses dokumen tertentu' },
        { icon: '⏰', judul: 'Pengingat Dokumen', deskripsi: 'Notifikasi otomatis sebelum dokumen penting kedaluwarsa' },
        { icon: '⚖️', judul: 'Simulasi Waris', deskripsi: 'Hitung dan simulasikan pembagian warisan sesuai hukum Islam & perdata' },
        { icon: '⏳', judul: 'Kapsul Waktu', deskripsi: 'Tinggalkan pesan atau dokumen yang terbuka pada waktu yang ditentukan' },
      ],
      steps: [
        { judul: 'Daftar & Verifikasi', deskripsi: 'Buat akun dan verifikasi identitas' },
        { judul: 'Upload Dokumen', deskripsi: 'Unggah semua dokumen penting' },
        { judul: 'Atur Ahli Waris', deskripsi: 'Tentukan siapa yang mendapat akses' },
        { judul: 'Tenang & Aman', deskripsi: 'Warisan tersiapkan dengan baik' },
      ]
    }
  }
}
</script>

<style scoped>
/* NAVBAR */
.wd-navbar {
  background: var(--wd-dark);
  padding: 0 24px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.wd-nav-logo {
  display: flex;
  align-items: center;
  gap: 8px;
}
.wd-nav-logo-icon {
  width: 28px;
  height: 28px;
  background: var(--wd-gold);
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.wd-nav-logo span {
  color: #fff;
  font-size: 15px;
  font-weight: 600;
}
.wd-nav-links {
  display: flex;
  align-items: center;
  gap: 20px;
}
.wd-nav-links a {
  color: rgba(255,255,255,0.75);
  font-size: 13px;
  text-decoration: none;
}
.wd-btn-nav-masuk {
  border: 1px solid rgba(255,255,255,0.4);
  color: #fff !important;
  padding: 5px 14px;
  border-radius: 20px;
  font-size: 12px;
}
.wd-btn-nav-daftar {
  background: var(--wd-gold);
  color: var(--wd-dark) !important;
  padding: 5px 14px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
}

/* HERO */
.wd-hero {
  background: var(--wd-dark);
  padding: 48px 24px 40px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 32px;
  align-items: center;
}
.wd-hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(240,173,82,0.15);
  border: 1px solid rgba(240,173,82,0.3);
  color: var(--wd-gold);
  font-size: 11px;
  padding: 4px 12px;
  border-radius: 20px;
  margin-bottom: 16px;
}
.wd-hero-left h1 {
  color: #fff;
  font-size: 30px;
  font-weight: 700;
  line-height: 1.3;
  margin-bottom: 12px;
  font-family: Georgia, serif;
}
.wd-hero-left p {
  color: rgba(255,255,255,0.65);
  font-size: 14px;
  line-height: 1.7;
  margin-bottom: 22px;
}
.wd-hero-btns {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}
.wd-btn-cta {
  background: var(--wd-gold);
  color: var(--wd-dark);
  padding: 10px 22px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 700;
  text-decoration: none;
  display: inline-block;
}
.wd-btn-demo {
  border: 1px solid rgba(255,255,255,0.4);
  color: #fff;
  padding: 10px 22px;
  border-radius: 8px;
  font-size: 13px;
  text-decoration: none;
  display: inline-block;
}
.wd-hero-visual {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(240,173,82,0.2);
  border-radius: 12px;
  padding: 24px;
  text-align: center;
}
.wd-vault-icon {
  width: 72px;
  height: 72px;
  background: rgba(240,173,82,0.15);
  border: 2px solid var(--wd-gold);
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 12px;
  font-size: 32px;
}
.wd-vault-title {
  color: var(--wd-gold);
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 4px;
}
.wd-vault-sub {
  color: rgba(255,255,255,0.5);
  font-size: 12px;
  margin-bottom: 12px;
}
.wd-doc-pills {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  justify-content: center;
}
.wd-doc-pill {
  background: rgba(255,255,255,0.08);
  color: rgba(255,255,255,0.7);
  font-size: 11px;
  padding: 4px 10px;
  border-radius: 12px;
}

/* TRUST BAR */
.wd-trust-bar {
  background: var(--wd-gold);
  padding: 12px 24px;
  display: flex;
  align-items: center;
  justify-content: space-around;
  flex-wrap: wrap;
  gap: 8px;
}
.wd-trust-item span {
  font-size: 12px;
  font-weight: 600;
  color: var(--wd-dark);
}

/* FITUR */
.wd-features {
  padding: 40px 24px;
  background: var(--wd-bg);
}
.wd-section-title {
  text-align: center;
  font-size: 22px;
  font-weight: 700;
  color: var(--wd-dark);
  margin-bottom: 6px;
  font-family: Georgia, serif;
}
.wd-section-sub {
  text-align: center;
  font-size: 13px;
  color: var(--wd-muted);
  margin-bottom: 28px;
}
.wd-features-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 14px;
  max-width: 960px;
  margin: 0 auto;
}
.wd-feature-card {
  background: #fff;
  border-radius: 10px;
  padding: 18px;
  border: 1px solid var(--wd-border);
  border-top: 3px solid var(--wd-gold);
}
.wd-feature-icon {
  width: 38px;
  height: 38px;
  background: rgba(240,173,82,0.12);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  margin-bottom: 10px;
}
.wd-feature-card h4 {
  font-size: 14px;
  font-weight: 600;
  color: var(--wd-dark);
  margin-bottom: 6px;
}
.wd-feature-card p {
  font-size: 12px;
  color: var(--wd-muted);
  line-height: 1.6;
}

/* CARA KERJA */
.wd-steps {
  background: #fff;
  padding: 40px 24px;
}
.wd-steps .wd-section-title {
  margin-bottom: 28px;
}
.wd-steps-row {
  display: flex;
  align-items: flex-start;
  justify-content: center;
  gap: 0;
  max-width: 800px;
  margin: 0 auto;
}
.wd-step-item {
  flex: 1;
  text-align: center;
}
.wd-step-num {
  width: 38px;
  height: 38px;
  background: var(--wd-dark);
  color: var(--wd-gold);
  font-size: 16px;
  font-weight: 700;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 10px;
}
.wd-step-line {
  flex: none;
  width: 40px;
  margin-top: 19px;
  border-top: 2px dashed var(--wd-brown);
}
.wd-step-item h5 {
  font-size: 13px;
  font-weight: 600;
  color: var(--wd-dark);
  margin-bottom: 4px;
}
.wd-step-item p {
  font-size: 11px;
  color: var(--wd-muted);
}

/* CTA BANNER */
.wd-cta-banner {
  background: var(--wd-dark);
  padding: 48px 24px;
  text-align: center;
}
.wd-cta-banner h2 {
  color: #fff;
  font-size: 22px;
  font-family: Georgia, serif;
  margin-bottom: 10px;
}
.wd-cta-banner p {
  color: rgba(255,255,255,0.6);
  font-size: 13px;
  margin-bottom: 22px;
}
.wd-btn-cta-lg {
  padding: 12px 32px;
  font-size: 15px;
}

/* FOOTER */
.wd-footer {
  background: #1a0202;
}
.wd-footer-inner {
  padding: 28px 24px;
  display: grid;
  grid-template-columns: 1.5fr 1fr 1fr 1fr;
  gap: 20px;
}
.wd-footer-logo {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 10px;
}
.wd-footer-logo span {
  color: #fff;
  font-size: 14px;
  font-weight: 600;
}
.wd-footer-brand p {
  color: rgba(255,255,255,0.45);
  font-size: 11px;
  line-height: 1.6;
}
.wd-footer-inner h5 {
  color: var(--wd-gold);
  font-size: 11px;
  font-weight: 600;
  margin-bottom: 10px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.wd-footer-inner a {
  color: rgba(255,255,255,0.45);
  font-size: 11px;
  display: block;
  margin-bottom: 5px;
  text-decoration: none;
}
.wd-footer-inner a:hover {
  color: var(--wd-gold);
}
.wd-footer-copy {
  background: var(--wd-dark);
  padding: 12px 24px;
  text-align: center;
}
.wd-footer-copy p {
  color: rgba(255,255,255,0.3);
  font-size: 11px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
  .wd-hero {
    grid-template-columns: 1fr;
  }
  .wd-hero-visual {
    display: none;
  }
  .wd-features-grid {
    grid-template-columns: 1fr 1fr;
  }
  .wd-footer-inner {
    grid-template-columns: 1fr 1fr;
  }
  .wd-nav-links a:not(.wd-btn-nav-masuk):not(.wd-btn-nav-daftar) {
    display: none;
  }
}
</style>