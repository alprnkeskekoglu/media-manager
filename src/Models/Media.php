<?php

namespace Dawnstar\MediaManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    /* Type
     * 1 -> Original
     * 2 -> Webp
     * 3 -> Resize
     * 4 -> Rotate
     */

    use SoftDeletes;

    protected $table = 'medias';
    protected $guarded = ['id'];
    protected $appends = ['url', 'path'];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function getPathAttribute()
    {
        return 'medias/' . ($this->folder ? ($this->folder->name . '/') : '') . $this->full_name;
    }

    public function getUrlAttribute()
    {
        return route('media', $this->uid);
    }

    public function __toString()
    {
        return $this->getUrlAttribute();
    }
}
