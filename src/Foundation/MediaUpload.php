<?php

namespace Dawnstar\FileManager\Foundation;

use Dawnstar\FileManager\Models\Media;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Dotenv\Exception\InvalidFileException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class MediaUpload
{
    public $folder;
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
        'application/wps-office.xlsx'
    ];

    public function __construct()
    {
        $this->folder = '/' . date('Y') . '/' . date('m');
    }

    public function fromComputer(Request $request)
    {
        $files = $request->file('files');
        if(!is_array($files)) {
            $files = [$files];
        }

        if(count($files) == 0) {
            throw new FileNotFoundException(__('FileManagerLang::upload.errors.no_file'));
        }

        $medias = [];
        foreach ($files as $key => $file) {
            $mimeType = $file->getClientMimeType();

            if(! in_array($mimeType, $this->mimeTypes)) {
                throw new InvalidFileException(__('FileManagerLang::upload.errors.mime_type'));
            }

            $tempFilePath = Storage::disk('local')->put('/media_temp', $file);
            $tempFile = storage_path('app/' . $tempFilePath);

            $medias[$key] = $this->saveFile($file, $tempFile);
        }

        return $medias;
    }

    public function fromUrl(string $url)
    {
        $url = strip_tags($url);
        $info = pathinfo($url);
        $queryString = strpos($info['basename'], "?");
        $filename = $queryString != false ? substr($info['basename'], 0, strpos($info['basename'], "?")) : $info['basename'];
        parse_str($info['extension'], $output);

        $mimeType = get_headers($url, 1)['Content-Type'] ?? null;

        if(! in_array($mimeType, $this->mimeTypes)) {
            throw new InvalidFileException(__('FileManagerLang::upload.errors.mime_type'));
        }

        $content = file_get_contents($url);
        Storage::disk('local')->put('/media_temp/'. $filename, $content);
        $tempFile = storage_path('app/' . '/media_temp/'. $filename);

        $file = new UploadedFile($tempFile, $filename, $mimeType);

        return $this->saveFile($file, $tempFile);
    }

    private function saveFile($file, $tempFile)
    {
        $mimeType = $file->getClientMimeType();
        $extension = $file->getClientOriginalExtension();
        $fullname = $this->getMediaName($file);
        $fileName = str_replace('.' . $extension, '', $fullname);

        $imageSizes = getimagesize($tempFile);

        $data = [
            'type' => 'original',
            'fullname' => $fullname,
            'upload_name' => $fileName,
            'file_name' => $fileName,
            'extension' => $extension,
            'uploaded_place' => 'panel',
            'path' => $this->folder,
            'mime_class' => strstr($mimeType, '/', true),
            'mime_type' => $mimeType,
            'width' => $imageSizes[0] ?? null,
            'height' => $imageSizes[1] ?? null,
            'size' => $file->getSize()
        ];

        Storage::disk('dawnstar_panel')->putFileAs($this->folder, $file, $fullname);
        @unlink($tempFile);
        return Media::firstOrCreate($data);
    }

    private function getMediaName($file)
    {
        $fullname = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = str_replace('.' . $extension, '', $fullname);

        return $this->getUniqueName($fileName, $extension);
    }

    private function getUniqueName($name, $extension, $counter = 0)
    {
        $tempName = $name . '.' . $extension;
        if($counter > 0) {
            $tempName = $name . '-' . $counter . '.' . $extension;
        }
        $mediaExist = Media::withTrashed()->where('fullname', $tempName)->exists();

        if ($mediaExist) {
            return $this->getUniqueName($name, $extension, ++$counter);
        }
        return $tempName;
    }
}
