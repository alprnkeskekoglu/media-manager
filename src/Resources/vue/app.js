require('./bootstrap');
import Vue from 'vue'

Vue.component('filemanager-library', require('./components/Library.vue').default);

Vue.config.productionTip = false;
Vue.config.devtools = false;

const app = new Vue({
    el: '#fileManager',
})
