@php
    $counts = \Dawnstar\FileManager\Models\Media::all()->groupBy(function ($q) {
        return (in_array($q->mime_class, ['image', 'audio', 'video']) ? $q->mime_class : 'file');
    });

    $imageCount = optional($counts->get('image'))->count() ?: 0;
    $fileCount = optional($counts->get('file'))->count() ?: 0;
    $audioCount = optional($counts->get('video'))->count() ?: 0;
    $videoCount = optional($counts->get('audio'))->count() ?: 0;
    $trashedCount = \Dawnstar\FileManager\Models\Media::onlyTrashed()->count();
    $type = $type ?? 'upload';
@endphp
<nav id="sidebar" aria-label="Main Navigation">
    <div class="bg-header-dark">
        <div class="content-header bg-white-10">
            <a class="font-w600 text-white tracking-wide" href="javascript:void(0)">
                <span class="smini-hidden">
                    Dawn<span class="opacity-75">star</span> |
                    <span class="font-w400">File Manager</span>
                </span>
            </a>
        </div>
    </div>
    <div class="js-sidebar-scroll">
        <div class="content-side">
            <ul class="nav-main">
                <li class="nav-main-item mb-3">
                    <a class="nav-main-link {{ $type == 'upload' ? 'active' : '' }}" id="createBtn" href="{{ route('dawnstar.filemanager.upload', $requestParams) }}">
                        <i class="nav-main-link-icon fa fa-plus"></i>
                        <span class="nav-main-link-name">{{ __('FileManagerLang::general.sidebar.upload') }}</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link {{ $type == 'all' ? 'active' : '' }}" id="indexBtn" href="{{ route('dawnstar.filemanager.index', $requestParams) }}">
                        <i class="nav-main-link-icon fa fa-rocket"></i>
                        <span class="nav-main-link-name">{{ __('FileManagerLang::general.sidebar.all') }}</span>
                    </a>
                </li>
                <li class="nav-main-heading">{{ __('FileManagerLang::general.sidebar.files') }}</li>
                <li class="nav-main-item imageItem">
                    <a class="nav-main-link {{ $type == 'image' ? 'active' : '' }}" href="{{ $imageCount > 0 ? route('dawnstar.filemanager.index', (['type' => 'image'] + $requestParams)) : 'javascript:void(0);' }}">
                        <i class="nav-main-link-icon fa fa-file-image"></i>
                        <span class="nav-main-link-name" style="{{ $imageCount > 0 ? '' : 'text-decoration:line-through' }}">{{ __('FileManagerLang::general.sidebar.image') }}</span>
                        <span class="nav-main-link-badge badge badge-pill badge-secondary">{{ $imageCount }}</span>
                    </a>
                </li>
                <li class="nav-main-item fileItem">
                    <a class="nav-main-link {{ $type == 'file' ? 'active' : '' }}" href="{{ $fileCount > 0 ? route('dawnstar.filemanager.index', (['type' => 'file'] + $requestParams)) : 'javascript:void(0);' }}">
                        <i class="nav-main-link-icon fa fa-file-word"></i>
                        <span class="nav-main-link-name" style="{{ $fileCount > 0 ? '' : 'text-decoration:line-through' }}">{{ __('FileManagerLang::general.sidebar.document') }}</span>
                        <span class="nav-main-link-badge badge badge-pill badge-secondary">{{ $fileCount }}</span>
                    </a>
                </li>
                <li class="nav-main-item videoItem">
                    <a class="nav-main-link {{ $type == 'video' ? 'active' : '' }}" href="{{ $videoCount > 0 ? route('dawnstar.filemanager.index', (['type' => 'video'] + $requestParams)) : 'javascript:void(0);' }}">
                        <i class="nav-main-link-icon fa fa-file-video"></i>
                        <span class="nav-main-link-name" style="{{ $videoCount > 0 ? '' : 'text-decoration:line-through' }}">{{ __('FileManagerLang::general.sidebar.video') }}</span>
                        <span class="nav-main-link-badge badge badge-pill badge-secondary">{{ $videoCount }}</span>
                    </a>
                </li>
                <li class="nav-main-item audioItem">
                    <a class="nav-main-link {{ $type == 'audio' ? 'active' : '' }}" href="{{ $audioCount > 0 ? route('dawnstar.filemanager.index', (['type' => 'audio'] + $requestParams)) : 'javascript:void(0);' }}">
                        <i class="nav-main-link-icon fa fa-file-audio"></i>
                        <span class="nav-main-link-name" style="{{ $audioCount > 0 ? '' : 'text-decoration:line-through' }}">{{ __('FileManagerLang::general.sidebar.audio') }}</span>
                        <span class="nav-main-link-badge badge badge-pill badge-secondary">{{ $audioCount }}</span>
                    </a>
                </li>
                <li class="nav-main-item trashedItem">
                    <a class="nav-main-link {{ $type == 'trash' ? 'active' : '' }}" href="{{ $trashedCount > 0 ? route('dawnstar.filemanager.index', (['type' => 'trash'] + $requestParams)) : 'javascript:void(0)' }}">
                        <i class="nav-main-link-icon fa fa-trash"></i>
                        <span class="nav-main-link-name" style="{{ $trashedCount > 0 ? '' : 'text-decoration:line-through' }}">{{ __('FileManagerLang::general.sidebar.trash') }}</span>
                        <span class="nav-main-link-badge badge badge-pill badge-secondary">{{ $trashedCount }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
