<template>
    <div class="mt-3">
        <div class="row mx-n1 g-0" style="height: 540px;">
            <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-6" v-for="folder in $root.folders">
                <div class="card m-1 shadow-none border">
                    <div class="p-2">
                        <div class="row">
                            <div class="col-3">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-secondary rounded">
                                        <img src="/assets/medias/folder.png" class="img-fluid mh-100">
                                    </span>
                                </div>
                            </div>
                            <div class="col-6 align-self-center text-center">
                                <p class="text-muted fw-bold mb-0" style="width: 7.5rem">{{ folder.name }}</p>
                            </div>
                            <div class="col-3">
                                <div class="ms-1">
                                    <a href="javascript:void(0);" @click="showMedias(folder.id)">
                                        <i class="mdi mdi-18px mdi-arrow-right-bold"></i>
                                    </a>
                                    <a href="javascript:void(0);" @click="deleteFolder(folder.id)">
                                        <i class="mdi mdi-18px mdi-trash-can"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <p class="bottom-0 end-0 font-11 fw-bold mb-0 me-1 position-absolute text-muted">{{ folder.medias_count }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "LibraryComponent",
    methods: {
        showMedias(id) {
            this.$root.filter.folder = id;
            this.$root.data_type = 'media';
        },
        deleteFolder(id) {
            var self = this;
            axios.delete('/dawnstar/media-manager/folders/' + id)
                .then(function (response) {
                    self.$root.getFolders();
                    showNotification('success', response.data.message);
                })
        }
    }
}
</script>
