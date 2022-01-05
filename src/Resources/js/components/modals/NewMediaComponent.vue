<template>
    <div id="newMediaModal" data-bs-backdrop="static" data-bs-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="newMediaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="newMediaModalLabel">{{ $root.trans.media ? $root.trans.media.create_title : '' }}</h4>
                    <button type="button" class="btn-close" id="newFolderModalClose" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="folder" class="form-label">{{ $root.trans.create ? $root.trans.create.folder : '' }}</label>
                        <select class="form-control" id="folder" v-model="folder">
                            <option value="">{{ $root.trans.folder ? $root.trans.folder.home : '' }}</option>
                            <option :value="folder.id" v-for="folder in $root.folders"> {{ folder.name }}</option>
                        </select>
                    </div>

                    <ul class="nav nav-tabs nav-justified nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#computer" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                <span class="d-none d-md-block">{{ $root.trans.media ? $root.trans.media.upload.device : '' }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#url" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                <span class="d-none d-md-block">{{ $root.trans.media ? $root.trans.media.upload.url : '' }}</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane show active" id="computer">
                            <div class="mb-3">
                                <vue-dropzone id="dropzone" :options="dropzoneOptions" :useCustomSlot=true v-on:vdropzone-sending="addData">
                                    <div>
                                        <h3>{{ $root.trans.media ? $root.trans.media.dropzone.title : '' }}</h3>
                                        <div>{{ $root.trans.media ? $root.trans.media.dropzone.text : '' }}</div>
                                    </div>
                                </vue-dropzone>
                            </div>
                        </div>
                        <div class="tab-pane" id="url">
                            <div class="row mb-3">
                                <div class="col-10">
                                    <input type="text" v-model="url" class="form-control">
                                </div>
                                <div class="col-2 text-end">
                                    <button class="btn btn-primary" @click="uploadFromUrl">{{ $root.trans.upload }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
export default {
    name: "NewMediaComponent",
    data() {
        return {
            folder: '',
            url: '',
            dropzoneOptions: {
                url: '/dawnstar/media-manager/medias',
                timeout: 180000,
                maxFilesize: 2048,
                thumbnailWidth: 100,
                thumbnailHeight: 100,
                acceptedFiles: '' +
                    '.gif, .jpg, .jpeg, .png, .svg+xml, .tiff, ' +
                    '.xls, .xlsx, .doc, .docx, .ppt, .pptx, .zip, ' +
                    'video/*, ' +
                    'audio/*, ' +
                    'application/pdf, ' +
                    'application/json, ' +
                    'application/illustrator, ' +
                    'text/plain'
            }
        }
    },
    mounted() {
        var self = this;
        var mediaModal = document.getElementById('newMediaModal')
        mediaModal.addEventListener('hide.bs.modal', function (event) {
            self.$root.getMedias();
            self.$root.getFolders();
        })
    },
    methods: {
        uploadFromUrl() {
            var self = this;
            axios.post('/dawnstar/media-manager/medias', {folder_id: self.folder, url: self.url, private: self.$root.is_private})
                .then(function (response) {
                    showNotification('success', response.data.message);
                })
                .catch(function (error) {
                });
        },
        addData(file, xhr, formData) {
            formData.append('_token', window.csrf);
            formData.append('folder_id', this.folder);
            formData.append('private', this.$root.is_private);
        }
    }
}
</script>
