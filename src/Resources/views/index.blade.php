<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Manager</title>
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="{{ asset('vendor/dawnstar/assets/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dawnstar/assets/css/app-modern.min.css') }}" id="light-style">
    <link rel="stylesheet" href="{{ asset('vendor/dawnstar/assets/css/app-modern-dark.min.css') }}" id="dark-style">
    <link rel="stylesheet" href="{{ asset('vendor/media-manager/assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/media-manager/assets/css/media-manager.css') }}">
</head>

<body class="loading" data-layout="detached">
<div class="container-fluid">
    <div class="wrapper">
        <div class="content-page py-0">
            <div class="content" id="mediaManager">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <sidebar-component></sidebar-component>

                                <div class="page-aside-right">
                                    <filter-component></filter-component>

                                    <div v-if="$root.data_type === 'media'">
                                        <media-library-component v-if="$root.is_trashed === false"></media-library-component>
                                        <media-trash-component v-else-if="$root.is_trashed === true"></media-trash-component>
                                    </div>

                                    <div v-else-if="$root.data_type === 'folder'">
                                        <folder-library-component v-if="$root.is_trashed === false"></folder-library-component>
                                        <folder-trash-component v-else-if="$root.is_trashed === true"></folder-trash-component>
                                    </div>

                                    <selected-medias-component></selected-medias-component>
                                </div>

                                <new-folder-modal></new-folder-modal>
                                <new-media-modal></new-media-modal>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('vendor/dawnstar/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/dawnstar/assets/js/app.min.js') }}"></script>
<script src="{{ asset('vendor/media-manager/assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('vendor/media-manager/assets/js/media-manager.js') }}"></script>
<script>
    window.csrf = '{{ csrf_token() }}'
    function showNotification(type, message) {
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "showDuration": "100",
            "hideDuration": "750",
            "timeOut": "2000",
            "extendedTimeOut": "750",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        if (type === 'success') {
            toastr.success(message)
        } else if (type === 'error') {
            toastr.error(message)
        }
    }
</script>
<script src="{{ mix('js/compile.js') }}"></script>
</body>
</html>
