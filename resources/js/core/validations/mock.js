import { required, email, helpers } from '@vuelidate/validators'
import { cnpj, cpf } from '../helpers'

export const validations = {
  required: helpers.withMessage('This field is required', required),
  email: helpers.withMessage('Must be a valid email', email),
  cpf: helpers.withMessage('Must be a valid CPF', cpf),
  cnpj: helpers.withMessage('Must be a valid CNPJ', cnpj),
}
