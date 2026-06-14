<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

const form = ref({
  title: '',
  type: '',
  receiver: '',
  condition: '',
  message: '',
  fileName: '',
})

const handleFileUpload = (event) => {
  const file = event.target.files[0]

  if (file) {
    form.value.fileName = file.name
  }
}

const saveCapsule = () => {
  alert('Kapsul berhasil disiapkan. Nanti bagian ini akan disambungkan ke backend.')
}
</script>

<template>
  <AppLayout>
    <template #title>Buat Kapsul Waktu</template>
    <template #subtitle>Simpan pesan atau dokumen penting untuk dibuka pada kondisi tertentu.</template>

    <div class="capsule-page">
      <div class="wd-card form-card">
        <div class="form-header">
          <div>
            <span class="small-badge">⏳ Legacy Protection</span>
            <h2>Buat Kapsul Baru</h2>
            <p>Lengkapi informasi kapsul waktu sebelum disimpan.</p>
          </div>

          <Link href="/time-capsule" class="secondary-btn">
            Kembali
          </Link>
        </div>

        <form class="capsule-form" @submit.prevent="saveCapsule">
          <div class="form-group">
            <label>Judul Kapsul</label>
            <input
              v-model="form.title"
              type="text"
              placeholder="Contoh: Pesan Video untuk Anak"
            />
          </div>

          <div class="form-group">
            <label>Jenis Kapsul</label>
            <select v-model="form.type">
              <option value="" disabled>Pilih jenis kapsul</option>
              <option value="Pesan Video">Pesan Video</option>
              <option value="Surat Wasiat Digital">Surat Wasiat Digital</option>
              <option value="Dokumen Rahasia">Dokumen Rahasia</option>
              <option value="Pesan Tertulis">Pesan Tertulis</option>
            </select>
          </div>

          <div class="form-group">
            <label>Penerima</label>
            <input
              v-model="form.receiver"
              type="text"
              placeholder="Contoh: Budi & Dewi"
            />
          </div>

          <div class="form-group">
            <label>Kondisi Pembukaan</label>
            <select v-model="form.condition">
              <option value="" disabled>Pilih kondisi pembukaan</option>
              <option value="Terverifikasi meninggal">Terverifikasi meninggal</option>
              <option value="Verifikasi notaris">Verifikasi notaris</option>
              <option value="Persetujuan dua pihak">Persetujuan dua pihak</option>
              <option value="Tanggal tertentu">Tanggal tertentu</option>
            </select>
          </div>

          <div class="form-group">
            <label>Upload File / Video / Dokumen</label>

            <label class="upload-box">
              <input type="file" hidden @change="handleFileUpload" />

              <div class="upload-icon">📁</div>

              <p v-if="!form.fileName">Klik untuk memilih file</p>
              <p v-else>{{ form.fileName }}</p>

              <small>PDF, DOCX, JPG, PNG, atau MP4</small>
            </label>
          </div>

          <div class="form-group">
            <label>Pesan atau Catatan</label>
            <textarea
              v-model="form.message"
              rows="5"
              placeholder="Tulis pesan yang ingin disimpan dalam kapsul waktu..."
            ></textarea>
          </div>

          <div class="form-actions">
            <Link href="/time-capsule" class="secondary-btn">
              Batal
            </Link>

            <button type="submit" class="primary-btn">
              Simpan Kapsul
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.capsule-page {
  max-width: 1100px;
  margin: 0 auto;
}

.form-card {
  padding: 24px;
  background: #fff;
  border: 1px solid var(--wd-border);
  border-radius: 18px;
}

.form-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 20px;
  margin-bottom: 24px;
}

.small-badge {
  display: inline-block;
  background: #fff3df;
  color: var(--wd-brown);
  padding: 6px 12px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 700;
  margin-bottom: 10px;
}

.form-header h2 {
  margin: 0;
  color: var(--wd-dark);
}

.form-header p {
  margin: 6px 0 0;
  color: var(--wd-muted);
}

.capsule-form {
  display: grid;
  gap: 18px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-weight: 700;
  color: var(--wd-dark);
}

.form-group input,
.form-group select,
.form-group textarea {
  border: 1px solid var(--wd-border);
  border-radius: 12px;
  padding: 12px 14px;
  font-family: inherit;
  color: var(--wd-dark);
  outline: none;
  background: #fff;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  border-color: var(--wd-gold);
}

.upload-box {
  border: 1px dashed var(--wd-border);
  border-radius: 14px;
  padding: 28px;
  text-align: center;
  background: #fffaf2;
  cursor: pointer;
  transition: 0.2s ease;
}

.upload-box:hover {
  border-color: var(--wd-gold);
  transform: translateY(-2px);
}

.upload-icon {
  font-size: 30px;
  margin-bottom: 8px;
}

.upload-box p {
  margin: 0;
  font-weight: 700;
  color: var(--wd-dark);
}

.upload-box small {
  color: var(--wd-muted);
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
}

.primary-btn,
.secondary-btn {
  border-radius: 10px;
  padding: 11px 18px;
  font-weight: 700;
  text-decoration: none;
  border: none;
  cursor: pointer;
}

.primary-btn {
  background: var(--wd-gold);
  color: var(--wd-dark);
}

.secondary-btn {
  background: #fff;
  color: var(--wd-dark);
  border: 1px solid var(--wd-border);
}

@media (max-width: 700px) {
  .form-header,
  .form-actions {
    flex-direction: column;
    align-items: stretch;
  }

  .primary-btn,
  .secondary-btn {
    text-align: center;
    width: 100%;
  }
}
</style>