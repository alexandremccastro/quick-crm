<template>
  <div class="w-full">
    <label class="block mb-2 text-sm font-medium text-gray-900 text-left" :for="name">
      {{ label }}
    </label>
    <input :type="type" :id="name" v-maska :data-maska="mask" :name="name" :placeholder="placeholder" v-model="model"
      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

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
  name: 'TextField',
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