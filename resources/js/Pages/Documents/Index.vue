<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
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

        <button class="wd-btn-primary">+ Upload Dokumen</button>
      </div>

      <div class="vault-tabs">
        <button class="vault-tab active">Semua (12)</button>
        <button class="vault-tab">KTP/Identitas (3)</button>
        <button class="vault-tab">Properti (4)</button>
        <button class="vault-tab">Kendaraan (2)</button>
        <button class="vault-tab">Keuangan (2)</button>
        <button class="vault-tab">Lainnya (1)</button>
      </div>

      <div class="vault-toolbar">
        <div class="vault-search">🔍 <span>Cari nama dokumen...</span></div>
        <button class="wd-btn-outline">Filter ▾</button>
        <button class="wd-btn-outline">Urutkan ▾</button>
      </div>

      <div class="doc-grid">
        <div class="doc-card">
          <div class="doc-card-top">
            <div class="doc-file-icon icon-red">📄</div>
            <div>
              <div class="doc-name">KTP Ahmad Sutarjo</div>
              <div class="doc-cat">Identitas</div>
              <div class="doc-note">Berlaku s/d: 17 Jun 2025</div>
            </div>
          </div>

          <div class="doc-card-bot">
            <div>
              <div class="doc-date">Upload: 12 Mar 2024</div>
              <div class="doc-status status-exp">⚠ 3 Hari</div>
            </div>
            <div class="doc-actions">
              <span>👁</span>
              <span>✏️</span>
              <span>🗑</span>
            </div>
          </div>
        </div>

        <div class="doc-card">
          <div class="doc-card-top">
            <div class="doc-file-icon icon-green">🏠</div>
            <div>
              <div class="doc-name">SHM Jl. Merdeka No.5</div>
              <div class="doc-cat">Properti</div>
              <div class="doc-note">Tidak kedaluwarsa</div>
            </div>
          </div>

          <div class="doc-card-bot">
            <div>
              <div class="doc-date">Upload: 05 Jan 2024</div>
              <div class="doc-status status-ok">✅ Aktif</div>
            </div>
            <div class="doc-actions">
              <span>👁</span>
              <span>✏️</span>
              <span>🗑</span>
            </div>
          </div>
        </div>

        <div class="doc-card">
          <div class="doc-card-top">
            <div class="doc-file-icon icon-orange">🚗</div>
            <div>
              <div class="doc-name">BPKB Honda Civic 2019</div>
              <div class="doc-cat">Kendaraan</div>
              <div class="doc-note">Berlaku s/d: 28 Jun 2025</div>
            </div>
          </div>

          <div class="doc-card-bot">
            <div>
              <div class="doc-date">Upload: 20 Nov 2023</div>
              <div class="doc-status status-warn">⏰ 14 Hari</div>
            </div>
            <div class="doc-actions">
              <span>👁</span>
              <span>✏️</span>
              <span>🗑</span>
            </div>
          </div>
        </div>
      </div>

      <div class="upload-panel wd-card">
        <div class="upload-panel-header">
          <h3>📤 Upload Dokumen Baru</h3>
          <span>Form tampilan sementara</span>
        </div>

        <div class="upload-form">
          <div class="form-field">
            <label>Nama Dokumen</label>
            <input value="KTP Ahmad Sutarjo" />
          </div>

          <div class="form-field">
            <label>Kategori</label>
            <select>
              <option>Identitas/KTP</option>
            </select>
          </div>

          <div class="form-field">
            <label>Tgl. Berlaku s/d</label>
            <input type="text" value="17/06/2025" />
          </div>

          <div class="form-field">
            <label>Visibilitas</label>
            <select>
              <option>Privat (Saya saja)</option>
            </select>
          </div>
        </div>

        <div class="dropzone">
          <div class="dz-icon">📁</div>
          <p>Seret & lepas file di sini, atau klik untuk memilih</p>
          <small>PDF, JPG, PNG — Maks. 10MB</small>
        </div>

        <div class="upload-actions">
          <button class="wd-btn-outline">Batal</button>
          <button class="wd-btn-primary">Upload Dokumen →</button>
        </div>
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
  cursor: pointer;
}

.upload-panel {
  margin-top: 4px;
}

.upload-panel-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 16px;
}

.upload-panel-header h3 {
  margin: 0;
  font-size: 18px;
}

.upload-panel-header span {
  color: var(--wd-muted);
  font-size: 13px;
}

.upload-form {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
}

.form-field label {
  display: block;
  margin-bottom: 6px;
  font-size: 12px;
  font-weight: 700;
  color: var(--wd-muted);
  text-transform: uppercase;
}

.form-field input,
.form-field select {
  width: 100%;
  border: 1px solid var(--wd-border);
  border-radius: 10px;
  padding: 10px 12px;
  background: white;
}

.dropzone {
  margin-top: 18px;
  border: 2px dashed rgba(167, 100, 48, 0.3);
  border-radius: 14px;
  background: var(--wd-bg);
  padding: 24px;
  text-align: center;
}

.dz-icon {
  font-size: 28px;
}

.dropzone p {
  margin: 8px 0 4px;
}

.dropzone small {
  color: var(--wd-muted);
}

.upload-actions {
  margin-top: 16px;
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

@media (max-width: 1100px) {
  .doc-grid {
    grid-template-columns: 1fr;
  }

  .upload-form {
    grid-template-columns: 1fr 1fr;
  }
}

@media (max-width: 700px) {
  .vault-header,
  .vault-toolbar,
  .upload-panel-header {
    flex-direction: column;
    align-items: stretch;
  }

  .upload-form {
    grid-template-columns: 1fr;
  }
}
</style>