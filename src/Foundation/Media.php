<?php

namespace Dawnstar\FileManager\Foundation;

use \Dawnstar\FileManager\Models\Media as Model;
use Intervention\Image\Facades\Image;

class Media
{
    public int $id;
    public bool $isDeleted;
    public string $fullname;
    public string $filename;
    public string $extension;
    public string $basePath;
    public string $path;
    public string $url;
    public $model;

    private ?int $resizeWidth = null;
    private ?int $resizeHeight = null;

    public function __construct()
    {
    }

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function setResizeWidth(int $resizeWidth)
    {
        $this->resizeWidth = $resizeWidth;
        return $this;
    }

    public function setResizeHeight(int $resizeHeight)
    {
        $this->resizeHeight = $resizeHeight;
        return $this;
    }

    public function getMedia()
    {
        if ($this->id) {
            $this->model = Model::withTrashed()->find($this->id);
        } else {
            return defaultImage();
        }

        if (is_null($this->model)) {
            return defaultImage();
        }

        $this->isDeleted = $this->model->trashed();
        $this->setBasePath();
        $this->setAttributes();

        if ($this->isDeleted == false && $this->model->mime_class == 'image' && ($this->resizeWidth || $this->resizeHeight)) {
            $this->setResizedImage();
        }

        if ($this->getWebpStatus()) {
            $this->setWebpImage();
        }

        return $this;
    }

    # region Resize
    private function setResizedImage()
    {
        $pathInfo = pathinfo($this->basePath);

        $newFileName = $pathInfo['filename'];
        if ($this->resizeWidth) {
            $newFileName .= '_w' . $this->resizeWidth;
        }
        if ($this->resizeHeight) {
            $newFileName .= '_h' . $this->resizeHeight;
        }
        $newPath = $pathInfo['dirname'] . '/' . $newFileName . '.' . $pathInfo['extension'];


        if (!file_exists(public_path($newPath))) {
            $image = \Intervention\Image\Facades\Image::make($this->path);

            $image = $image->resize($this->resizeWidth, $this->resizeHeight, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save(public_path($newPath));
        }

        $this->basePath = $newPath;
        $this->setAttributes();
    }
    # endregion

    # region Webp
    private function setWebpImage()
    {
        $pathInfo = pathinfo($this->basePath);
        $newPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';

        if (!file_exists(public_path($newPath))) {
            $image = Image::make($this->path);
            $image = $image->encode('webp', 85);
            $image->save(public_path($newPath));
        }

        $this->basePath = $newPath;
        $this->setAttributes();
    }

    private function getWebpStatus()
    {
        $browser = $this->getBrowser();

        if ($browser == 'Safari') {
            return false;
        }

        if (!in_array($this->extension, ['jpg', 'png', 'jpeg'])) {
            return false;
        }

        if(strpos(request()->getPathInfo(), '/api/v') > -1) {
            return false;
        }

        return config('dawnstar.webp_status', true) && $this->isDeleted == false && $this->model->mime_class == 'image' && session('dawnstar.isPanel') == false;
    }

    private function getBrowser()
    {
        $browserArray = ["Opera", "Edge", "Chrome", "Safari", "Firefox", "MSIE", "Trident"];

        $agent = $_SERVER['HTTP_USER_AGENT'] ?? "";

        foreach ($browserArray as $browser) {
            if (strpos($agent, $browser) !== false) {
                return $browser;
            }
        }
    }

    # endregion

    private function setBasePath()
    {
        if ($this->isDeleted) {
            $this->basePath = '/storage/media_trash/' . $this->model->uploaded_place . $this->model->path . '/' . $this->model->fullname;
        } else {
            $this->basePath = '/uploads/' . $this->model->uploaded_place . $this->model->path . '/' . $this->model->fullname;
        }
    }

    private function setAttributes()
    {
        $this->fullname = $this->model->fullname;
        $this->filename = $this->model->file_name;
        $this->extension = $this->model->extension;


        $this->path = public_path($this->basePath);
        $this->url = url($this->basePath);
        if ($this->model->mime_class == 'image') {
            $this->size = $this->model->size;
            $this->width = $this->model->width;
            $this->height = $this->model->height;
        }
    }

    public function __toString()
    {
        return $this->url;
    }
}
