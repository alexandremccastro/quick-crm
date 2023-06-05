<template>
  <form autocomplete="off" ref="customerForm" :method="validMethod" :action="action" @submit="attemptSave">
    <input v-if="['PUT', 'PATCH'].includes(this.method)" type="hidden" :value="method" name="method" />
    <div class="card-body px-6 py-4">
      <div class="grid grid-cols-12 gap-5">
        <TextField label="Name" name="name" class="col-span-6" type="text" v-model="v$.customer.name.$model"
          :errors="v$.customer.name.$errors" />

        <Datepicker label="Birth Date" name="birth_date" class="col-span-2" pattern="yyyy/mm/dd" type="text"
          v-model="v$.customer.birth_date.$model" :errors="v$.customer.birth_date.$errors" />
      </div>

      <div class="grid grid-cols-12 gap-5">
        <TextField label="CPF" name="cpf" mask="###.###.###-##" class="col-span-3" type="text"
          v-model="v$.customer.cpf.$model" :errors="v$.customer.cpf.$errors" />

        <TextField label="CNPJ" mask="##.###.###/####-##" class="col-span-3" name="cnpj" type="text"
          v-model="v$.customer.cnpj.$model" :errors="v$.customer.cnpj.$errors" />

        <TextField label="Phone" name="phone" class="col-span-2" type="text" v-model="v$.customer.phone.$model"
          :errors="v$.customer.phone.$errors" />
      </div>
    </div>

    <fieldset class="p-6 w-full">
      <legend class="text-lg border-b w-full">Addresses</legend>

      <AddressForm index="0" :data="data?.addresses[0]" />
    </fieldset>

    <div class="card-actions flex justify-end px-6 py-4 border-t">
      <button class="btn  btn-primary w-[100px]" type="submit">Save</button>
    </div>
  </form>
</template>
<script>
import { defineComponent } from 'vue';
import TextField from '@/components/Form/TextField.vue';
import Datepicker from '@/components/Form/Datepicker.vue';
import { useVuelidate } from '@vuelidate/core'
import { validations as mockedValidations } from '@/core/validations/mock'
import AddressForm from '@/components/Address/Form.vue'


export default defineComponent({
  name: 'CustomerForm',
  components: { TextField, AddressForm, Datepicker },
  setup() {
    return { v$: useVuelidate() }
  },
  props: ['action', 'method', 'data'],
  data() {
    return {
      customer: {
        name: '',
        birth_date: '',
        cpf: '',
        cpnj: '',
        phone: ''
      }
    }
  },
  created() {
    this.customer = { ...this.data }
  },
  validations() {
    const { required, cpf, cnpj } = mockedValidations

    return {
      customer: {
        name: { required },
        birth_date: { required },
        cpf: { required, cpf },
        cnpj: { required, cnpj },
        phone: { required },
      }
    }
  },
  computed: {
    validMethod() {
      if (['POST', 'GET'].includes(this.method)) return this.method
      else if (['PATCH', 'PUT'].includes(this.method)) return 'POST';
    }
  },
  methods: {
    async attemptSave(e) {
      const isValidated = await this.v$.$validate()

      if (!isValidated) e.preventDefault()
    }
  }
})
</script>