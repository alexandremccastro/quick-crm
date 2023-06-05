import './index.scss'

import { createApp } from 'vue'
import { vMaska } from 'maska'
import { registerComponents, registerHelpers } from './boot'

const app = createApp().directive('maska', vMaska)

registerComponents(app)
registerHelpers(app)

app.mount('#app')
