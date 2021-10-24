<?php

function defaultImage()
{
    return 'https://via.placeholder.com/150';
}

function unitSizeForHuman(int $bytes, string $returnType = 'array')
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
        $unit = 'byte';
    } else {
        trigger_error('Bytes must be bigger then 0.', E_USER_ERROR);
    }

    if ($returnType === 'string') {
        return $returnByte . ' ' . $unit;
    }
    return [$returnByte, $unit];
}

function getMediaImage($media): string
{
    $return = asset('assets/medias/default.png');
    if ($media->mime_class == 'image') {
        $return = getImageUrl($media);
    } elseif (in_array($media->mime_class, ['audio', 'video', 'text'])) {
        $return = asset('assets/medias/' . $media->mime_class . '.png');
    } elseif ($media->mime_class == 'application') {
        if ($media->mime_type == 'application/pdf') {
            $return = asset('assets/medias/pdf.png');
        } elseif (in_array($media->extension, ['csv', 'xlsx', 'xls'])) {
            $return = asset('assets/medias/xls.png');
        } elseif (in_array($media->extension, ['doc', 'docx', 'ods'])) {
            $return = asset('assets/medias/doc.png');
        } elseif (in_array($media->extension, ['ppt', 'pptx'])) {
            $return = asset('assets/medias/ppt.png');
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