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
        filter: {
            folder: '',
            type: '',
            order: 'uploaded_desc',
            search: ''
        },
        trans: {},

        selected_medias: [],
        selected_media_ids: [],
        selectable: null,
        max_count: null,
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
    },
    beforeMount() {
        this.getTranslations();

        const params = new URLSearchParams(window.location.search);

        if(params.has('maxCount')) {
            this.max_count = params.get('maxCount');
        }
        if(params.has('selectable')) {
            this.selectable = params.get('selectable');
        }
        if(params.has('selectedMediaIds')) {
            this.getSelectedMedias(params.get('selectedMediaIds'));
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
        },
        getSelectedMedias(ids) {
            var self = this;
            axios.get('/dawnstar/media-manager/medias/getSelected', {params: {ids: ids}})
                .then(function (response) {
                    self.selected_medias = response.data.medias;
                });
        },
        getTranslations() {
            var self = this;
            axios.get('/dawnstar/media-manager/translations')
                .then(function (response) {
                    self.trans = response.data;
                });
        }
    }

});
