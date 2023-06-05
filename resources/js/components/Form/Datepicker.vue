<template>
  <div class=" w-full">
    <label class="label m-0 p-0 px-1 mb-1">
      <span class="label-text">{{ label }}</span>
    </label>
    <div class="relative max-w-sm">
      <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd"
            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      <input datepicker :datepicker-format="pattern" :type="type" v-maska :data-maska="mask" :name="name"
        :placeholder="placeholder" v-model="model" type="text"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="Select date">
    </div>


    <!-- <button class="btn join-item">Teste</button> -->
    <div class="h-6">
      <label class="label  m-0 p-0 px-1 my-1" v-for="error in errors" :key="error.$uid">
        <span class="label-text-alt text-red-500">{{ error.$message }}</span>
      </label>
    </div>
  </div>
</template>
<script>
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'Datepicker',
  props: {
    mask: {
      type: String,
      default: null
    },
    modelValue: {
      type: String,
      default: ''
    },
    label: {
      type: String,
      default: ''
    },
    name: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: 'text'
    },
    hint: {
      type: String,
      default: ''
    },
    errors: {
      type: Array,
      default: () => []
    },
    pattern: {
      type: String,
      default: 'yyyy-mm-dd'
    },
  },

  computed: {
    model: {
      get() {
        return this.$props.modelValue
      },
      set(value) {
        this.$emit('update:modelValue', value)
      }
    }
  }
})
</script>