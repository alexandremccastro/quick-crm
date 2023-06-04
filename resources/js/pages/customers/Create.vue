<template>
  <div class="pb-3">
    <h1 class="text-lg">Create Customer</h1>
  </div>

  <div class="card bg-base-100 rounded-lg h-full shadow-sm">
    <Form action="/customers" method="POST"></Form>
  </div>
</template>
<script>
import { defineComponent } from 'vue';
import Form from './Form.vue';

export default defineComponent({
  name: 'CreateCustomer',
  components: { Form },

})
</script>