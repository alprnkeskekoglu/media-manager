<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>Dawnstar - FileManager</title>

    <meta name="description" content="Dashmix - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{ fileManagerAsset('css/dashmix.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ fileManagerAsset('css/xpro.min.css') }}">
</head>
<body>
<div id="page-container" class="sidebar-o side-scroll page-header-fixed page-header-dark">

    <nav id="sidebar" aria-label="Main Navigation">
        <div class="bg-header-dark">
            <div class="content-header bg-white-10">
                <a class="font-w600 text-white tracking-wide" href="javascript:void(0)">
                    <span class="smini-hidden">
                        Dawn<span class="opacity-75">star</span>
                        <span class="font-w400">File Manager</span>
                    </span>
                </a>
            </div>
        </div>
        <div class="js-sidebar-scroll">
            <div class="content-side">
                <ul class="nav-main">
                    <li class="nav-main-item">
                        <a class="nav-main-link active" href="db_file_hosting.html">
                            <i class="nav-main-link-icon fa fa-rocket"></i>
                            <span class="nav-main-link-name">All Files</span>
                        </a>
                    </li>
                    <li class="nav-main-heading">Files</li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="">
                            <i class="nav-main-link-icon fa fa-file-word"></i>
                            <span class="nav-main-link-name">Documents</span>
                            <span class="nav-main-link-badge badge badge-pill badge-secondary">19</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="">
                            <i class="nav-main-link-icon fa fa-file-image"></i>
                            <span class="nav-main-link-name">Photos</span>
                            <span class="nav-main-link-badge badge badge-pill badge-secondary">45</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="">
                            <i class="nav-main-link-icon fa fa-file-video"></i>
                            <span class="nav-main-link-name">Videos</span>
                            <span class="nav-main-link-badge badge badge-pill badge-secondary">65</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="">
                            <i class="nav-main-link-icon fa fa-file-audio"></i>
                            <span class="nav-main-link-name">Audio</span>
                            <span class="nav-main-link-badge badge badge-pill badge-secondary">28</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
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
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">

        <!-- Page Content -->
        <div class="row no-gutters flex-md-10-auto">
            <div class="col-md-12 order-md-0 bg-body-dark">
                <div class="content">
                    <div class="row items-push">
                        <div class="col-md-3 d-flex align-items-center">
                            <!-- Example File -->
                            <div class="options-container fx-overlay-zoom-out w-100">
                                <!-- Example File Block -->
                                <div class="options-item block block-rounded bg-body mb-0">
                                    <div class="block-content text-center">
                                        <p class="mb-2 overflow-hidden">
                                            <img class="img-fluid" src="assets/media/photos/photo22.jpg" alt="">
                                        </p>
                                        <p class="font-w600 mb-0">
                                            background_1.jpg
                                        </p>
                                        <p class="font-size-sm text-muted">
                                            0.9mb
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
                        <div class="col-md-3 d-flex align-items-center">
                            <!-- Example File -->
                            <div class="options-container fx-overlay-zoom-out w-100">
                                <!-- Example File Block -->
                                <div class="options-item block block-rounded bg-body mb-0">
                                    <div class="block-content text-center">
                                        <p class="mb-2 overflow-hidden">
                                            <img class="img-fluid" src="assets/media/photos/photo21.jpg" alt="">
                                        </p>
                                        <p class="font-w600 mb-0">
                                            background_2.jpg
                                        </p>
                                        <p class="font-size-sm text-muted">
                                            3.4mb
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
                        <div class="col-md-3 d-flex align-items-center">
                            <!-- Example File -->
                            <div class="options-container fx-overlay-zoom-out w-100">
                                <!-- Example File Block -->
                                <div class="options-item block block-rounded bg-body mb-0">
                                    <div class="block-content text-center">
                                        <p class="mb-2 overflow-hidden">
                                            <img class="img-fluid" src="assets/media/photos/photo24.jpg" alt="">
                                        </p>
                                        <p class="font-w600 mb-0">
                                            background_3.jpg
                                        </p>
                                        <p class="font-size-sm text-muted">
                                            2.3mb
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
                        <div class="col-md-3 d-flex align-items-center">
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
                        <div class="col-md-3 d-flex align-items-center">
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
                        <div class="col-md-3 d-flex align-items-center">
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
                        <div class="col-md-3 d-flex align-items-center">
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
</div>

<script src="{{ fileManagerAsset('js/dashmix.core.min.js') }}"></script>
</body>
</html>
