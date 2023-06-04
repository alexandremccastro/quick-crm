<template>
  <div class="flex w-full h-full items-center justify-center">
    <section class="card w-80 bg-base-100 shadow-md rounded-lg">
      <article class="card-body py-6 px-8 text-center">
        <h1 class="text-2xl w-full"><span class="text-gray-600">Quick</span>CRM</h1>
        <p class="text-sm">Fill the form to register</p>

        <template v-if="parsedAlert">
          <Alert :type="parsedAlert.type" :message="parsedAlert.message" />
        </template>

        <form method="post" action="/register" @submit="attemptRegister">
          <TextField label="Name" name="name" v-model="v$.user.name.$model" :errors="v$.user.name.$errors" type="text" />
          <TextField label="Email" name="email" v-model="v$.user.email.$model" :errors="v$.user.email.$errors"
            type="text" />

          <TextField label="Password" name="password" v-model="v$.user.password.$model" :errors="v$.user.password.$errors"
            type="password" />

          <button class="btn btn-primary mb-2 w-full" type="submit">Register</button>
        </form>

        <p class="text-sm">Already has an account? <a href="/login" class="link-primary">Go to Login</a></p>
      </article>
    </section>
  </div>
</template>
<script>
import { defineComponent } from 'vue';
import TextField from '@/components/Form/TextField.vue';
import { useVuelidate } from '@vuelidate/core'
import { validations as mockedValidations } from '@/core/validations/mock'
import Alert from '@/components/Widgets/Alert.vue';
import { parseJSON, isDefined } from '@/core/helpers/index';

export default defineComponent({
  name: 'RegisterPage',
  components: { TextField, Alert },
  setup() {
    return { v$: useVuelidate() }
  },
  props: {
    name: {
      type: String,
      default: ''
    },
    alert: {
      default: () => { }
    }
  },
  data() {
    return {
      user: {
        name: '',
        email: '',
        password: ''
      }
    }
  },
  computed: {
    parsedAlert() {
      return isDefined(this.alert) ? parseJSON(this.alert) : null
    }
  },
  validations() {
    const { email, required } = mockedValidations

    return {
      user: {
        name: { required },
        email: { required, email },
        password: { required }
      }
    }
  },
  methods: {
    async attemptRegister(e) {
      const isValidated = await this.v$.$validate()

      if (!isValidated) e.preventDefault()
    }
  }
})
</script>