import '../css/app.css'; // Ikiwa unatumia CSS ya kawaida
// au
import '../css/app.scss'; // Ikiwa unatumia SCSS/SASS

import { createApp } from 'vue'; // Ikiwa unatumia Vue.js
import App from './components/App.vue'; // Mfano wa component ya Vue

createApp(App).mount("#app"); // Mount Vue kwenye element yenye ID "app"
