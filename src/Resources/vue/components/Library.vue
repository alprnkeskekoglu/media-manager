<template>
    <div class="d-flex flex-column min-vh-100">
        <header id="page-header">
            <div class="content-header">
                <div class="row d-flex align-items-center w-100">
                    <div class="col-md-4">
                        <select class="form-control border-0 rounded" v-model="folder" @change="getMedias">
                            <option value="">
                                {{ trans.file }}
                            </option>
                            <option :value="mediaFolder.name" v-for="mediaFolder in mediaFolders"> {{ mediaFolder.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control border-0 rounded" v-model="order" @change="getMedias">
                            <option value="date-b">
                                {{ trans.date_n_o }}
                            </option>
                            <option value="date-k">
                                {{ trans.date_o_n }}
                            </option>
                            <option value="a-z">
                                {{ trans.alphabetic_a_z }}
                            </option>
                            <option value="z-a">
                                {{ trans.alphabetic_z_a }}
                            </option>
                            <option value="size-b">
                                {{ trans.size_b_s }}
                            </option>
                            <option value="size-k">
                                {{ trans.size_s_b }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control border-0 rounded" :placeholder="trans.search" v-model="search" @keyup="getMedias">
                    </div>

                </div>
            </div>
        </header>

        <main id="main-container">
            <div class="row no-gutters flex-md-10-auto">
                <div class="col-md-12 order-md-0 bg-body-dark">
                    <div class="content">
                        <div class="row items-push">
                            <div class="col-md-2 d-flex align-items-center" v-for="media in medias">
                                <div class="options-container fx-overlay-zoom-out w-100">
                                    <div class="options-item block block-rounded bg-body mb-0" style="height: 220px">
                                        <div class="block-content text-center">
                                            <div class="mb-2 overflow-hidden" style="height: 120px" v-html="media.html">
                                            </div>
                                            <p class="font-w600 mb-0" style="font-size: 12px">
                                                {{ media.fullname }}
                                            </p>
                                            <p class="font-size-sm text-muted">
                                                {{ media.size }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="options-overlay bg-black-75">
                                        <div class="options-overlay-content">
                                            <div class="mb-3">
                                                <a class="btn btn-hero-light" href="javascript:void(0)">
                                                    <i class="fa fa-eye text-primary mr-1"></i> {{ trans.view }}
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn btn-sm btn-light" href="javascript:void(0)" v-if="!media.is_trashed && selectedMedias[media.id] == undefined" @click="selectMedia(media)">
                                                    <i class="fa fa-check text-success mr-1"></i>
                                                </a>
                                                <a class="btn btn-sm btn-light" href="javascript:void(0)" v-else-if="!media.is_trashed && selectedMedias[media.id] != undefined" @click="selectMedia(media)">
                                                    <i class="fa fa-times text-warning mr-1"></i>
                                                </a>
                                                <a class="btn btn-sm btn-light" href="javascript:void(0)" v-if="media.is_trashed" @click="recoverMedia(media.id)">
                                                    <i class="fa fa-sync-alt text-success mr-1"></i>
                                                </a>
                                                <a class="btn btn-sm btn-light" href="javascript:void(0)" v-else @click="deleteMedia(media.id)">
                                                    <i class="fa fa-trash text-danger mr-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <footer id="page-footer" class="bg-white" style="height: 140px" v-if="Object.keys(selectedMedias).length > 0">
            <div class="content py-0">
                <div class="row">
                    <div class="col-md-10">
                        <splide :options="sliderSettings" ref="splide">
                            <splide-slide v-for="(selectedMedia, index) in selectedMedias" v-bind:key="index">
                                <a href="javascript:void(0);" @click="selectMedia(selectedMedia)" class="float-right"><i class="fa fa-times text-danger"></i></a>
                                <div class="text-center d-inline-block">
                                    <div style="height: 80px" v-html="selectedMedia.selected_html">

                                    </div>
                                    <small v-html="selectedMedia.fullname"></small>
                                </div>
                            </splide-slide>
                        </splide>
                    </div>
                    <div class="col-md-2 m-auto text-center">
                        <button class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans.add_files }}</button>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>


<script>
import '@splidejs/splide/dist/css/themes/splide-default.min.css';
import {Splide, SplideSlide} from '@splidejs/vue-splide';

export default {
    name: "Library",
    components: {
        Splide,
        SplideSlide,
    },
    data() {
        return {
            folder: '',
            order: 'date-b',
            search: '',
            medias: {},
            mediaFolders: {},
            selectedMedias: {},
            type: window.type,
            trans: window.trans,
            sliderSettings: {
                perPage: 5,
                perMove: 5,
                fixedHeight: '100px',
                height: '120px',
                autoWidth: true,
                gap: '2em',
                padding: '5em',
            }
        }
    },
    mounted() {
        this.getMediaFolders();
        this.getMedias();
        console.log(window.trans);
    },
    methods: {
        getMediaFolders() {
            let self = this;
            axios.get(window.getMediaFolderRoute).then(function (response) {
                self.mediaFolders = response.data.folders;
            });
        },
        getMedias() {
            let self = this;
            axios.get(window.getMediaRoute, {
                params: {
                    type: self.type,
                    folder: self.folder,
                    order: self.order,
                    search: self.search,
                }
            }).then(function (response) {
                self.medias = response.data.medias;
            });
        },
        selectMedia(media) {

            if(this.selectedMedias[media.id] === undefined) {
                this.$set(this.selectedMedias, media.id, media)
            } else {
                this.$delete(this.selectedMedias, media.id)
            }

            if(this.$refs.splide) {
                this.$refs.splide.remount();
            }
        },
        deleteMedia(id) {
            let self = this;
            window.axios.post(window.deleteMediaRoute, {'media_id': id})
                .then(function (response) {
                    self.getMedias()
                })
        },
        recoverMedia(id) {
            let self = this;
            window.axios.post(window.recoverMediaRoute, {'media_id': id})
                .then(function (response) {
                    self.getMedias()
                })
        },
    }
}
</script>
