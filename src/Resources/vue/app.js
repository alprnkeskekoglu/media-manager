require('./bootstrap');

window.Vue = require('vue');

Vue.component('filemanager-library', require('./components/Library.vue').default);

const app = new Vue({
    el: '#fileManager',
})
