import './index.scss'

import { createApp } from 'vue'

import { vMaska } from 'maska'

import Login from './pages/auth/Login.vue'
import Register from './pages/auth/Register.vue'
import Sidebar from './components/Layout/Sidebar.vue'
import Navbar from './components/Layout/Navbar.vue'
import Home from './pages/Home.vue'

import CreateCustomer from './pages/customers/Create.vue'
import EditCustomer from './pages/customers/Edit.vue'
import ListCustomer from './pages/customers/Index.vue'

const app = createApp().directive('maska', vMaska)
app.component('Login', Login)
app.component('Register', Register)
app.component('Sidebar', Sidebar)
app.component('Navbar', Navbar)
app.component('Home', Home)
app.component('CreateCustomer', CreateCustomer)
app.component('EditCustomer', EditCustomer)
app.component('ListCustomer', ListCustomer)
app.mount('#app')
