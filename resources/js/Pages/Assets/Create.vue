<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const form = useForm({
  name: '',
  type: 'tanah',
  value: '',
  description: '',
  location: '',
})

const submit = () => {
  form.post('/assets')
}
</script>

<template>
  <AppLayout>
    <template #title>Tambah Aset</template>
    <template #subtitle>Tambahkan aset keluarga ke dalam Asset Mapper.</template>

    <div class="asset-create wd-card">
      <h2>🏦 Tambah Aset Baru</h2>

      <form @submit.prevent="submit">
        <div class="form-grid">
          <div class="form-field">
            <label for="name">Nama Aset</label>
            <input
              id="name"
              type="text"
              v-model="form.name"
              placeholder="Contoh: Rumah Banda Aceh"
              required
            />
            <p v-if="form.errors.name" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.name }}
            </p>
          </div>

          <div class="form-field">
            <label for="type">Jenis Aset</label>
            <select id="type" v-model="form.type">
              <option value="tanah">Tanah</option>
              <option value="rumah">Rumah/Bangunan</option>
              <option value="kendaraan">Kendaraan</option>
              <option value="tabungan">Tabungan/Rekening</option>
              <option value="investasi">Investasi/Saham</option>
              <option value="lainnya">Lainnya</option>
            </select>
            <p v-if="form.errors.type" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.type }}
            </p>
          </div>

          <div class="form-field">
            <label for="value">Nilai Aset (Rp)</label>
            <input
              id="value"
              type="number"
              v-model="form.value"
              placeholder="Contoh: 500000000"
            />
            <p v-if="form.errors.value" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.value }}
            </p>
          </div>

          <div class="form-field">
            <label for="location">Lokasi / Alamat</label>
            <input
              id="location"
              type="text"
              v-model="form.location"
              placeholder="Contoh: Jl. Sudirman No. 10"
            />
            <p v-if="form.errors.location" style="color:#e74c3c; font-size:12px; margin-top:4px;">
              {{ form.errors.location }}
            </p>
          </div>
        </div>

        <div class="form-field">
          <label for="description">Keterangan</label>
          <textarea
            id="description"
            v-model="form.description"
            rows="4"
            placeholder="Informasi tambahan mengenai aset..."
          ></textarea>
          <p v-if="form.errors.description" style="color:#e74c3c; font-size:12px; margin-top:4px;">
            {{ form.errors.description }}
          </p>
        </div>

        <div class="actions">
          <Link href="/assets" class="wd-btn-outline">
            Batal
          </Link>

          <button type="submit" class="wd-btn-primary" :disabled="form.processing">
            {{ form.processing ? 'Menyimpan...' : 'Simpan Aset →' }}
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped>
.asset-create {
  max-width: 900px;
}

.asset-create h2 {
  margin-bottom: 20px;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
}

.form-field {
  margin-bottom: 16px;
}

.form-field label {
  display: block;
  margin-bottom: 6px;
  font-size: 13px;
  font-weight: 600;
  color: var(--wd-dark);
}

.form-field input,
.form-field select,
.form-field textarea {
  width: 100%;
  border: 1px solid var(--wd-border);
  border-radius: 10px;
  padding: 10px 12px;
}

.actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 20px;
}

@media (max-width: 768px) {
  .form-grid {
    grid-template-columns: 1fr;
  }
}
</style>