<?php

use Illuminate\Support\Facades\Storage;

function defaultImage()
{
    return 'https://via.placeholder.com/150';
}

function unitSizeForHuman(int $bytes)
{
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
        $unit = 'byte';
    }

    return $returnByte . ' ' . $unit;
}

function getMediaImage($media): string
{
    $return = asset('vendor/media-manager/assets/medias/default.png');
    if ($media->mime_class == 'image') {
        $return = getImageUrl($media);
    } elseif (in_array($media->mime_class, ['audio', 'video', 'text'])) {
        $return = asset('vendor/media-manager/assets/medias/' . $media->mime_class . '.png');
    } elseif ($media->mime_class == 'application') {
        if ($media->mime_type == 'application/pdf') {
            $return = asset('vendor/media-manager/assets/medias/pdf.png');
        } elseif (in_array($media->extension, ['csv', 'xlsx', 'xls'])) {
            $return = asset('vendor/media-manager/assets/medias/xls.png');
        } elseif (in_array($media->extension, ['doc', 'docx', 'ods'])) {
            $return = asset('vendor/media-manager/assets/medias/doc.png');
        } elseif (in_array($media->extension, ['ppt', 'pptx'])) {
            $return = asset('vendor/media-manager/assets/medias/ppt.png');
        }
    }
    return $return;
}

function getImageUrl($media)
{
    if ($media->deleted_at) {
        $disk = ($media->private ? 'private' : 'public') . '_trash';
        return 'data:' . $media->mime_type . ';base64, ' . base64_encode(Storage::disk($disk)->get($media->full_name));
    }
    return $media->url;
}
