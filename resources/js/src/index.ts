import { createApp } from "vue"
import { createPinia } from "pinia"
import App from "./app/App.vue"
import { router } from "./app/router"

const app = createApp(App)

app.use(router)

const pinia = createPinia()

app.use(pinia)

app.mount("#app")
