<template>
  <div class="w-full">
    <div class="card rounded-t">
      <div class="flex justify-between py-2 items-center rounded-t bg-gray-50 px-4">
        <h1 class="text-xl">Search</h1>

        <button class="btn btn-sm btn-ghost" @click="toggleForm">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
          </svg>

        </button>
      </div>
    </div>
    <template v-if="showForm">
      <form autocomplete="off" method="GET" action="/customers" @submit="searchData">
        <div class="card-body border-b py-0 pt-2 px-4">
          <TextField v-model="v$.search.$model" :errors="v$.search.$errors" class="col-span-2" name="search" />
        </div>
        <div class="card-actions py-3 flex border-b justify-end px-4">
          <a href="/customers" class="btn  w-[100px]">Clear</a>
          <button class="btn btn-primary w-[100px]" type="submit">Search</button>
        </div>
      </form>
    </template>
  </div>
</template>
<script>
import { defineComponent } from 'vue';
import TextField from '@/components/Form/TextField.vue';
import { useVuelidate } from '@vuelidate/core'
import { validations as mockedValidations } from '@/core/validations/mock'

export default defineComponent({
  name: 'SearchCustomers',
  components: { TextField },
  validations() {
    const { required } = mockedValidations

    return {
      search: { required }
    }
  },
  setup() {
    return { v$: useVuelidate() }
  },
  created() {
    const url = new URL(location.href)
    const searchParams = new URLSearchParams(url.searchParams)
    const search = searchParams.get('search')
    if (!['', null, undefined].includes(search)) {
      this.search = search
      this.showForm = true
    }
  },
  data() {
    return {
      search: '',
      showForm: false
    }
  },
  methods: {
    toggleForm() {
      this.showForm = !this.showForm
    },
    async searchData(e) {
      const isValidated = await this.v$.$validate();

      if (!isValidated) e.preventDefault()
    }
  }
})
</script>