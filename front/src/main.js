import './assets/main.css'

import { createApp} from 'vue'
import App from './App.vue'
import router from './router'
import { library } from "@fortawesome/fontawesome-svg-core";
import { faRemove } from "@fortawesome/free-solid-svg-icons";
import { faEdit } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { key, store } from './store'

library.add(faRemove,faEdit);

const app = createApp(App)
app.use(router)
app.use(store, key)
app.component("font-awesome-icon", FontAwesomeIcon)
app.mount('#app')
