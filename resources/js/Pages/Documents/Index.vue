<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <div class="page-label">HALAMAN 5 — VAULT DOKUMEN</div>

    <div class="app-shell">
      <div class="sidebar">
        <div class="sb-brand">
          <div class="sb-icon"></div>
          <span>WarisDigital</span>
        </div>

        <div class="sb-nav">
          <div class="nav-section">Menu Utama</div>
          <div class="nav-item"><span>🏠</span> Dashboard</div>
          <div class="nav-item active"><span>🗄️</span> Vault Dokumen</div>
          <div class="nav-item"><span>🗺️</span> Aset Mapper</div>
          <div class="nav-item"><span>👥</span> Akses Berjenjang</div>

          <div class="nav-section">Perencanaan</div>
          <div class="nav-item"><span>⏰</span> Pengingat</div>
          <div class="nav-item"><span>⚖️</span> Simulasi Waris</div>
          <div class="nav-item"><span>⏳</span> Kapsul Waktu</div>
          <div class="nav-item"><span>⚖️</span> Mitra Notaris</div>
        </div>
      </div>

      <div class="main">
        <div class="page-header">
          <div>
            <h2>🗄️ Vault Dokumen</h2>
            <p>12 dokumen tersimpan dengan aman • Terenkripsi AES-256</p>
          </div>
          <button class="btn-primary">+ Upload Dokumen</button>
        </div>

        <div class="content">
          <div class="tabs">
            <div class="tab active">Semua (12)</div>
            <div class="tab">KTP/Identitas (3)</div>
            <div class="tab">Properti (4)</div>
            <div class="tab">Kendaraan (2)</div>
            <div class="tab">Keuangan (2)</div>
            <div class="tab">Lainnya (1)</div>
          </div>

          <div class="toolbar">
            <div class="search-box"><span>🔍</span><span>Cari nama dokumen...</span></div>
            <div class="filter-btn">Filter ▾</div>
            <div class="filter-btn">Urutkan ▾</div>
            <div class="view-toggle">
              <div class="view-btn active">⊞</div>
              <div class="view-btn">≡</div>
            </div>
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
                  <span class="doc-act-btn">👁</span>
                  <span class="doc-act-btn">✏️</span>
                  <span class="doc-act-btn">🗑</span>
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
                  <span class="doc-act-btn">👁</span>
                  <span class="doc-act-btn">✏️</span>
                  <span class="doc-act-btn">🗑</span>
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
                  <span class="doc-act-btn">👁</span>
                  <span class="doc-act-btn">✏️</span>
                  <span class="doc-act-btn">🗑</span>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-overlay">
            <div class="modal-box">
              <div class="modal-header-custom">
                <h4>📤 Upload Dokumen Baru</h4>
                <span class="modal-close">✕</span>
              </div>

              <div class="form-row">
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
              </div>

              <div class="form-row">
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
                <p class="dropzone-note">PDF, JPG, PNG — Maks. 10MB</p>
              </div>

              <div class="modal-footer-custom">
                <button class="btn-cancel">Batal</button>
                <button class="btn-upload">Upload Dokumen →</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

.page-label {
  background: #f0ad52;
  color: #2b0303;
  font-size: 10px;
  font-weight: 700;
  padding: 3px 10px;
  text-align: center;
  letter-spacing: 1px;
}

.app-shell {
  display: grid;
  grid-template-columns: 200px 1fr;
  min-height: 560px;
  background: #f8fae5;
}

.sidebar {
  background: #2b0303;
  display: flex;
  flex-direction: column;
}

.sb-brand {
  padding: 12px 14px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
  display: flex;
  align-items: center;
  gap: 8px;
}

.sb-icon {
  width: 26px;
  height: 26px;
  background: #f0ad52;
  border-radius: 5px;
  flex-shrink: 0;
}

.sb-brand span {
  color: #fff;
  font-size: 13px;
  font-weight: 700;
}

.sb-nav {
  flex: 1;
  padding: 8px 0;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 6px 14px;
  font-size: 11px;
  color: rgba(255, 255, 255, 0.5);
}

.nav-item.active {
  background: rgba(240, 173, 82, 0.12);
  border-left: 3px solid #f0ad52;
  color: #f0ad52;
}

.nav-section {
  font-size: 9px;
  color: rgba(255, 255, 255, 0.2);
  padding: 8px 14px 2px;
  text-transform: uppercase;
  letter-spacing: 0.8px;
}

