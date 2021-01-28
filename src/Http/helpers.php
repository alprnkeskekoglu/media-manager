<?php


function fileManagerAsset($path)
{
    return asset('vendor/filemanager/assets/' . $path);
}

function defaultImage() {
    return 'https://via.placeholder.com/150';
}

function media(int $id, int $width = null, int $height = null) {
    $mediaFoundation = new \Dawnstar\FileManager\Foundation\Media();
    $media = $mediaFoundation
        ->setId($id);

    if($width) {
        $media = $media->setResizeWidth($width);
    }

    if($height) {
        $media = $media->setResizeHeight($height);
    }

    return $media->getMedia();
}

function getMediaArray($media)
{
    $mimeClass = $media->mime_class;
    if($mimeClass == 'image') {
        $html = '<img class="img-fluid rounded" style="max-height: 120px" src="' . $media->url . '">';
        $selectedHtml = '<img class="img-fluid rounded" style="max-height: 80px" src="' . $media->url . '">';
    } elseif ($mimeClass == 'video') {
        $html = '<i class="fa fa-fw fa-5x fa-file-video text-default"></i>';
        $selectedHtml = '<i class="fa fa-fw fa-4x fa-file-video text-default"></i>';
    } elseif($mimeClass == 'audio') {
        $html = '<i class="fa fa-fw fa-5x fa-file-audio text-primary"></i>';
        $selectedHtml = '<i class="fa fa-fw fa-4x fa-file-audio text-primary"></i>';
    } elseif($mimeClass == 'text') {
        $html = '<i class="fa fa-fw fa-5x fa-file-alt text-black"></i>';
        $selectedHtml = '<i class="fa fa-fw fa-4x fa-file-alt text-black"></i>';
    } elseif($mimeClass == 'application') {
        if(in_array($media->extension, ['csv', 'xlsx', 'xls'])) {
            $html = '<i class="fa fa-fw fa-5x fa-file-excel text-success"></i>';
            $selectedHtml = '<i class="fa fa-fw fa-4x fa-file-excel text-success"></i>';
        } elseif($media->mime_type == 'application/pdf') {
            $html = '<i class="fa fa-fw fa-5x fa-file-pdf text-danger"></i>';
            $selectedHtml = '<i class="fa fa-fw fa-4x fa-file-pdf text-danger"></i>';
        }
    } else {
        $html = '<i class="fa fa-fw fa-5x fa-file text-gray-dark"></i>';
        $selectedHtml = '<i class="fa fa-fw fa-4x fa-file text-gray-dark"></i>';
    }

    return [
        'id' => $media->id,
        'fullname' => $media->fullname,
        'html' => $html,
        'selected_html' => $selectedHtml,
        'size' => unitSizeForHuman($media->size),
        'is_trashed' => $media->trashed(),
        'url' => $media->url,
        'type' => (in_array($media->mime_class, ['image', 'video', 'audio']) ? $media->mime_class : 'file')
    ];
}

function unitSizeForHuman(int $bytes): string
{
    $returnByte = $bytes;
    if ($bytes >= 1073741824) {
        $returnByte = number_format($bytes / 1073741824, 2);
        $unit = 'GB';
    } elseif ($bytes >= 1048576) {
        $returnByte = number_format($bytes / 1048576, 2);
        $unit = 'MB';
    } elseif ($bytes >= 1024) {
        $returnByte = number_format($bytes / 1024, 2);
        $unit = 'KB';
    } elseif ($bytes >= 0) {
        $returnByte = $bytes;
        $unit = 'B';
    } else {
        trigger_error('Bytes must be bigger then 0.', E_USER_ERROR);
    }

    return $returnByte . ' ' . $unit;
}
