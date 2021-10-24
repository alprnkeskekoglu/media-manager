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
                                    <a href="javascript:void(0);" @click=recoverFolder(folder)>
                                        <i class="mdi mdi-24px mdi-restore"></i>
                                    </a>
                                    <a href="javascript:void(0);" @click="forceDeleteFolder(folder)">
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
        recoverFolder(folder) {
            var self = this;
            axios.post('/dawnstar/media-manager/folders/recover', {id: folder.id})
                .then(function (response) {
                    self.$root.getFolders();
                    showNotification('success', response.data.message);
                })
        },
        forceDeleteFolder(folder) {
            var self = this;
            axios.post('/dawnstar/media-manager/folders/force-delete', {id: folder.id})
                .then(function (response) {
                    self.$root.getFolders();
                    showNotification('success', response.data.message);
                })
        }
    }
}
</script>
