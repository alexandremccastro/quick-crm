<template>
  <div class="flex mb-3 justify-between">
    <h1 class="text-lg">Edit Customer</h1>

    <div class="text-sm breadcrumbs">
      <ul>
        <li><a href="/customers">Customers</a></li>
        <li>Edit</li>
      </ul>
    </div>
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

  computed: {
    parsedData() {
      return JSON.parse(this.customer);
    }
  }
})
</script>