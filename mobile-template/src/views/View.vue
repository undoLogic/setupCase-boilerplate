<template>
  <!-- Header card -->
  <div class="card shadow-sm mb-4">

    <div class="card-header">
      <div class="d-flex align-items-start gap-3">

        <!-- Back + title -->
        <div class="d-flex align-items-center gap-2">
          <RouterLink
              to="/"
              class="btn btn-sm btn-outline-secondary"
              title="Back to list"
          >
            ←
          </RouterLink>

          <div>
            <h5 class="mb-1">
              {{ entity.name }}
            </h5>
            <p class="mb-0 text-muted small">
              Record #{{ entity.id }}
            </p>
          </div>
        </div>

        <!-- Actions -->
        <div class="ms-auto d-flex gap-2 flex-wrap">
          <RouterLink
              :to="`/edit?id=${entity.id}`"
              class="btn btn-sm btn-primary"
          >
            Edit
          </RouterLink>

          <button
              class="btn btn-sm btn-danger"
              @click="confirmDeleteEntity"
          >
            Delete
          </button>

          <button
              type="button"
              class="btn btn-sm btn-outline-info"
              data-bs-toggle="modal"
              data-bs-target="#exampleModalLive"
          >
            Help
          </button>
        </div>

      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="row g-4">

    <!-- Left column -->
    <div class="col-12 col-lg-6">
      <div class="card">
        <div class="card-header">
          <h6 class="mb-0">Details</h6>
        </div>

        <div class="card-body">
          <p
              v-for="(paragraph, index) in descriptionParagraphs"
              :key="index"
          >
            {{ paragraph }}
          </p>
        </div>
      </div>
    </div>

    <!-- Right column -->
    <div class="col-12 col-lg-6">
      <div class="card">
        <div class="card-header">
          <h6 class="mb-0">Associated Data</h6>
        </div>

        <div class="card-body p-0">
          <table class="table table-hover mb-0">
            <thead class="table-light">
            <tr>
              <th>Column 1</th>
              <th>Column 2</th>
              <th>Column 3</th>
            </tr>
            </thead>

            <tbody>
            <tr
                v-for="row in associatedRows"
                :key="row.id"
            >
              <td class="text-nowrap">
                Row #{{ row.id }}

                <RouterLink
                    :to="`/edit?id=${row.id}`"
                    class="btn btn-sm btn-outline-primary ms-2"
                >
                  Edit
                </RouterLink>

                <button
                    class="btn btn-sm btn-outline-danger ms-1"
                    @click="confirmDeleteAssociated(row)"
                >
                  X
                </button>
              </td>
              <td>{{ row.col2 }}</td>
              <td>{{ row.col3 }}</td>
            </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>

  </div>

  <!-- Help Modal -->
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
import { computed, ref } from 'vue'

/**
 * Temporary mock entity
 * (later comes from a service)
 */
const entity = ref({
  id: 1,
  name: 'Example Record',
  description: `This is a description.

It can contain multiple paragraphs.

Just like CakePHP autoParagraph.`
})

/**
 * Simulate Text->autoParagraph()
 */
const descriptionParagraphs = computed(() =>
    entity.value.description
        .split('\n\n')
        .map(p => p.trim())
        .filter(Boolean)
)

/**
 * Temporary associated data
 */
const associatedRows = ref(
    Array.from({ length: 4 }).map((_, i) => ({
      id: i + 1,
      col2: 'Info',
      col3: 'Goes here…'
    }))
)

function confirmDeleteEntity() {
  if (confirm('Are you sure you want to delete this record?')) {
    // placeholder for service call
    alert('Deleted (mock)')
  }
}

function confirmDeleteAssociated(row: any) {
  if (confirm('Really delete?')) {
    associatedRows.value = associatedRows.value.filter(r => r.id !== row.id)
  }
}
</script>
