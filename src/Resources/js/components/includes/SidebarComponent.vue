<template>
    <div class="page-aside-left" v-if="Object.keys($root.trans).length">
        <div class="mb-3">
            <img src="/vendor/dawnstar/core/medias/logo.png" v-if="$root.is_private" alt="Dawnstar Media Manager" class="img-fluid rounded" width="210"/>
            <img src="/vendor/dawnstar/core/medias/logo-dark.png" v-else alt="Dawnstar Media Manager" class="img-fluid rounded" width="210"/>
        </div>
        <div class="btn-group d-block mb-2">
            <button type="button" class="btn btn-success dropdown-toggle w-100" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="mdi mdi-plus"></i>
                {{ $root.trans.create.title }}
            </button>
            <div class="dropdown-menu">
                <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#newFolderModal">
                    <i class="mdi mdi-folder-plus-outline me-1"></i>
                    {{ $root.trans.create.folder }}
                </a>
                <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#newMediaModal">
                    <i class="mdi mdi-file-plus-outline me-1"></i>
                    {{ $root.trans.create.media }}
                </a>
            </div>
        </div>
        <div class="email-menu-list mt-3">
            <a href="javascript:void(0)" :class="'list-group-item border-0 rounded-1' + ($root.data_type === 'media' && !$root.is_trashed ? ' active' : '')"
               @click="changePage('media', false)">
                <i class="mdi mdi-folder-image font-18 align-middle me-2"></i>
                {{ $root.trans.media.title }}
            </a>
            <a href="javascript:void(0)" :class="'list-group-item border-0 rounded-1' + ($root.data_type === 'media' && $root.is_trashed ? ' active' : '')"
               @click="changePage('media', true)">
                <i class="mdi mdi-delete font-18 align-middle me-2"></i>
                {{ $root.trans.media.deleted_title }}
            </a>
            <hr>
            <a href="javascript:void(0)" :class="'list-group-item border-0 rounded-1' + ($root.data_type === 'folder' && !$root.is_trashed ? ' active' : '')"
               @click="changePage('folder', false)">
                <i class="mdi mdi-folder font-18 align-middle me-2"></i>
                {{ $root.trans.folder.title }}
            </a>
            <a href="javascript:void(0)" :class="'list-group-item border-0 rounded-1' + ($root.data_type === 'folder' && $root.is_trashed ? ' active' : '')"
               @click="changePage('folder', true)">
                <i class="mdi mdi-delete font-18 align-middle me-2"></i>
                {{ $root.trans.folder.deleted_title }}
            </a>
        </div>

        <div class="mt-lg-4">
            <h6 class="text-uppercase mt-3">{{ $root.trans.storage }}</h6>
            <div class="progress my-2 progress-sm">
                <div :class="'progress-bar progress-lg ' + (rate > 80 ? 'bg-danger' : 'bg-success')" role="progressbar"
                     :style="'width: '+rate+'%'" :aria-valuenow="rate" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <p class="text-muted font-12 mb-0">{{ storage_text }}</p>
        </div>

        <div class="mt-5">
            <p class="text-center text-muted mb-1">{{ $root.trans.mod }}</p>
            <div class="d-flex justify-content-center align-items-center">
                <i class="mdi mdi-18px mdi-lock-open-variant pe-2"></i>
                <input type="checkbox" id="mod" data-switch="secondary" v-model="$root.is_private" value="true"/>
                <label for="mod" data-on-label="" data-off-label=""></label>
                <i class="mdi mdi-18px mdi-lock ps-2"></i>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "SidebarComponent",
    data() {
        return {
            rate: 0,
            storage_text: '',
        }
    },
    mounted() {
        this.getStorageStatus();
    },
    methods: {
        changePage(type, is_trashed) {
            this.$root.is_trashed = is_trashed;
            this.$root.data_type = type;

            this.$root.getMedias();
            this.$root.getFolders();
        },
        getStorageStatus() {
            var self = this;
            axios.get('/dawnstar/media-manager/getStorageStatus')
                .then(function (response) {
                    self.rate = response.data.rate;
                    self.storage_text = response.data.text;
                });
        }
    }
}
</script>

<style scoped>

</style>
