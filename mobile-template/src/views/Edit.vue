<template>
  <form class="needs-validation" novalidate @submit.prevent="submit">

    <input type="hidden" v-model="form.cameFrom" />

    <!-- Header -->
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
              <h5 class="mb-1">{{ pageTitle }}</h5>
              <p class="mb-0 text-muted small">{{ pageSubTitle }}</p>
            </div>
          </div>

          <!-- Actions -->
          <div class="ms-auto d-flex gap-2 flex-wrap">
            <RouterLink
                v-if="!isCreate"
                :to="`/view?id=${form.id}`"
                class="btn btn-sm btn-primary"
            >
              View
            </RouterLink>

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

    <div class="row g-4">

      <!-- Left column -->
      <div class="col-12 col-lg-6">
        <div class="card">
          <div class="card-header">
            <h6 class="mb-0">Basic Information</h6>
          </div>

          <div class="card-body">

            <!-- Name -->
            <div class="mb-3 row">
              <label class="col-sm-3 col-form-label">
                Name
              </label>
              <div class="col-sm-9">
                <input
                    v-model="form.name"
                    type="text"
                    class="form-control"
                />
              </div>
            </div>

            <!-- Radios -->
            <fieldset class="mb-3">
              <legend class="col-form-label col-sm-3 pt-0">
                Radios
              </legend>

              <div class="ms-sm-3">

                <div class="form-check">
                  <input
                      class="form-check-input"
                      type="radio"
                      value="option1"
                      v-model="form.radio"
                      id="radio1"
                  />
                  <label class="form-check-label" for="radio1">
                    First radio
                  </label>
                </div>

                <div class="form-check">
                  <input
                      class="form-check-input"
                      type="radio"
                      value="option2"
                      v-model="form.radio"
                      id="radio2"
                  />
                  <label class="form-check-label" for="radio2">
                    Second radio
                  </label>
                </div>

              </div>
            </fieldset>

            <!-- Checkboxes -->
            <div class="mb-3 form-check">
              <input
                  class="form-check-input"
                  type="checkbox"
                  id="checkbox1"
                  v-model="form.checkbox"
              />
              <label class="form-check-label" for="checkbox1">
                Example checkbox
              </label>
            </div>

            <div class="mb-3 form-check">
              <input
                  class="form-check-input"
                  type="checkbox"
                  id="checkbox2"
                  v-model="form.checkbox2"
              />
              <label class="form-check-label" for="checkbox2">
                Example checkbox 2
              </label>
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="btn btn-primary w-100"
            >
              {{ isCreate ? 'Create' : 'Save Changes' }}
            </button>

          </div>
        </div>
      </div>

      <!-- Right column -->
      <div class="col-12 col-lg-6">
        <div class="card">
          <div class="card-header">
            <h6 class="mb-0">Description</h6>
          </div>

          <div class="card-body">
            <textarea
                v-model="form.description"
                rows="8"
                class="form-control"
            ></textarea>
          </div>
        </div>
      </div>

    </div>
  </form>

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
 * Simulated mode (later from route or service)
 */
const isCreate = ref(false)

/**
 * Page text
 */
const pageTitle = computed(() =>
    isCreate.value ? 'Create Record' : 'Edit Record'
)

const pageSubTitle = computed(() =>
    isCreate.value
        ? 'Create a new record'
        : 'Update existing record'
)

/**
 * Form state
 */
const form = ref({
  id: 1,
  cameFrom: 'index',
  name: '',
  radio: '',
  checkbox: false,
  checkbox2: false,
  description: ''
})

function submit() {
  // placeholder
  console.log('Submitting form:', form.value)
  alert(isCreate.value ? 'Created (mock)' : 'Saved (mock)')
}
</script>
