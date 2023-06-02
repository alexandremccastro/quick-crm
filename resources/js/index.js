import './index.scss'

import { createApp } from 'vue'

import Login from './pages/auth/Login.vue'
import Register from './pages/auth/Register.vue'
import Home from './pages/Home.vue'

const app = createApp()
app.component('Login', Login)
app.component('Register', Register)
app.component('Home', Home)
app.mount('#app')
