<template>
  <form autocomplete="off" ref="customerForm" :method="validMethod" :action="action" @submit="attemptSave">
    <input v-if="['PUT', 'PATCH'].includes(this.method)" type="hidden" :value="method" name="method" />
    <div class="card-body px-6 py-4">
      <div class="grid grid-cols-12 gap-5">
        <TextField label="Name" name="name" class="col-span-6" type="text" v-model="v$.customer.name.$model"
          :errors="v$.customer.name.$errors" />

        <Datepicker label="Birth Date" name="birth_date" class="col-span-2" pattern="yyyy-mm-dd" type="text"
          v-model="v$.customer.birth_date.$model" :errors="v$.customer.birth_date.$errors" />
      </div>

      <div class="grid grid-cols-12 gap-5">
        <TextField label="CPF" name="cpf" mask="###.###.###-##" class="col-span-3" type="text"
          v-model="v$.customer.cpf.$model" :errors="v$.customer.cpf.$errors" />

        <TextField label="CNPJ" mask="##.###.###/####-##" class="col-span-3" name="cnpj" type="text"
          v-model="v$.customer.cnpj.$model" :errors="v$.customer.cnpj.$errors" />

        <TextField label="Phone" mask="(##) #####-####" name="phone" class="col-span-2" type="text"
          v-model="v$.customer.phone.$model" :errors="v$.customer.phone.$errors" />
      </div>
    </div>

    <div class="p-6">
      <AddressForm v-for="(address, index) in addresses" :index="index + 1" @remove="removeAddress" :key="index"
        :data="address" />
    </div>

    <div class="card-actions flex justify-between px-6 py-4 border-t">
      <button class="btn flex w-[125px] gap-2 px-2" type="button" @click="addNewAddress">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        <span>Address</span>
      </button>
      <button class="btn btn-primary w-[125px]" type="submit">Save</button>
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
      },
      addresses: []
    }
  },
  created() {
    console.log(this.data)
    this.customer = { ...this.data }
    this.addresses = this.data?.addresses
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
    },
    addNewAddress() {
      this.addresses.push({

      })
    },
    removeAddress(index) {
      this.addresses = this.addresses.filter((address, idx) => idx != index)
    }
  }
})
</script>