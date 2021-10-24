<template>
    <div class="mt-3">
        <div class="row mx-n1 g-0" style="height: 540px;">
            <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-6" v-for="media in $root.medias.data">
                <div class="card m-1 shadow-none border">
                    <div class="p-2">
                        <div class="row">
                            <div class="col-8">
                                <div class="avatar-xl">
                                    <span class="avatar-title bg-light text-secondary rounded">
                                        <img :src="media.image" class="img-fluid mh-100">
                                    </span>
                                </div>
                                <p class="text-muted fw-bold text-center mb-0" style="width: 7.5rem">{{ media.name }}</p>
                            </div>
                            <div class="col-4 ps-1 ps-md-2">
                                <div class="ms-2">
                                    <div>
                                        <a href="javascript:void(0);" @click=recoverMedia(media)>
                                            <i class="mdi mdi-24px mdi-restore"></i>
                                        </a>
                                        <a href="javascript:void(0);" @click=forceDeleteMedia(media)>
                                            <i class="mdi mdi-24px mdi-delete-alert"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="bottom-0 end-0 font-11 fw-bold mb-0 me-1 position-absolute text-muted">{{ media.size }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-2">
            <pagination :data="$root.medias" :align="'center'" :show-disabled="true" @pagination-change-page="$root.getMedias">
                <span slot="prev-nav">&lt;</span>
                <span slot="next-nav">&gt;</span>
            </pagination>
        </div>
    </div>
</template>

<script>
export default {
    name: "LibraryComponent",
    methods: {
        recoverMedia(media) {
            var self = this;
            axios.post('/dawnstar/media-manager/medias/recover', {id: media.id})
                .then(function (response) {
                    self.$root.getMedias();
                    showNotification('success', response.data.message);
                })
        },
        forceDeleteMedia(media) {
            var self = this;
            axios.post('/dawnstar/media-manager/medias/force-delete', {id: media.id})
                .then(function (response) {
                    self.$root.getMedias();
                    showNotification('success', response.data.message);
                })
        }
    }
}
</script>
