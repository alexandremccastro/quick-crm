<template>
  <div class="flex items-center mb-3 justify-between">
    <h1 class="text-lg">Create Customer</h1>

    <div class="text-sm breadcrumbs">
      <ul>
        <li><a href="/customers">Customers</a></li>
        <li>Create</li>
      </ul>
    </div>
  </div>
  <div class="card bg-base-100 rounded-lg h-full shadow-sm">
    <Form action="/customers" method="POST" :data="customer"></Form>
  </div>
</template>
<script>
import { defineComponent } from 'vue';
import Form from './Form.vue';

export default defineComponent({
  name: 'CreateCustomer',
  components: { Form },
  data() {
    return {
      customer: {
        addresses: [
          {
            street: '',
            number: '',
            zip_code: '',
            state: '',
            city: '',
            country: ''
          }
        ]
      }
    }
  }
})
</script>