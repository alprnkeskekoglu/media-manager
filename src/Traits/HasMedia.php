<?php

namespace Dawnstar\MediaManager\Traits;

use Dawnstar\MediaManager\Models\Media;

trait HasMedia
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function medias()
    {
        return $this->morphToMany(Media::class, 'model', 'model_medias');
    }

    /**
     * @param array $medias
     */
    public function syncMedias(array $medias): void
    {
        foreach ($medias as $key => $media_ids) {
            $save = [];
            if($media_ids) {
                $media_ids = explode(',', $media_ids);
                foreach ($media_ids as $media_id) {
                    $save[$media_id] = ['key' => $key];
                }
            }
            $this->medias()->sync($save);
        }
    }
}
