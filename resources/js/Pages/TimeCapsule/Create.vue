<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
  documents: {
    type: Array,
    default: () => [],
  },
})

const form = useForm({
  title: '',
  message: '',
  document_id: '',
  unlock_condition: 'manual',
  unlock_at: '',
})

const submit = () => {
  form.post('/time-capsule')
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

        <form class="capsule-form" @submit.prevent="submit">
          <div class="form-group">
            <label for="title">Judul Kapsul</label>
            <input
              id="title"
              v-model="form.title"
              type="text"
              placeholder="Contoh: Pesan Video untuk Anak"
              required
            />
            <p v-if="form.errors.title" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.title }}
            </p>
          </div>

          <div class="form-group">
            <label for="document_id">Hubungkan dengan Dokumen (Opsional)</label>
            <select id="document_id" v-model="form.document_id">
              <option value="">Tidak ada dokumen terhubung</option>
              <option v-for="doc in documents" :key="doc.id" :value="doc.id">
                {{ doc.title }} ({{ doc.file_type || 'Umum' }})
              </option>
            </select>
            <p v-if="form.errors.document_id" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.document_id }}
            </p>
          </div>

          <div class="form-group">
            <label for="unlock_condition">Kondisi Pembukaan</label>
            <select id="unlock_condition" v-model="form.unlock_condition" required>
              <option value="manual">Buka Manual oleh Pemilik</option>
              <option value="death">Kematian Terverifikasi (Verifikasi Admin)</option>
              <option value="date">Tanggal Tertentu (Otomatis)</option>
            </select>
            <p v-if="form.errors.unlock_condition" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.unlock_condition }}
            </p>
          </div>

          <div class="form-group" v-if="form.unlock_condition === 'date'">
            <label for="unlock_at">Tanggal Pembukaan</label>
            <input
              id="unlock_at"
              v-model="form.unlock_at"
              type="datetime-local"
              required
            />
            <p v-if="form.errors.unlock_at" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.unlock_at }}
            </p>
          </div>

          <div class="form-group">
            <label for="message">Pesan atau Catatan Tertulis</label>
            <textarea
              id="message"
              v-model="form.message"
              rows="5"
              placeholder="Tulis pesan yang ingin disimpan dalam kapsul waktu..."
            ></textarea>
            <p v-if="form.errors.message" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.message }}
            </p>
          </div>

          <div class="form-actions">
            <Link href="/time-capsule" class="secondary-btn">
              Batal
            </Link>

            <button type="submit" class="primary-btn" :disabled="form.processing">
              {{ form.processing ? 'Menyimpan...' : 'Simpan Kapsul' }}
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