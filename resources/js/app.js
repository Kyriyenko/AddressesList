
require('./bootstrap');

window.Vue = require('vue').default;

import  App from './components/App'
import Navbar from './components/parts/Navbar'
import Modal from './components/parts/Modal'
import Table from './components/parts/Table'


Vue.component('navbar',Navbar);
Vue.component('modal',Modal);
Vue.component('table-model',Table);

const app = new Vue({
    el: '#app',
    render:h=>h(App)
});
