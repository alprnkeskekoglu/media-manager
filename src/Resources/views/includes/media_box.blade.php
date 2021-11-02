<div class="mediaBox">
    <div class="mb-1">
        @isset($label)
        <label class="form-label">{{ $label }}</label>
        @endisset
        <button type="button" class="btn btn-outline-primary float-end font-20 p-0 px-2 mediaManagerBtn" title="Media Manager"
                data-id="{{ $key }}" data-maxcount="{{ $max_count ?? '' }}" data-selectable="{{ $selectable ?? 'image' }}">
            <i class="mdi mdi-image-plus"></i>
        </button>
    </div>
    <div class="mediaList">
        <div class="avatar-xl position-relative" style="background-color: #efefef;">
            <img src="https://via.placeholder.com/150" class="img-fluid mh-100">
        </div>
    </div>
    <input type="hidden" name="medias[{{ $key }}]" id="{{ $key }}">
</div>
