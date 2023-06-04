<template>
  <div class="flex w-full h-full items-center justify-center">
    <section class="card w-80 bg-base-100 shadow-md">
      <article class="card-body py-6 px-8 text-center">
        <h1 class="text-2xl w-full"><span class="text-gray-600">Quick</span>CRM</h1>
        <p class="text-sm">Type your credentials to enter</p>

        <template v-if="parsedAlert">
          <Alert :type="parsedAlert.type" :message="parsedAlert.message" />
        </template>

        <form ref="loginForm" method="post" action="/login" @submit="attemptLogin">
          <TextField label="Email" name="email" type="text" v-model="v$.user.email.$model"
            :errors="v$.user.email.$errors" />

          <TextField label="Password" name="password" type="password" v-model="v$.user.password.$model"
            :errors="v$.user.password.$errors" />


          <button class="btn btn-primary w-full mb-2" @click="attemptLogin">Login</button>
        </form>


        <p class="text-sm">Need an account? <a href="/register" class="link-primary">Create One</a></p>
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
  name: 'LoginPage',
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

  computed: {
    parsedAlert() {
      return isDefined(this.alert) ? parseJSON(this.alert) : null
    }
  },
  data() {
    return {
      user: {
        email: '',
        password: ''
      }
    }
  },
  validations() {
    const { required, email } = mockedValidations
    return {
      user: {
        email: { required, email },
        password: { required }
      }
    }
  },

  methods: {
    async attemptLogin(e) {

      const isValidated = await this.v$.$validate()

      if (!isValidated) e.preventDefault()
    }
  },
})
</script>