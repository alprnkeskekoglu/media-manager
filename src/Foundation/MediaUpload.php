<?php

namespace Dawnstar\FileManager\Foundation;

use Dawnstar\FileManager\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Dotenv\Exception\InvalidFileException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class MediaUpload
{
    public $mimeTypes = [
        'image/bmp',
        'image/gif',
        'image/jpeg',
        'image/png',
        'image/svg+xml',
        'image/svg',
        'image/tiff',
        'image/x-icon',
        'audio/mpeg',
        'audio/x-wav',
        'audio/mid',
        'audio/basic',
        'video/mpeg',
        'video/mp4',
        'video/x-msvideo',
        'application/pdf',
        'application/json',
        'text/plain',
        'application/docx',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/excel',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ];

    public function fromComputer(Request $request)
    {
        $files = $request->file('files');
        if(!is_array($files)) {
            $files = [$files];
        }

        if(count($files) == 0) {
            throw new FileNotFoundException('Herhangi bir dosya gönderilmedi.');
        }

        foreach ($files as $file) {
            $path = '/' . date('Y') . '/' . date('m');
            $mimeType = $file->getClientMimeType();

            if(! in_array($mimeType, $this->mimeTypes)) {
                throw new InvalidFileException('Dosya tipi uygun değildir.');
            }

            $tempFilePath = Storage::disk('public')->put('/temp', $file);
            $tempFile = storage_path('app/public/' . $tempFilePath);
            $imageSizes = getimagesize($tempFile);

            $fullname = $file->getClientOriginalName(); // TODO check for unique name
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.' . $extension, '', $fullname);
            $data = [
                'type' => 'original',
                'fullname' => $fullname,
                'upload_name' => $fileName,
                'file_name' => $fileName,
                'extension' => $extension,
                'path' => 'uploads/panel' . $path,
                'mime_class' => strstr($mimeType, '/', true),
                'mime_type' => $mimeType,
                'width' => $imageSizes[0] ?? null,
                'height' => $imageSizes[1] ?? null,
                'size' => $file->getSize()
            ];

            Storage::disk('dawnstar_panel')->putFileAs($path, $file, $fullname);
            Media::firstOrCreate($data);
            @unlink($tempFile);
        }

    }
}
