import 'material-symbols/outlined.css'
import '@fontsource/cairo/arabic.css'
import '@fontsource/inter/latin.css'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import '../css/app.css'

const app = createApp(App)
app.use(createPinia())
app.use(router)
app.mount('#app')