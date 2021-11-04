<div class="mediaBox">
    <div class="mb-1">
        @isset($label)
            <label class="form-label">{{ $label }}</label>
        @endisset
        <button type="button" class="btn btn-outline-info float-end font-20 p-0 px-2 mediaManagerBtn" title="Media Manager"
                data-id="{{ $key }}" data-maxcount="{{ $max_count ?? '' }}" data-selectable="{{ $selectable ?? 'image' }}">
            <i class="mdi mdi-image-plus"></i>
        </button>
    </div>
    <div class="mediaList">
        @if(isset($medias) && $medias->count() > 0)
            @foreach($medias as $media)
                <div class="avatar-xl position-relative" style="background-color: #efefef;">
                    <img src="{{ $media->url }}" class="img-fluid mh-100 rounded">
                    <span class="d-block text-center text-muted">{{ $media->name }}</span>
                    <div class="d-grid end-0 mb-n1 me-n2 position-absolute bottom-0">
                        <a href="javascript:void(0);" class="removeMediaBtn" data-id="{{ $media->id }}">
                            <span class="badge bg-white rounded-pill shadow-sm">
                                <i class="font-14 mdi mdi-close text-danger"></i>
                            </span>
                        </a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="avatar-xl position-relative" style="background-color: #efefef;">
                <img src="https://via.placeholder.com/150" class="img-fluid mh-100 rounded">
            </div>
        @endif
    </div>
    <input type="hidden" name="medias[{{ $key }}]" id="{{ $key }}" value="{{ isset($medias) ? implode(',', $medias->pluck('id')->toArray()) : '' }}">
</div>
