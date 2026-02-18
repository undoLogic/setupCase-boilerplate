import { createApp } from 'vue'
import { createPinia } from 'pinia'
import router from '@/router'
import App from '@/App.vue'



import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

import "./style.css";     // ← ADD THIS

createApp(App)
    .use(createPinia())
    .use(router)
    .mount('#app')