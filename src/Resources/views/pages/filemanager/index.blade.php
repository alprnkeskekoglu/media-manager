@extends('FileManagerView::layouts.app')

@section('content')
    <div id="fileManager">
        <filemanager-library></filemanager-library>
    </div>
@endsection

@push('scripts')
    <script>
        window.type = '{{ $type }}'
        window.maxMediaCount = '{{ $maxMediaCount }}'
        window.selectableType = '{{ $selectableType }}'
        window.selectedMediaIds = @json($selectedMediaIds)

        window.getMediaRoute = '{{ route('dawnstar.filemanager.api.getMedias') }}'
        window.getSelectedMediaRoute = '{{ route('dawnstar.filemanager.api.getSelectedMedias') }}'
        window.getMediaFolderRoute = '{{ route('dawnstar.filemanager.api.getMediaFolders') }}'
        window.deleteMediaRoute = '{{ route('dawnstar.filemanager.api.deleteMedia') }}'
        window.recoverMediaRoute = '{{ route('dawnstar.filemanager.api.recoverMedia') }}'

        window.trans = @json($trans)
    </script>

    <script src="{{ fileManagerAsset('js/index-vue.js?v=1') }}"></script>
@endpush
