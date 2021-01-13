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
                <li class="nav-main-item mb-3">
                    <a class="nav-main-link btn-alt-success" id="createBtn" href="{{ route('dawnstar.filemanager.create') }}">
                        <i class="nav-main-link-icon fa fa-plus"></i>
                        <span class="nav-main-link-name">Upload New</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link active" id="indexBtn" href="{{ route('dawnstar.filemanager.index') }}">
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
