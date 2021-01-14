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
