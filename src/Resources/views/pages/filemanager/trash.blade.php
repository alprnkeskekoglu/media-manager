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
                                            <img class="img-fluid rounded" style="max-height: 120px" src="{{ $media->url }}">
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
                                            <a class="btn btn-sm btn-light recoverBtn" data-id="{{ $media->id }}" href="javascript:void(0)">
                                                <i class="fa fa-sync-alt text-success mr-1"></i>
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
@endsection

@push('scripts')
    <script>
        jQuery('.recoverBtn').on('click', e => {
            var mediaId = e.currentTarget.getAttribute('data-id');

            $.ajax({
                'url': '{{ route('dawnstar.filemanager.recover') }}',
                'method': 'POST',
                'data': {'media_id': mediaId, '_token': '{{ csrf_token() }}'},
                success: function (response) {
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                },
                error: function (response) {
                    alert(response.responseJSON.message);
                }
            })
        });
    </script>
@endpush
