<template>
    <div class="selectedMedias mt-2">
        <div class="row">
            <div class="col-10">
                <carousel-3d :width="120" :height="120" :space="140" :border="0" :infinite="false" :visible="$root.selected_medias.length" :display="7">
                    <slide v-for="(media, key) in $root.selected_medias" :index="key" :key="key">
                        <div class="avatar-xl position-relative">
                            <div class="end-0 position-absolute">
                                <button class="btn p-0" @click="removeMedia(media.id)">
                                    <i class="mdi mdi-18px mdi-close-circle text-danger"></i>
                                </button>
                            </div>
                            <span class="avatar-title bg-light text-secondary rounded">
                                <img :src="media.image" class="img-fluid mh-100">
                            </span>
                        </div>
                    </slide>
                </carousel-3d>
            </div>
            <div class="col-2 d-flex justify-content-center align-items-center">
                <button class="btn btn-primary" @click="sendMedias()">{{ $root.trans.send }}</button>
            </div>
        </div>
    </div>
</template>

<script>
import {Carousel3d, Slide} from 'vue-carousel-3d';

export default {
    name: "SelectedMediasComponent",
    components: {
        Carousel3d,
        Slide
    },
    watch: {
        '$root.selected_medias': {
            handler: function () {
                var self = this;
                self.$root.selected_media_ids = [];
                self.$root.selected_medias.forEach(function (item, index) {
                    self.$root.selected_media_ids.push(item.id)
                });
            },
            deep: true
        }
    },
    methods: {
        removeMedia(id) {
            var self = this;
            self.$root.selected_medias.forEach(function (item, index) {
                if (id === item.id) {
                    self.$root.selected_medias.splice(index, 1);
                    return;
                }
            });
        },
        sendMedias() {
            if(window.CKEditor) {
                if(this.$root.selected_medias[0]) {
                    window.opener.CKEDITOR.tools.callFunction(window.CKEditor, this.$root.selected_medias[0].image);
                }
                window.close();
            } else {
                window.opener.handleMediaManager(this.$root.selected_medias);
                window.close();
            }
        }
    }
}
</script>
