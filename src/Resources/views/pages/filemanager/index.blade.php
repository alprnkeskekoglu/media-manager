@extends('FileManagerView::layouts.app')

@section('content')
    <header id="page-header">
        <div class="content-header">
            <div class="row d-flex align-items-center w-100">
                <div class="col-md-4">
                    <select class="form-control border-0 rounded" id="target" name="test">
                        <option value="">Folder</option>
                        <option value="">{{ __('DawnstarLang::general.select') }}</option>
                        <option value="">{{ __('DawnstarLang::general.select') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-control border-0 rounded" id="target" name="test">
                        <option value="">Sıralama</option>
                        <option value="">{{ __('DawnstarLang::general.select') }}</option>
                        <option value="">{{ __('DawnstarLang::general.select') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control border-0 rounded" placeholder="Search All Files..">
                </div>

            </div>
        </div>
    </header>
    <main id="main-container">

        <!-- Page Content -->
        <div class="row no-gutters flex-md-10-auto">
            <div class="col-md-12 order-md-0 bg-body-dark">
                <div class="content">
                    <div class="row items-push">
                        @foreach($medias as $media)
                        <div class="col-md-2 d-flex align-items-center">
                            <!-- Example File -->
                            <div class="options-container fx-overlay-zoom-out w-100">
                                <!-- Example File Block -->
                                <div class="options-item block block-rounded bg-body mb-0" style="height: 220px">
                                    <div class="block-content text-center">
                                        <div class="mb-2 overflow-hidden" style="height: 120px">
                                            @if($media->mime_class == 'image')
                                                <img class="img-fluid rounded" style="max-height: 120px" src="{{ $media->url }}">
                                            @elseif($media->mime_class == 'video')
                                                <i class="fa fa-fw fa-5x fa-file-video text-default"></i>
                                            @elseif($media->mime_class == 'audio')
                                                <i class="fa fa-fw fa-5x fa-file-audio text-primary"></i>
                                            @elseif($media->mime_class == 'text')
                                                <i class="fa fa-fw fa-5x fa-file-alt text-black"></i>
                                            @elseif($media->mime_type == 'application/pdf')
                                                <i class="fa fa-fw fa-5x fa-file-pdf text-danger"></i>
                                            @endif
                                        </div>
                                        <p class="font-w600 mb-0" style="font-size: 12px">
                                            {!! $media->fullname !!}
                                        </p>
                                        <p class="font-size-sm text-muted">
                                            {!! unitSizeForHuman($media->size) !!}
                                        </p>
                                    </div>
                                </div>
                                <!-- END Example File Block -->

                                <!-- Example File Hover Options -->
                                <div class="options-overlay bg-black-75">
                                    <div class="options-overlay-content">
                                        <div class="mb-3">
                                            <a class="btn btn-hero-light" href="javascript:void(0)">
                                                <i class="fa fa-eye text-primary mr-1"></i> View
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-light" href="javascript:void(0)">
                                                <i class="fa fa-download text-black mr-1"></i>
                                            </a>
                                            <a class="btn btn-sm btn-light deleteBtn" data-id="{{ $media->id }}" href="javascript:void(0)">
                                                <i class="fa fa-trash text-danger mr-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Example File Hover Options -->
                            </div>
                            <!-- END Example File -->
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer id="page-footer" class="bg-white-90">
        <div class="content py-0">
            <div class="row">
                <div class="col-md-10">
                    <div class="selectedFiles text-center">
                        <div class="py-3">
                            <img class="img-avatar" src="assets/media/avatars/avatar4.jpg" alt="">
                            <div class="font-size-sm text-muted">Graphic Designer</div>
                        </div>
                        <div class="py-3">
                            <img class="img-avatar" src="assets/media/avatars/avatar5.jpg" alt="">
                            <div class="font-size-sm text-muted">Photographer</div>
                        </div>
                        <div class="py-3">
                            <img class="img-avatar" src="assets/media/avatars/avatar6.jpg" alt="">
                            <div class="font-size-sm text-muted">Web Developer</div>
                        </div>
                        <div class="py-3">
                            <img class="img-avatar" src="assets/media/avatars/avatar1.jpg" alt="">
                            <div class="font-size-sm text-muted">Web Designer</div>
                        </div>
                        <div class="py-3">
                            <img class="img-avatar" src="assets/media/avatars/avatar2.jpg" alt="">
                            <div class="font-size-sm text-muted">Font Designer</div>
                        </div>
                        <div class="py-3">
                            <img class="img-avatar" src="assets/media/avatars/avatar3.jpg" alt="">
                            <div class="font-size-sm text-muted">Artist</div>
                        </div>
                        <div class="py-3">
                            <img class="img-avatar" src="assets/media/avatars/avatar2.jpg" alt="">
                            <div class="font-size-sm text-muted">Font Designer</div>
                        </div>
                        <div class="py-3">
                            <img class="img-avatar" src="assets/media/avatars/avatar3.jpg" alt="">
                            <div class="font-size-sm text-muted">Artist</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 m-auto text-center">
                    <button class="btn btn-primary"><i class="fa fa-plus"></i> Ekle </button>
                </div>
            </div>
        </div>
    </footer>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ fileManagerAsset('plugins/slick-carousel/slick.css') }}">
    <link rel="stylesheet" href="{{ fileManagerAsset('plugins/slick-carousel/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ fileManagerAsset('plugins/slick-carousel/slick.min.js') }}"></script>
    <script src="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $('.selectedFiles').slick({
            slidesToShow: 6,
            infinite: false
        });
    </script>

    <script>
        jQuery('.deleteBtn').on('click', e => {
            var mediaId = e.currentTarget.getAttribute('data-id');
            swal.fire({
                title: '{{ __('DawnstarLang::general.swal.title') }}',
                text: '{{ __('DawnstarLang::general.swal.subtitle') }}',
                icon: 'warning',
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn btn-danger m-1',
                    cancelButton: 'btn btn-secondary m-1'
                },
                confirmButtonText: '{{ __('DawnstarLang::general.swal.confirm_btn') }}',
                cancelButtonText: '{{ __('DawnstarLang::general.swal.cancel_btn') }}',
                html: false,
                preConfirm: e => {
                    return new Promise(resolve => {
                        setTimeout(() => {
                            resolve();
                        }, 50);
                    });
                }
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        'url': '{{ route('dawnstar.filemanager.delete') }}',
                        'method': 'POST',
                        'data': {'media_id': mediaId, '_token': '{{ csrf_token() }}'},
                        success: function (response) {
                            swal.fire('{{ __('DawnstarLang::general.swal.success.title') }}', '{{ __('DawnstarLang::general.swal.success.subtitle') }}', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        },
                        error: function (response) {
                            swal.fire('{{ __('DawnstarLang::general.swal.error.title') }}', '{{ __('DawnstarLang::general.swal.error.subtitle') }}', 'error');
                        }
                    })
                }
            });
        });
    </script>
@endpush
