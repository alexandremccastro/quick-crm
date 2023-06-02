import { required, email, helpers } from '@vuelidate/validators'

export const validations = {
  required: helpers.withMessage('This field is required', required),
  email: helpers.withMessage('Must be a valid email', email),
}
