import './index.scss'

import { createApp } from 'vue'

import Login from './pages/auth/Login.vue'
import Register from './pages/auth/Register.vue'
import Sidebar from './components/Layout/Sidebar.vue'
import Navbar from './components/Layout/Navbar.vue'
import Home from './pages/Home.vue'

const app = createApp()
app.component('Login', Login)
app.component('Register', Register)
app.component('Sidebar', Sidebar)
app.component('Navbar', Navbar)
app.component('Home', Home)
app.mount('#app')
