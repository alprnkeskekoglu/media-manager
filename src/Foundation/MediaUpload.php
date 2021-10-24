<?php

namespace Dawnstar\MediaManager\Foundation;

use Dawnstar\MediaManager\Models\Folder;
use Dawnstar\MediaManager\Models\Media;
use Illuminate\Support\Facades\Storage;
use Dotenv\Exception\InvalidFileException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class MediaUpload
{
    /**
     * @var bool
     */
    public bool $private;
    /**
     * @var Folder|null
     */
    public ?Folder $folder;
    /**
     * @var string|null
     */
    public ?string $uploadStorage;
    /**
     * @var string[]
     */
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

    /**
     * MediaUpload constructor.
     * @param bool $private
     * @param int|null $folder_id
     */
    public function __construct(bool $private = false, int $folder_id = null)
    {
        $this->private = $private;
        $this->folder = Folder::where('private', $this->private)->find($folder_id);
        $this->uploadStorage = $private ? 'private' : 'public';
    }

    /**
     * @param UploadedFile $media
     * @return Media
     */
    public function fromComputer(UploadedFile $media): Media
    {
        $mimeType = $media->getClientMimeType();

        if (!in_array($mimeType, $this->mimeTypes)) {
            throw new InvalidFileException(__('error_messages.media.invalid_file'));
        }

        $tempFilePath = Storage::disk('local')->put('/media_temp', $media);
        $tempFile = storage_path('app/' . $tempFilePath);

        return $this->saveFile($media, $tempFile);
    }

    /**
     * @param string $url
     * @return Media
     */
    public function fromUrl(string $url): Media
    {
        $url = strip_tags($url);
        $info = pathinfo($url);
        $queryString = strpos($info['basename'], "?");
        $filename = $queryString != false ? substr($info['basename'], 0, strpos($info['basename'], "?")) : $info['basename'];
        parse_str($info['extension'], $output);

        $mimeType = get_headers($url, 1)['Content-Type'] ?? null;

        if (!in_array($mimeType, $this->mimeTypes)) {
            throw new InvalidFileException(__('error_messages.media.invalid_file'));
        }

        $content = file_get_contents($url);
        Storage::disk('local')->put('/media_temp/' . $filename, $content);
        $tempFile = storage_path('app/' . '/media_temp/' . $filename);

        $file = new UploadedFile($tempFile, $filename, $mimeType);

        return $this->saveFile($file, $tempFile);
    }

    /**
     * @param $file
     * @param $tempFile
     * @return Media
     */
    private function saveFile($file, $tempFile): Media
    {
        $mimeType = $file->getClientMimeType();
        $extension = $this->getMediaExtension($file);
        $full_name = $this->getMediaName($file, $extension);
        $fileName = str_replace('.' . $extension, '', $full_name);

        if($extension == "") {
            $extension = File::guessExtension($file);
            $full_name .= '.' . $extension;
        }

        $imageSizes = getimagesize($tempFile);

        $data = [
            'folder_id' => $this->folder ? $this->folder->id : null,
            'uid' => $this->getUniqueId(),
            'private' => $this->private,
            'name' => $fileName,
            'extension' => $extension,
            'full_name' => $full_name,
            'mime_class' => strstr($mimeType, '/', true),
            'mime_type' => $mimeType,
            'size' => $file->getSize(),
            'width' => $imageSizes[0] ?? null,
            'height' => $imageSizes[1] ?? null,
        ];

        $uploadPath = 'medias/' . ($this->folder ? ($this->folder->name . '/') : '');

        Storage::disk($this->uploadStorage)->putFileAs($uploadPath, $file, $full_name);
        @unlink($tempFile);
        return Media::firstOrCreate($data);
    }

    /**
     * @param $file
     * @param string $extension
     * @return string
     */
    private function getMediaName($file, string $extension): string
    {
        $full_name = $file->getClientOriginalName();
        $fileName = str_replace('.' . $extension, '', $full_name);

        return $this->getUniqueName($fileName, $extension);
    }

    /**
     * @param $file
     * @return string
     */
    private function getMediaExtension($file): string
    {
        $extension = $file->getClientOriginalExtension();
        if($extension) {
            return $extension;
        }
        return File::guessExtension($file);
    }

    /**
     * @param $name
     * @param $extension
     * @param int $counter
     * @return string
     */
    private function getUniqueName($name, $extension, $counter = 0): string
    {
        $tempName = $name . '.' . $extension;
        if ($counter > 0) {
            $tempName = $name . '-' . $counter . '.' . $extension;
        }
        $mediaExist = Media::withTrashed()->where('full_name', $tempName)->exists();

        if ($mediaExist) {
            return $this->getUniqueName($name, $extension, ++$counter);
        }
        return $tempName;
    }

    /**
     * @return string
     */
    public function getUniqueId(): string
    {
        return substr(md5(uniqid(mt_rand(), true)), 0, 20);
    }
}
