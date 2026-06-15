<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
  documents: {
    type: Array,
    default: () => [],
  },
  users: {
    type: Array,
    default: () => [],
  },
})

const form = useForm({
  document_id: '',
  user_id: '',
  permission: 'view',
})

const submit = () => {
  form.post('/access')
}
</script>

<template>
  <AppLayout>
    <template #title>Tambah Pengguna</template>
    <template #subtitle>Undang anggota keluarga dan atur hak akses.</template>

    <div class="wd-card access-form">
      <h2>👥 Tambah Hak Akses Pengguna</h2>

      <form @submit.prevent="submit">
        <div class="form-grid">
          <div class="form-field">
            <label for="user_id">Pilih Pengguna</label>
            <select id="user_id" v-model="form.user_id" required>
              <option value="" disabled>Pilih anggota keluarga</option>
              <option v-for="user in users" :key="user.id" :value="user.id">
                {{ user.name }} ({{ user.email }})
              </option>
            </select>
            <p v-if="form.errors.user_id" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.user_id }}
            </p>
          </div>

          <div class="form-field">
            <label for="document_id">Pilih Dokumen</label>
            <select id="document_id" v-model="form.document_id" required>
              <option value="" disabled>Pilih dokumen dari vault</option>
              <option v-for="doc in documents" :key="doc.id" :value="doc.id">
                {{ doc.title }} ({{ doc.file_type || 'Umum' }})
              </option>
            </select>
            <p v-if="form.errors.document_id" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.document_id }}
            </p>
          </div>

          <div class="form-field" style="grid-column: span 2;">
            <label for="permission">Hak Akses</label>
            <select id="permission" v-model="form.permission">
              <option value="view">Hanya Melihat (View)</option>
              <option value="download">Melihat & Mengunduh (Download)</option>
              <option value="edit">Mengedit (Edit)</option>
            </select>
            <p v-if="form.errors.permission" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.permission }}
            </p>
          </div>
        </div>

        <div class="actions">
          <Link href="/access" class="wd-btn-outline">Batal</Link>
          <button type="submit" class="wd-btn-primary" :disabled="form.processing">
            {{ form.processing ? 'Memproses...' : 'Berikan Akses →' }}
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped>
.access-form {
  max-width: 900px;
  margin: 0 auto;
}

.access-form h2 {
  margin-bottom: 20px;
  color: var(--wd-dark);
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 18px;
}

.form-field {
  display: flex;
  flex-direction: column;
}

.form-field label {
  margin-bottom: 6px;
  font-size: 13px;
  font-weight: 600;
  color: var(--wd-dark);
}

.form-field input,
.form-field select {
  border: 1px solid var(--wd-border);
  border-radius: 10px;
  padding: 10px 12px;
  background: white;
}

.form-field input:focus,
.form-field select:focus {
  outline: none;
  border-color: var(--wd-gold);
}

.actions {
  margin-top: 24px;
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

@media (max-width: 768px) {
  .form-grid {
    grid-template-columns: 1fr;
  }

  .actions {
    flex-direction: column;
  }
}
</style>