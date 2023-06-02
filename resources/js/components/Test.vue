<template>
  <div>
    <button class="btn btn-active bg-red-200">Default</button>
    <button class="btn btn-active btn-neutral">Neutral</button>
    <button class="btn btn-active btn-primary">Primary</button>
    <button class="btn btn-active btn-secondary">Secondary</button>
    <button class="btn btn-active btn-accent">Accent</button>
    <button class="btn btn-active btn-ghost">Ghost</button>
    <button class="btn btn-active btn-link">Link</button>
    <h1 class="text-red-600">My Component {{ name }}</h1>

  </div>
</template>
<script>
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    name: {
      type: String,
      default: ''
    }
  },
  data() {
    return { count: 0 }
  },
  created() {
    console.log("Im here my friend")
  },
  methods: {
    increment() {
      this.count++;
    }
  }
})
</script>