<template>
  <h1>{{ name }}</h1>
  <button @click="increment">Count: {{ count }}</button>
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