<?php

namespace Dawnstar\MediaManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use SoftDeletes;

    protected $table = 'folders';
    protected $guarded = ['id'];

    public function medias()
    {
        return $this->hasMany(Media::class);
    }
}
