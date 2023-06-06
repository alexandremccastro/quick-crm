import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime.js'
import timezone from 'dayjs/plugin/timezone.js'
import utc from 'dayjs/plugin/utc.js'
dayjs.extend(relativeTime)
dayjs.extend(utc)
dayjs.extend(timezone)

import Login from './pages/auth/Login.vue'
import Register from './pages/auth/Register.vue'
import Sidebar from './components/Layout/Sidebar.vue'
import Navbar from './components/Layout/Navbar.vue'
import Home from './pages/Home.vue'
import CreateCustomer from './pages/customers/Create.vue'
import EditCustomer from './pages/customers/Edit.vue'
import ListCustomer from './pages/customers/Index.vue'
import Favorite from './pages/customers/Favorites.vue'

export const registerComponents = (app) => {
  app.component('Login', Login)
  app.component('Register', Register)
  app.component('Sidebar', Sidebar)
  app.component('Navbar', Navbar)
  app.component('HomePage', Home)
  app.component('CreateCustomer', CreateCustomer)
  app.component('EditCustomer', EditCustomer)
  app.component('ListCustomer', ListCustomer)
  app.component('Favorite', Favorite)
}

export const registerHelpers = (app) => {
  app.config.globalProperties.$filters = {
    formatDate(value) {
      return dayjs(value).fromNow()
    },
    maskCPF(cpf) {
      const digitsOnly = cpf.replace(/\D/g, '') // Remove non-digit characters

      const maskedCPF = digitsOnly.replace(
        /(\d{3})(\d{3})(\d{3})(\d{2})/,
        '$1.$2.$3-$4'
      )

      return maskedCPF
    },
    maskCNPJ(cnpj) {
      const digitsOnly = cnpj.replace(/\D/g, '') // Remove non-digit characters

      const maskedCNPJ = digitsOnly.replace(
        /(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/,
        '$1.$2.$3/$4-$5'
      )

      return maskedCNPJ
    },
  }
}
