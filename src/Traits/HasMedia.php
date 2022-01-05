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

    /**
     * @param $key
     * @return \Illuminate\Database\Eloquent\Collection|mixed|null
     */
    public function __get($key) {
        $attribute = $this->getAttribute($key);
        if ($attribute) {
            return $attribute;
        }
        dump($this);

        if(\Str::startsWith($key, 'mf_')) {
            $key = mb_substr($key, 3);
            $medias = $this->medias();
            if($key) {
                $medias->wherePivot('key', $key);
            }
            return $medias->orderBy('model_medias.order')->first();
        } elseif(\Str::startsWith($key, 'mc_')) {
            $key = mb_substr($key, 3);
            $medias = $this->medias();
            if($key) {
                $medias->wherePivot('key', $key);
            }
            return $medias->orderBy('model_medias.order')->get();
        }
    }
}
