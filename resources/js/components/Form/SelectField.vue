
<template>
  <div class="w-full">
    <label class="block mb-2 text-sm font-medium text-gray-900">{{ label }}
    </label>
    <select :name="name" :placeholder="placeholder" :items="items" item-value="" v-model="model"
      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
      <option disabled selected></option>
      <option v-for="item in items" :value="item[itemValue]">{{ item[itemText] }}</option>

    </select>
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
  name: 'SelectField',
  props: {
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
    items: {
      type: Array,
      default: () => []
    },
    itemText: {
      type: String,
      default: ''
    },
    itemValue: {
      type: String,
      default: ''
    }
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