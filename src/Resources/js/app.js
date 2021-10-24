/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('sidebar-component', require('./components/includes/SidebarComponent.vue').default);
Vue.component('filter-component', require('./components/includes/FilterComponent.vue').default);
Vue.component('selected-medias-component', require('./components/includes/SelectedMediasComponent.vue').default);

Vue.component('media-library-component', require('./components/medias/LibraryComponent.vue').default);
Vue.component('media-trash-component', require('./components/medias/TrashComponent.vue').default);

Vue.component('folder-library-component', require('./components/folders/LibraryComponent.vue').default);
Vue.component('folder-trash-component', require('./components/folders/TrashComponent.vue').default);

Vue.component('new-folder-modal', require('./components/modals/NewFolderComponent.vue').default);
Vue.component('new-media-modal', require('./components/modals/NewMediaComponent.vue').default);

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('vueDropzone', require('vue2-dropzone'));

const app = new Vue({
    el: '#mediaManager',
    data: {
        data_type: 'media',
        is_private: false,
        is_trashed: false,
        folders: {},
        medias: {},
        selected_medias: [],
        filter: {
            folder: '',
            type: '',
            order: 'uploaded_desc',
            search: ''
        },
        trans: {},
    },
    watch: {
        is_private: function (value) {
            document.querySelector('body').style.visibility = 'hidden';
            if(value === true) {
                document.getElementById('dark-style').removeAttribute('disabled')
                document.getElementById('light-style').setAttribute('disabled', true)
                document.querySelector('body').classList.add('dark');
            } else {
                document.getElementById('light-style').removeAttribute('disabled')
                document.getElementById('dark-style').setAttribute('disabled', true)
                document.querySelector('body').classList.remove('dark');
            }

            setTimeout(function() {
                document.querySelector('body').style.visibility = 'visible';
            }, 500);

            this.getFolders();
            this.getMedias();
        },
        filter: {
            handler: function () {
                this.getMedias();
            },
            deep: true
        },
        selected_medias: function (value) {
            console.log(value);
        }
    },
    mounted() {
        this.getFolders();
        this.getMedias();
    },
    methods: {
        getFolders() {
            var self = this;
            var params = {
                private: self.is_private,
                trashed: self.is_trashed
            };
            axios.get('/dawnstar/media-manager/folders', {params: params})
                .then(function (response) {
                    self.folders = response.data.folders;
                });
        },
        getMedias() {
            var self = this;
            var params = self.filter;
            params['private'] = self.is_private;
            params['trashed'] = self.is_trashed

            axios.get('/dawnstar/media-manager/medias', {params: params})
                .then(function (response) {
                    self.medias = response.data.medias;
                });
        }
    }

});
