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
                                            <img class="img-fluid rounded" style="max-height: 120px" src="{{ asset($media->path . '/' . $media->fullname) }}" alt="">
                                        </div>
                                        <p class="font-w600 mb-0">
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
                                            <a class="btn btn-sm btn-light" href="javascript:void(0)">
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
                        <div class="col-md-2 d-flex align-items-center">
                            <!-- Example File -->
                            <div class="options-container fx-overlay-zoom-out w-100">
                                <!-- Example File Block -->
                                <div class="options-item block block-rounded bg-body mb-0">
                                    <div class="block-content text-center">
                                        <p class="mb-2 overflow-hidden">
                                            <i class="fa fa-fw fa-4x fa-file-alt text-black"></i>
                                        </p>
                                        <p class="font-w600 mb-0">
                                            notes.txt
                                        </p>
                                        <p class="font-size-sm text-muted">
                                            3kb
                                        </p>
                                    </div>
                                </div>
                                <!-- END Example File Block -->

                                <!-- Example File Hover Options -->
                                <div class="options-overlay rounded-lg bg-white-50">
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
                                            <a class="btn btn-sm btn-light" href="javascript:void(0)">
                                                <i class="fa fa-trash text-danger mr-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Example File Hover Options -->
                            </div>
                            <!-- END Example File -->
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <!-- Example File -->
                            <div class="options-container fx-overlay-zoom-out w-100">
                                <!-- Example File Block -->
                                <div class="options-item block block-rounded bg-body mb-0">
                                    <div class="block-content text-center">
                                        <p class="mb-2 overflow-hidden">
                                            <i class="fa fa-fw fa-4x fa-file-excel text-danger"></i>
                                        </p>
                                        <p class="font-w600 mb-0">
                                            Accounting.xlsx
                                        </p>
                                        <p class="font-size-sm text-muted">
                                            33kb
                                        </p>
                                    </div>
                                </div>
                                <!-- END Example File Block -->

                                <!-- Example File Hover Options -->
                                <div class="options-overlay rounded-lg bg-white-50">
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
                                            <a class="btn btn-sm btn-light" href="javascript:void(0)">
                                                <i class="fa fa-trash text-danger mr-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Example File Hover Options -->
                            </div>
                            <!-- END Example File -->
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <!-- Example File -->
                            <div class="options-container fx-overlay-zoom-out w-100">
                                <!-- Example File Block -->
                                <div class="options-item block block-rounded bg-body mb-0">
                                    <div class="block-content text-center">
                                        <p class="mb-2 overflow-hidden">
                                            <i class="fa fa-fw fa-4x fa-file-word text-default"></i>
                                        </p>
                                        <p class="font-w600 mb-0">
                                            Research.docx
                                        </p>
                                        <p class="font-size-sm text-muted">
                                            50kb
                                        </p>
                                    </div>
                                </div>
                                <!-- END Example File Block -->

                                <!-- Example File Hover Options -->
                                <div class="options-overlay rounded-lg bg-white-50">
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
                                            <a class="btn btn-sm btn-light" href="javascript:void(0)">
                                                <i class="fa fa-trash text-danger mr-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Example File Hover Options -->
                            </div>
                            <!-- END Example File -->
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <!-- Example File -->
                            <div class="options-container fx-overlay-zoom-out w-100">
                                <!-- Example File Block -->
                                <div class="options-item block block-rounded bg-body mb-0">
                                    <div class="block-content text-center">
                                        <p class="mb-2 overflow-hidden">
                                            <i class="fa fa-fw fa-4x fa-file-powerpoint text-warning"></i>
                                        </p>
                                        <p class="font-w600 mb-0">
                                            Presentaton.pptx
                                        </p>
                                        <p class="font-size-sm text-muted">
                                            4.5mb
                                        </p>
                                    </div>
                                </div>
                                <!-- END Example File Block -->

                                <!-- Example File Hover Options -->
                                <div class="options-overlay rounded-lg bg-white-50">
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
                                            <a class="btn btn-sm btn-light" href="javascript:void(0)">
                                                <i class="fa fa-trash text-danger mr-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Example File Hover Options -->
                            </div>
                            <!-- END Example File -->
                        </div>
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
@endpush

@push('scripts')
    <script src="{{ fileManagerAsset('plugins/slick-carousel/slick.min.js') }}"></script>
    <script>
        $('.selectedFiles').slick({
            slidesToShow: 6,
            infinite: false
        });
    </script>
@endpush