.main {
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.page-header {
  background: #fff;
  border-bottom: 1px solid rgba(167, 100, 48, 0.12);
  padding: 12px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.page-header h2 {
  font-size: 15px;
  font-weight: 700;
  color: #2b0303;
}

.page-header p {
  font-size: 10px;
  color: #aaa;
}

.btn-primary {
  background: #f0ad52;
  color: #2b0303;
  font-size: 11px;
  font-weight: 700;
  padding: 7px 14px;
  border-radius: 6px;
  border: none;
}

.content {
  flex: 1;
  padding: 14px 20px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.tabs {
  display: flex;
  gap: 0;
  border-bottom: 2px solid #f0ece4;
}

.tab {
  padding: 6px 12px;
  font-size: 10px;
  font-weight: 500;
  color: #aaa;
  cursor: pointer;
  border-bottom: 2px solid transparent;
  margin-bottom: -2px;
}

.tab.active {
  color: #2b0303;
  border-bottom-color: #f0ad52;
  font-weight: 700;
}

.toolbar {
  display: flex;
  align-items: center;
  gap: 8px;
}

.search-box {
  flex: 1;
  background: #fff;
  border: 1px solid rgba(167, 100, 48, 0.2);
  border-radius: 6px;
  padding: 6px 10px;
  font-size: 11px;
  color: #555;
  display: flex;
  align-items: center;
  gap: 6px;
}

.search-box span {
  color: #aaa;
}

.filter-btn {
  background: #fff;
  border: 1px solid rgba(167, 100, 48, 0.2);
  border-radius: 6px;
  padding: 6px 10px;
  font-size: 10px;
  color: #555;
}

.view-toggle {
  display: flex;
  border: 1px solid rgba(167, 100, 48, 0.2);
  border-radius: 6px;
  overflow: hidden;
}

.view-btn {
  padding: 5px 8px;
  font-size: 12px;
  background: #fff;
  color: #aaa;
}

.view-btn.active {
  background: #2b0303;
  color: #f0ad52;
}

.doc-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
}

.doc-card {
  background: #fff;
  border-radius: 8px;
  border: 1px solid rgba(167, 100, 48, 0.12);
  overflow: hidden;
}

.doc-card-top {
  padding: 14px 12px 10px;
  display: flex;
  align-items: flex-start;
  gap: 10px;
  border-bottom: 1px solid #f5f0e8;
}

.doc-file-icon {
  width: 36px;
  height: 44px;
  border-radius: 5px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
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
  font-size: 11px;
  font-weight: 700;
  color: #2b0303;
  margin-bottom: 2px;
}

.doc-cat {
  font-size: 9px;
  color: #a76430;
  background: rgba(167, 100, 48, 0.1);
  padding: 1px 6px;
  border-radius: 8px;
  display: inline-block;
}

.doc-note {
  font-size: 9px;
  color: #aaa;
  margin-top: 4px;
}

.doc-card-bot {
  padding: 8px 12px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.doc-date {
  font-size: 9px;
  color: #aaa;
}

.doc-status {
  font-size: 9px;
  padding: 2px 7px;
  border-radius: 8px;
  font-weight: 600;
  margin-top: 2px;
  display: inline-block;
}

.doc-actions {
  display: flex;
  gap: 6px;
}

.doc-act-btn {
  font-size: 12px;
  color: #aaa;
  cursor: pointer;
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

.modal-overlay {
  position: relative;
  margin-top: 0;
  background: rgba(43, 3, 3, 0.35);
  border-radius: 8px;
  padding: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 160px;
}

.modal-box {
  background: #fff;
  border-radius: 10px;
  padding: 16px;
  width: 100%;
  max-width: 320px;
}

.modal-header-custom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}

.modal-header-custom h4 {
  font-size: 13px;
  font-weight: 700;
  color: #2b0303;
}

.modal-close {
  color: #aaa;
  font-size: 14px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
  margin-bottom: 8px;
}

.form-field label {
  display: block;
  font-size: 9px;
  font-weight: 700;
  color: #555;
  margin-bottom: 3px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.form-field input,
.form-field select {
  width: 100%;
  border: 1px solid rgba(167, 100, 48, 0.25);
  border-radius: 5px;
  padding: 5px 8px;
  font-size: 10px;
  color: #333;
  background: #fff;
}

.dropzone {
  border: 2px dashed rgba(167, 100, 48, 0.3);
  border-radius: 6px;
  padding: 14px;
  text-align: center;
  background: #f8fae5;
  margin: 10px 0;
}

.dropzone p {
  font-size: 10px;
  color: #888;
}

.dz-icon {
  font-size: 24px;
  margin-bottom: 4px;
}

.dropzone-note {
  font-size: 8px !important;
  margin-top: 2px;
  color: #bbb !important;
}

.modal-footer-custom {
  display: flex;
  justify-content: flex-end;
  gap: 8px;
  margin-top: 10px;
}

.btn-cancel {
  background: transparent;
  border: 1px solid rgba(167, 100, 48, 0.25);
  color: #888;
  font-size: 11px;
  padding: 6px 12px;
  border-radius: 5px;
}

.btn-upload {
  background: #f0ad52;
  color: #2b0303;
  font-size: 11px;
  font-weight: 700;
  padding: 6px 14px;
  border-radius: 5px;
  border: none;
}
</style>