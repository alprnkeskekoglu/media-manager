<?php

namespace Dawnstar\MediaManager\Foundation;

use Dawnstar\MediaManager\Models\Folder;
use Dawnstar\MediaManager\Models\Media;
use Illuminate\Support\Facades\Storage;

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

    /**
     * MediaService constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
        $this->model = $this->getModel();
        if($this->model) {
            $this->folder = $this->model->folder;
            $this->private = $this->model->private;
            $this->disk = $this->private ? 'private' : 'public';
            $this->path = $this->model->path;
        }

        if($this->path && Storage::disk($this->disk)->exists($this->path)) {
            $this->init();
        } else {
            $this->defaultInit();
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->url;
    }

    private function init(): void
    {
        $this->url = route('media', $this->model->uid);
        $this->full_name = $this->model->full_name;
        $this->name = $this->model->name;
        $this->extension = $this->model->extension;
        $this->size = ['width' => $this->model->width, 'height' => $this->model->height];
        $this->file_size = $this->model->size;
        $this->mime_class = $this->model->mime_class;
        $this->mime_type = $this->model->mime_type;
    }

    private function defaultInit()
    {
        $this->url = defaultImage();
        $this->mime_class = 'image';
        $this->size = ['width' => 150, 'height' => 150];
    }

    /**
     * @return Media|null
     */
    private function getModel(): ?Media
    {
        return Media::find($this->id);
    }
}
