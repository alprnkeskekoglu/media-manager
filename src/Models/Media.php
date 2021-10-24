<?php

namespace Dawnstar\MediaManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
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
}
