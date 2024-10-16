import { createApp } from 'vue';
import App from './components/app.vue';
import test from './components/test.vue';
import './bootstrap';


const app = createApp({});
app.component('App', App);
app.component('test', test);
app.mount('#app');