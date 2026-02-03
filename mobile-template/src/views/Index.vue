<template>
  <div class="card shadow-sm">

    <!-- Card Header -->
    <div class="card-header">

      <!-- Title + Actions -->
      <div class="d-flex align-items-start gap-3">
        <div>
          <h5 class="mb-1">Title</h5>
          <p class="mb-0 text-muted small">Sub-title</p>
        </div>

        <div class="ms-auto d-flex gap-2 flex-wrap">
          <RouterLink
              to="/edit"
              class="btn btn-sm btn-primary"
          >
            Create
          </RouterLink>

          <button
              type="button"
              class="btn btn-sm btn-outline-secondary"
              data-bs-toggle="modal"
              data-bs-target="#exampleModalLive"
          >
            Popup
          </button>
        </div>
      </div>

      <!-- Filters -->
      <div class="row g-2 mt-3 pt-3 border-top">
        <div
            v-for="(filter, index) in filters"
            :key="index"
            class="col-12 col-lg-3"
        >
          <select
              v-model="filter.value"
              class="form-select form-select-sm"
          >
            <option value="">Choose …</option>
            <option
                v-for="option in filter.options"
                :key="option"
                :value="option"
            >
              {{ option }}
            </option>
          </select>
        </div>
      </div>

    </div>

    <!-- Card Body -->
    <div class="card-body p-0">

      <table class="table table-hover mb-0">
        <thead class="table-light">
        <tr>
          <th style="width: 1%;">Actions</th>
          <th>Name</th>
          <th>Description</th>
        </tr>
        </thead>

        <tbody>
        <tr
            v-for="row in rows"
            :key="row.id"
        >
          <td class="text-nowrap">
            <RouterLink
                :to="`/view?id=${row.id}`"
                class="btn btn-sm btn-primary me-1"
            >
              View
            </RouterLink>

            <RouterLink
                :to="`/edit?id=${row.id}`"
                class="btn btn-sm btn-warning me-1"
            >
              Edit
            </RouterLink>

            <button
                class="btn btn-sm btn-danger"
                @click="confirmDelete(row)"
            >
              X
            </button>
          </td>

          <td>{{ row.name }}</td>
          <td>{{ row.description }}</td>
        </tr>
        </tbody>
      </table>

    </div>
  </div>

  <!-- Modal -->
  <div
      class="modal fade"
      id="exampleModalLive"
      tabindex="-1"
      aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Help</h5>
          <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
          ></button>
        </div>

        <div class="modal-body">
          Popup
        </div>

        <div class="modal-footer">
          <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
          >
            Close
          </button>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

/**
 * Temporary mock data
 * (later this comes from a service)
 */
const rows = ref([
  { id: 1, name: 'Item 1', description: 'Description 1' },
  { id: 2, name: 'Item 2', description: 'Description 2' }
])

const filters = ref([
  { value: '', options: ['1', '2'] },
  { value: '', options: ['1', '2'] },
  { value: '', options: ['1', '2'] },
  { value: '', options: ['1', '2'] }
])

function confirmDelete(row: any) {
  if (confirm('Are you sure?')) {
    // placeholder — later goes to service
    rows.value = rows.value.filter(r => r.id !== row.id)
  }
}
</script>
