<?php

namespace Dawnstar\MediaManager\Models;

use Illuminate\Database\Eloquent\Model;

class ModelMedia extends Model
{
    protected $table = 'model_medias';
    protected $fillable = ['model_type', 'model_id', 'media_id', 'key', 'order'];
}
