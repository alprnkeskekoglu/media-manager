<template>
    <div id="newFolderModal" data-bs-backdrop="static" data-bs-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="newFolderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="newFolderModalLabel">{{ $root.trans.folder ? $root.trans.folder.create_title : '' }}</h4>
                    <button type="button" class="btn-close" id="newFolderModalClose" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-9">
                            <input type="text" id="folder" v-model="name" :class="'form-control' + (error ? ' is-invalid' : '')" :placeholder="$root.trans.folder ? $root.trans.folder.name : ''">
                            <div class="invalid-feedback d-block" v-if="error">{{ error }}</div>
                        </div>
                        <div class="col-3 text-ent">
                            <button class="btn btn-primary" @click="createNewFolder">{{ $root.trans.save }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NewFolderComponent",
    data() {
        return {
            name: '',
            error: null,
        }
    },
    methods: {
        createNewFolder() {
            var self = this;
            axios.post('/dawnstar/media-manager/folders', {private: self.$root.is_private, name: self.name,})
                .then(function (response) {
                    showNotification('success', response.data.message);
                    document.getElementById('newFolderModalClose').click();
                    self.$root.getFolders();
                })
                .catch(function (error) {
                    var errors = error.response.data.errors;
                    for (var key in errors) {
                        self.error = errors[key][0];
                    }
                });
        }
    }
}
</script>
