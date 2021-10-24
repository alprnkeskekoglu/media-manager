<template>
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-md-2">
            <select class="form-select" v-model="$root.filter.folder" v-if="$root.data_type === 'media' && !$root.is_trashed">
                <option value="">Directories</option>
                <option v-for="folder in $root.folders" :value="folder.id">{{ folder.name }}</option>
            </select>
        </div>
        <div class="col-lg-3 col-md-6 mb-md-2">
            <select class="form-select" v-model="$root.filter.type" v-if="$root.data_type === 'media'">
                <option value="">Select</option>
                <option value="file">File</option>
                <option value="image">Image</option>
                <option value="audio">Audio</option>
                <option value="video">Video</option>
            </select>
        </div>
        <div class="col-lg-3 col-md-6">
            <select class="form-select" v-model="$root.filter.order" v-if="$root.data_type === 'media'">
                <option value="uploaded_asc">Uploaded Time: Old to New</option>
                <option value="uploaded_desc">Uploaded Time: New to Old</option>
                <option value="name_asc">Name: Z to A</option>
                <option value="name_desc">Name: A to Z</option>
                <option value="size_asc">Size: Low to High</option>
                <option value="size_desc">Size: High to Low</option>
            </select>
        </div>
        <div class="col-lg-3 col-md-6">
            <input type="text" class="form-control" placeholder="Search files..." v-model="$root.filter.search">
        </div>
    </div>
</template>

<script>
export default {
    name: "FilterComponent"
}
</script>

<style scoped>

</style>
