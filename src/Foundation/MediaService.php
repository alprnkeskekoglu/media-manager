<?php

namespace Dawnstar\MediaManager\Foundation;

use Dawnstar\MediaManager\Models\Folder;
use Dawnstar\MediaManager\Models\Media;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaService
{
    /**
     * @var int|null
     */
    public ?int $id = null;
    /**
     * @var Folder|mixed|null
     */
    public ?Folder $folder;
    /**
     * @var Media|null
     */
    public ?Media $model = null;
    /**
     * @var bool|mixed
     */
    public bool $private;
    /**
     * @var int
     */
    public int $type;
    /**
     * @var string|null
     */
    public ?string $disk = null;
    /**
     * @var string|mixed|null
     */
    public ?string $path = null;
    /**
     * @var string
     */
    public string $url;
    /**
     * @var string|null
     */
    public ?string $full_name = null;
    /**
     * @var string|null
     */
    public ?string $name = null;
    /**
     * @var string|null
     */
    public ?string $extension = null;
    /**
     * @var string|null
     */
    public ?string $mime_class = null;
    /**
     * @var string|null
     */
    public ?string $mime_type = null;
    /**
     * @var array|null
     */
    public ?array $size = null;
    /**
     * @var int|null
     */
    public ?int $file_size = null;

    public bool $webp = false;
    public int $quality = 90;

    /**
     * MediaService constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
        $this->model = $this->getModel();

        $this->webp = setting('webp_status', false);
        $this->quality = setting('quality', 90);

        $this->init();
    }

    public function __toString(): string
    {
        return $this->url;
    }

    public function resize(int $width = null, int $height = null, bool $aspectRatio = true)
    {
        $path = Storage::disk($this->disk)->path($this->path);
        $image = Image::make($path);

        $newName = $this->name;
        if($width) {
            $newName .= '_w' . $width;
        }
        if($height) {
            $newName .= '_h' . $height;
        }
        $newName .= '.' . $this->extension;
        $newPath = 'medias/' . $newName;

        if(Storage::disk($this->disk)->exists($newPath)) {
            $media = Media::where('full_name', $newName)->where('type', 3)->first();
        } else {
            $newPath = Storage::disk($this->disk)->path($newPath);

            $image = $image->resize($width, $height, function ($constraint) use($width, $height, $aspectRatio){
                if($aspectRatio && (is_null($width) || is_null($height))) {
                    $constraint->aspectRatio();
                }
            })->save($newPath, $this->quality);

            $media = $this->model->replicate()->fill([
                'uid' => $this->getUniqueId(),
                'type' => 3,
                'name' => $image->filename,
                'full_name' => $image->basename,
                'width' => $image->width(),
                'height' => $image->height(),
                'size' => $image->filesize()
            ]);
            $media->save();
        }

        $this->model = $media;
        $this->setBasicAttributes();
        $this->setAttributes();

        return $this;
    }

    public function rotate(int $degree)
    {
        $path = Storage::disk($this->disk)->path($this->path);
        $image = Image::make($path);

        $newName = $this->name . '_r' . $degree . '.' . $this->extension;
        $newPath = 'medias/' . $newName;

        if(Storage::disk($this->disk)->exists($newPath)) {
            $media = Media::where('full_name', $newName)->where('type', 4)->first();
        } else {
            $newPath = Storage::disk($this->disk)->path($newPath);
            $image = $image->rotate($degree)->save($newPath, $this->quality);
            $media = $this->model->replicate()->fill([
                'uid' => $this->getUniqueId(),
                'type' => 4,
                'name' => $image->filename,
                'full_name' => $image->basename,
            ]);
            $media->save();
        }

        $this->model = $media;
        $this->setBasicAttributes();
        $this->setAttributes();

        return $this;
    }

    private function init(): void
    {
        $this->setBasicAttributes();
        $this->setAttributes();

        if($this->webp && $this->mime_class == 'image') {
            $this->convertWebp();
        }
    }

    private function setBasicAttributes()
    {
        if($this->model) {
            $this->id = $this->model->id;
            $this->type = $this->model->type;
            $this->folder = $this->model->folder;
            $this->private = $this->model->private;
            $this->disk = $this->private ? 'private' : 'public';
            $this->path = $this->model->path;
        }
    }

    private function setAttributes()
    {
        if($this->model && Storage::disk($this->disk)->exists($this->path)) {
            $this->url = route('media', $this->model->uid);
            $this->full_name = $this->model->full_name;
            $this->name = $this->model->name;
            $this->extension = $this->model->extension;
            $this->size = ['width' => $this->model->width, 'height' => $this->model->height];
            $this->file_size = $this->model->size;
            $this->mime_class = $this->model->mime_class;
            $this->mime_type = $this->model->mime_type;
        } else {
            $this->url = defaultImage();
            $this->mime_class = 'image';
            $this->size = ['width' => 150, 'height' => 150];
        }
    }

    private function convertWebp()
    {
        $path = Storage::disk($this->disk)->path($this->path);
        $image = Image::make($path);

        $newName = $this->name . '.webp';
        $newPath = 'medias/' . $newName;


        if (Storage::disk($this->disk)->exists($newPath)) {
            $media = Media::where('full_name', $newName)->where('type', 2)->first();
        } else {
            $newPath = Storage::disk($this->disk)->path($newPath);
            $image = $image->encode('webp', $this->quality)->save($newPath);
            $media = $this->model->replicate()->fill([
                'uid' => $this->getUniqueId(),
                'type' => 2,
                'name' => $image->filename,
                'full_name' => $image->basename,
                'extension' => 'webp',
                'size' => $image->filesize()
            ]);
            $media->save();
        }

        $this->model = $media;
        $this->setBasicAttributes();
        $this->setAttributes();

        return $this;
    }

    private function getModel(): ?Media
    {
        return Media::find($this->id);
    }

    private function getUniqueId(): string
    {
        return substr(md5(uniqid(mt_rand(), true)), 0, 20);
    }
}
