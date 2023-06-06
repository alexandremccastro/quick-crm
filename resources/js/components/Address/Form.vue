<template>
  <fieldset class=" p-2 pt-4 rounded relative w-full mb-5">
    <legend class="text-lg w-full border-b flex justify-between">Address #{{ index }} <button class="btn btn-xs  "
        v-if="index !== 1" type="button" @click="remove">Remove</button>
    </legend>
    <div class="grid grid-cols-12 gap-5">
      <input type="hidden" :name="`address[${index}][id]`" :value="address.id" />
      <TextField label="Street" :name="`address[${index}][street]`" class="col-span-4" type="text"
        v-model="v$.address.street.$model" :errors="v$.address.street.$errors" />

      <TextField label="Number" :name="`address[${index}][number]`" class="col-span-2" type="text"
        v-model="v$.address.number.$model" :errors="v$.address.number.$errors" />
    </div>

    <div class="grid grid-cols-12 gap-5">
      <TextField label="Zip Code" mask="#####-###" :name="`address[${index}][zip_code]`" class="col-span-2" type="text"
        v-model="v$.address.zip_code.$model" :errors="v$.address.zip_code.$errors" />

      <TextField label="City" class="col-span-2" :name="`address[${index}][city]`" type="text"
        v-model="v$.address.city.$model" :errors="v$.address.city.$errors" />

      <TextField label="State" :name="`address[${index}][state]`" class="col-span-2" type="text"
        v-model="v$.address.state.$model" :errors="v$.address.state.$errors" />

      <SelectField label="Country" :items="countries" itemText="name" itemValue="code"
        :name="`address[${index}][country]`" class="col-span-2" type="text" v-model="v$.address.country.$model"
        :errors="v$.address.country.$errors" />
    </div>
  </fieldset>
</template>
<script>
import { defineComponent } from 'vue';
import TextField from '@/components/Form/TextField.vue';
import SelectField from '@/components/Form/SelectField.vue';
import { useVuelidate } from '@vuelidate/core'
import { validations as mockedValidations } from '@/core/validations/mock'
import { countries } from '@/core/helpers/index'
import { maxLength } from '@vuelidate/validators';

export default defineComponent({
  name: 'AddressForm',
  components: { TextField, SelectField },
  setup() {
    return { v$: useVuelidate() }
  },
  props: ['index', 'data'],
  data() {
    return {
      address: {
        id: null,
        street: '',
        number: '',
        zip_code: '',
        city: '',
        state: '',
        country: ''
      },
      countries
    }
  },
  created() {
    this.address = { ...this.data }
  },
  validations() {
    const { required } = mockedValidations

    return {
      address: {
        street: { required, maxLenght: maxLength(100) },
        number: { required, maxLenght: maxLength(20) },
        zip_code: { required, maxLenght: maxLength(10) },
        city: { required, maxLenght: maxLength(100) },
        state: { required, maxLenght: maxLength(100) },
        country: { required, maxLenght: maxLength(2) }
      }
    }
  },
  methods: {
    async attemptSave(e) {
      const isValidated = await this.v$.$validate()

      if (!isValidated) e.preventDefault()
    },
    remove() {
      this.$emit('remove', this.index - 1)
    }
  }
})
</script>