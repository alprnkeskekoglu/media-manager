<?php

namespace Dawnstar\FileManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    protected $table = 'medias';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded = ['id'];

    public function getUrlAttribute()
    {
        if($this->trashed()) {
            if(file_exists(storage_path('/media_trash/' . $this->uploaded_place . $this->path . '/' . $this->fullname))) {
                return url('/storage/media_trash/' . $this->uploaded_place . $this->path . '/' . $this->fullname);
            }
        }

        if(file_exists(public_path('/uploads/' . $this->uploaded_place . $this->path . '/' . $this->fullname))) {
            return url('/uploads/' . $this->uploaded_place . $this->path . '/' . $this->fullname);
        }
        
        return defaultImage();
    }
}
