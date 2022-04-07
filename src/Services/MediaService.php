<?php

namespace Dawnstar\MediaManager\Services;

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
    public bool $default = false;

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
        if($this->default) {
            return $this;
        }

        $path = Storage::disk($this->disk)->path($this->path);

        $newName = $this->name;
        if ($width) {
            $newName .= '_w' . $width;
        }
        if ($height) {
            $newName .= '_h' . $height;
        }
        if ($this->quality != 90) {
            $newName .= '_q' . $this->quality;
        }
        $newName .= '.' . $this->extension;
        $newPath = 'medias/' . $newName;

        if (Storage::disk($this->disk)->exists($newPath)) {
            $media = Media::where('full_name', $newName)->where('type', 3)->first();
        } else {
            $newPath = Storage::disk($this->disk)->path($newPath);

            $image = Image::make($path);

            $image = $image->resize($width, $height, function ($constraint) use($width, $height, $aspectRatio){
                if($aspectRatio && (is_null($width) || is_null($height))) {
                    $constraint->aspectRatio();
                }
            })->save($newPath, $this->quality);

            $media = $this->model->replicate()->fill([
                'uid' => getUniqueId(),
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

        if ($this->webp) {
            return $this->convertWebp();
        }

        return $this;
    }

    public function rotate(int $degree)
    {
        if($this->default) {
            return $this;
        }

        $path = Storage::disk($this->disk)->path($this->path);

        $newName = $this->name . '_r' . $degree . '.' . $this->extension;
        $newPath = 'medias/' . $newName;

        if (Storage::disk($this->disk)->exists($newPath)) {
            $media = Media::where('full_name', $newName)->where('type', 4)->first();
        } else {
            $newPath = Storage::disk($this->disk)->path($newPath);

            $image = Image::make($path);
            $image = $image->rotate($degree)->save($newPath, $this->quality);
            $media = $this->model->replicate()->fill([
                'uid' => getUniqueId(),
                'type' => 4,
                'name' => $image->filename,
                'full_name' => $image->basename,
            ]);
            $media->save();
        }

        $this->model = $media;
        $this->setBasicAttributes();
        $this->setAttributes();


        if ($this->webp) {
            return $this->convertWebp();
        }

        return $this;
    }

    private function init(): void
    {
        $this->setBasicAttributes();
        $this->setAttributes();

        $fullUrl = request()->fullUrl();
        $parsedUrl = parse_url($fullUrl);

        $this->webp = $this->webp && !str($parsedUrl['path'])->startsWith('/dawnstar') && $this->mime_class == 'image' && !$this->default;

        if ($this->webp) {
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
        if ($this->model && Storage::disk($this->disk)->exists($this->path)) {
            $this->url = route('media', $this->model->uid);
            $this->full_name = $this->model->full_name;
            $this->name = $this->model->name;
            $this->extension = $this->model->extension;
            $this->size = ['width' => $this->model->width, 'height' => $this->model->height];
            $this->file_size = $this->model->size;
            $this->mime_class = $this->model->mime_class;
            $this->mime_type = $this->model->mime_type;
            $this->default = false;
        } else {
            $this->url = defaultImage();
            $this->name = 'default';
            $this->full_name = 'default.png';
            $this->mime_class = 'image';
            $this->size = ['width' => 150, 'height' => 150];
            $this->default = true;
        }
    }

    private function convertWebp()
    {
        $path = Storage::disk($this->disk)->path($this->path);
        $image = Image::make($path);

        $newName = $this->name . '.webp';
        $newPath = 'medias/' . $newName;

        if (!Storage::disk($this->disk)->exists($newPath)) {
            $newPath = Storage::disk($this->disk)->path($newPath);
            $image->encode('webp', $this->quality)->save($newPath);
        }

        return $this;
    }

    private function getModel(): ?Media
    {
        return Media::find($this->id);
    }
}
