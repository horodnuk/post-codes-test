import { createApp } from 'vue';

import { Dialog, LoadingBar, Notify, Quasar } from 'quasar';

import pinia from './stores';
import router from './router';

// Import Quasar css
import 'quasar/src/css/index.sass';

import App from './App.vue';

const app = createApp(App);

app.use(router);
app.use(Quasar, {
  plugins: {
    Notify,
    Dialog,
    LoadingBar,
  },
});

app.use(pinia);

app.mount('#app');
