<template>
  <div class="flex flex-col gap-3 w-full grow items-center justify-center">
    <h1 class="text-2xl">Welcome, {{ name }}!</h1>

    <form ref="logoutForm" method="POST" action="/logout">
      <button class="btn btn-primary">Logout</button>
    </form>
  </div>
</template>
<script>
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'HomePage',
  props: {
    name: {
      type: String,
      default: ''
    }
  }
})
</script>