<template>
    <div class="row" v-if="Object.keys($root.trans).length">
        <div class="col-lg-3 col-md-6 mb-md-2">
            <select class="form-select" v-model="$root.filter.folder" v-if="$root.data_type === 'media' && !$root.is_trashed">
                <option value="">{{ $root.trans.folder.title }}</option>
                <option v-for="folder in $root.folders" :value="folder.id">{{ folder.name }}</option>
            </select>
        </div>
        <div class="col-lg-3 col-md-6 mb-md-2">
            <select class="form-select" v-model="$root.filter.type" v-if="$root.data_type === 'media'">
                <option value="">{{ $root.trans.type.all }}</option>
                <option value="file">{{ $root.trans.type.file }}</option>
                <option value="image">{{ $root.trans.type.image }}</option>
                <option value="audio">{{ $root.trans.type.audio }}</option>
                <option value="video">{{ $root.trans.type.video }}</option>
            </select>
        </div>
        <div class="col-lg-3 col-md-6">
            <select class="form-select" v-model="$root.filter.order" v-if="$root.data_type === 'media'">
                <option value="uploaded_asc">{{ $root.trans.order.uploaded_asc }}</option>
                <option value="uploaded_desc">{{ $root.trans.order.uploaded_desc }}</option>
                <option value="name_asc">{{ $root.trans.order.name_asc }}</option>
                <option value="name_desc">{{ $root.trans.order.name_desc }}</option>
                <option value="size_asc">{{ $root.trans.order.size_asc }}</option>
                <option value="size_desc">{{ $root.trans.order.size_desc }}</option>
            </select>
        </div>
        <div class="col-lg-3 col-md-6">
            <input type="text" class="form-control" :placeholder="$root.trans.search" v-model="$root.filter.search">
        </div>
    </div>
</template>

<script>
export default {
    name: "FilterComponent"
}
</script>
