<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref } from 'vue'

const form = useForm({
  title: '',
  description: '',
  file_type: 'Identitas',
  file: null,
})

const fileName = ref('')

const handleFileSelect = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.file = file
    fileName.value = file.name
  }
}

const submit = () => {
  form.post('/documents', {
    forceFormData: true,
  })
}
</script>

<template>
  <AppLayout>
    <template #title>Upload Dokumen</template>
    <template #subtitle>Tambahkan dokumen penting ke Vault keluarga.</template>

    <div class="create-page wd-card">
      <h2>📤 Upload Dokumen Baru</h2>

      <form @submit.prevent="submit">
        <div class="form-grid">
          <div class="form-field">
            <label for="title">Nama Dokumen</label>
            <input
              id="title"
              type="text"
              v-model="form.title"
              placeholder="Contoh: KTP Ahmad Sutarjo"
              required
            />
            <p v-if="form.errors.title" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.title }}
            </p>
          </div>

          <div class="form-field">
            <label for="category">Kategori</label>
            <select id="category" v-model="form.file_type">
              <option value="Identitas">Identitas/KTP</option>
              <option value="Properti">Properti</option>
              <option value="Kendaraan">Kendaraan</option>
              <option value="Keuangan">Keuangan</option>
              <option value="Lainnya">Lainnya</option>
            </select>
            <p v-if="form.errors.file_type" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.file_type }}
            </p>
          </div>

          <div class="form-field" style="grid-column: span 2;">
            <label for="description">Deskripsi / Catatan</label>
            <textarea
              id="description"
              v-model="form.description"
              rows="3"
              placeholder="Tambahkan keterangan tentang dokumen ini..."
              style="width: 100%; border: 1px solid var(--wd-border); border-radius: 10px; padding: 11px 12px; font-family: inherit;"
            ></textarea>
            <p v-if="form.errors.description" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.description }}
            </p>
          </div>
        </div>

        <div class="form-field" style="margin-top: 18px;">
          <label>File Dokumen</label>
          <label class="dropzone" style="display:block; cursor:pointer;">
            <input type="file" @change="handleFileSelect" hidden required />
            <div class="dz-icon">📁</div>
            <p v-if="!fileName">Klik di sini untuk memilih file</p>
            <p v-else style="font-weight:700; color:var(--wd-brown);">{{ fileName }}</p>
            <small>PDF, JPG, PNG — Maks. 10MB</small>
          </label>
          <p v-if="form.errors.file" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.file }}
          </p>
        </div>

        <div class="actions">
          <Link href="/documents" class="wd-btn-outline">Batal</Link>
          <button type="submit" class="wd-btn-primary" :disabled="form.processing">
            {{ form.processing ? 'Mengupload...' : 'Upload Dokumen →' }}
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped>
.create-page {
  max-width: 900px;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
  margin-top: 18px;
}

.form-field label {
  display: block;
  color: var(--wd-muted);
  font-weight: 700;
  margin-bottom: 6px;
}

.form-field input,
.form-field select {
  width: 100%;
  border: 1px solid var(--wd-border);
  border-radius: 10px;
  padding: 11px 12px;
}

.dropzone {
  margin-top: 6px;
  border: 2px dashed rgba(167, 100, 48, 0.3);
  border-radius: 14px;
  background: var(--wd-bg);
  padding: 32px;
  text-align: center;
}

.dz-icon {
  font-size: 34px;
}

.actions {
  margin-top: 18px;
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}
</style>