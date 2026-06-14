<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <template #title>Profil Pengguna</template>
    <template #subtitle>Kelola informasi akun, keamanan, dan paket WarisDigital.</template>

    <div class="profile-page">
      <div class="profile-banner">
        <div class="profile-banner-info">
          <div class="profile-avatar">AS</div>

          <div>
            <div class="profile-name">Ahmad Sutarjo</div>
            <div class="profile-role">👨‍👩‍👧 Kepala Keluarga</div>
            <div class="profile-meta">📅 Bergabung: Januari 2024 · Premium</div>
          </div>
        </div>

        <button class="edit-btn">✏️ Edit Profil</button>
      </div>

      <div class="profile-tabs">
        <button class="profile-tab active">Informasi</button>
        <button class="profile-tab">Keamanan</button>
        <button class="profile-tab">Notifikasi</button>
        <button class="profile-tab">Paket</button>
      </div>

      <div class="profile-body wd-card">
        <div class="field-row">
          <div>
            <div class="field-label">Nama Lengkap</div>
            <div class="field-val">Ahmad Sutarjo</div>
          </div>
          <div class="field-edit">✏️</div>
        </div>

        <div class="field-row">
          <div>
            <div class="field-label">Email</div>
            <div class="field-val">ahmad@email.com</div>
          </div>
          <div class="field-edit">✏️</div>
        </div>

        <div class="field-row">
          <div>
            <div class="field-label">No. Telepon</div>
            <div class="field-val">0812-xxxx-xxxx</div>
          </div>
          <div class="field-edit">✏️</div>
        </div>

        <div class="field-row">
          <div>
            <div class="field-label">NIK</div>
            <div class="field-val">317xxxxxxxxxxxx</div>
          </div>
          <div class="field-edit">🔒</div>
        </div>
      </div>

      <div class="security-section wd-card">
        <div class="section-title">🔐 Keamanan Akun</div>

        <div class="security-row">
          <div>
            <div class="security-label">Autentikasi 2 Faktor</div>
            <div class="security-sub">via Google Authenticator</div>
          </div>
          <span class="wd-badge success">🟢 Aktif</span>
        </div>

        <div class="security-row">
          <div>
            <div class="security-label">Password</div>
            <div class="security-sub">Terakhir diubah 3 bulan lalu</div>
          </div>
          <button class="wd-btn-outline">Ubah</button>
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

.profile-name {
  font-size: 22px;
  font-weight: 700;
}

.profile-role {
  margin-top: 5px;
  color: var(--wd-gold);
  font-size: 14px;
}

.profile-meta {
  margin-top: 5px;
  color: rgba(255, 255, 255, 0.55);
  font-size: 13px;
}

.edit-btn {
  background: rgba(240, 173, 82, 0.15);
  border: 1px solid rgba(240, 173, 82, 0.3);
  color: var(--wd-gold);
  border-radius: 10px;
  padding: 9px 14px;
  font-weight: 700;
  cursor: pointer;
}

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
}

.profile-tab.active {
  background: rgba(240, 173, 82, 0.18);
  color: var(--wd-dark);
}

.profile-body {
  padding: 8px 20px;
}

.field-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 18px 0;
  border-bottom: 1px solid var(--wd-border);
}

.field-row:last-child {
  border-bottom: none;
}

.field-label {
  color: var(--wd-muted);
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  margin-bottom: 4px;
}

.field-val {
  color: var(--wd-dark);
  font-weight: 700;
  font-size: 15px;
}

.field-edit {
  color: var(--wd-brown);
  font-size: 16px;
}

.security-section {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.section-title {
  font-weight: 700;
  color: var(--wd-dark);
  margin-bottom: 6px;
}

.security-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 14px 0;
  border-top: 1px solid var(--wd-border);
}

.security-label {
  font-weight: 700;
  color: var(--wd-dark);
}

.security-sub {
  margin-top: 4px;
  color: var(--wd-muted);
  font-size: 13px;
}

@media (max-width: 700px) {
  .profile-banner,
  .security-row {
    flex-direction: column;
    gap: 14px;
    align-items: flex-start;
  }

  .profile-tabs {
    flex-wrap: wrap;
  }
}
</style>