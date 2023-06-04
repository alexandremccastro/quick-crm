
<template>
  <div class="form-control w-full">
    <label class="label m-0 p-0 px-1 mb-1">
      <span class="label-text">{{ label }}</span>
    </label>
    <div class="join">

      <select :name="name" :placeholder="placeholder" :items="items" item-value="" v-model="model"
        class="select select-bordered w-full max-w-xs">
        <option disabled selected></option>
        <option v-for="item in items" :value="item[itemValue]">{{ item[itemText] }}</option>

      </select>

    </div>
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