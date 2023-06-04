<template>
  <div class="pb-3">
    <h1 class="text-lg">Edit Customer</h1>
  </div>

  <div class="card bg-base-100 rounded-lg h-full shadow-sm">
    <Form :action="`/customers/${parsedData.id}`" :data="parsedData" method="PUT"></Form>
  </div>
</template>
<script>
import { defineComponent } from 'vue';
import Form from './Form.vue';

export default defineComponent({
  name: 'EditCustomer',
  components: { Form },
  props: ['customer'],
  created() {
    console.log(this.customer)
  },
  computed: {
    parsedData() {
      return JSON.parse(this.customer);
    }
  }
})
</script>