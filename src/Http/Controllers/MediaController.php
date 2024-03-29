<?php

namespace Dawnstar\MediaManager\Http\Controllers;

use Dawnstar\MediaManager\Services\MediaUploadService;
use Dawnstar\MediaManager\Models\Media;
use Dawnstar\MediaManager\Models\ModelMedia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function media(string $uid)
    {
        $media = Media::where('uid', $uid)->first();

        if (is_null($media)) {
            return defaultImage();
        }

        $disk = $media->private ? 'private' : 'public';

        $mediaPath = Storage::disk($disk)->path($media->path);

        if (setting('webp_status', false) && $media->mime_class == 'image') {

            $path = str_replace('.' . $media->extension, '.webp', $media->path);

            if (Storage::disk($disk)->exists($path)) {
                $mediaPath = Storage::disk($disk)->path($path);
            }
        }

        return response()->file($mediaPath);
    }

    public function index(Request $request)
    {
        $private = $request->get('private') == 'true';
        $trashed = $request->get('trashed') == 'true';
        $folder_id = $request->get('folder');
        $mime_class = $request->get('type');
        $search = $request->get('search');
        $order = $request->get('order');


        $medias = Media::where('private', $private)->where('type', 1);

        if($trashed) {
            $medias = $medias->where('folder_id', null)->onlyTrashed();
        }

        if($folder_id) {
            $medias = $medias->where('folder_id', $folder_id);
        }

        if($mime_class) {
            if($mime_class == 'file') {
                $medias = $medias->whereNotIn('mime_class', ['image', 'audio', 'video']);
            } else {
                $medias = $medias->where('mime_class', $mime_class);
            }
        }

        if($search) {
            $medias = $medias->where('full_name', 'like', "%$search%");
        }

        switch ($order) {
            case 'name_asc':
                $medias = $medias->orderBy('full_name');
                break;
            case 'name_desc':
                $medias = $medias->orderByDesc('full_name');
                break;
            case 'size_asc':
                $medias = $medias->orderBy('size');
                break;
            case 'size_desc':
                $medias = $medias->orderByDesc('size');
                break;
            case 'uploaded_asc':
                $medias = $medias->orderBy('created_at');
                break;
            default:
                $medias = $medias->orderByDesc('created_at');
        }

        $medias = $medias->paginate(12);

        $newMediaData = $this->getMediaData($medias->getCollection());
        $medias->setCollection(collect($newMediaData));

        return response()->json(['medias' => $medias]);
    }

    public function store(Request $request)
    {
        $private = $request->get('private') == 'true';
        $folder_id = $request->get('folder_id');
        $url = $request->get('url');
        $medias = $request->allFiles();

        $mediaUpload = new MediaUploadService($private, $folder_id);
        try {
            if (count($medias)) {
                foreach ($medias as $media) {
                    $mediaUpload->fromComputer($media);
                }
            } else {
                $mediaUpload->fromUrl($url);
            }
        } catch (\Throwable $exception) {
            throw new \Exception(__('media.error.store'));
        }

        return response()->json(['message' => __('MediaManager::media.success.store')]);
    }

    public function destroy(Media $media)
    {
        $disk = $media->private ? 'private' : 'public';
        Storage::disk($disk . '_trash')->put($media->full_name, Storage::disk($disk)->get($media->path));
        Storage::disk($disk)->delete($media->path);

        $media->update(['folder_id' => null]);
        $media->delete();

        return response()->json(['message' => __('MediaManager::media.success.destroy')]);
    }

    public function getSelected(Request $request)
    {
        $ids = explode(',', $request->get('ids', ''));
        $medias = Media::whereIn('id', $ids)->get();
        $medias = $this->getMediaData($medias);

        return response()->json(['medias' => $medias]);
    }

    public function recover(Request $request)
    {
        $id = $request->get('id');

        $media = Media::onlyTrashed()->findOrFail($id);

        $disk = $media->private ? 'private' : 'public';

        Storage::disk($disk)->put($media->path, Storage::disk($disk . '_trash')->get($media->full_name));
        Storage::disk($disk . '_trash')->delete($media->full_name);

        $media->restore();
        return response()->json(['message' => __('MediaManager::media.success.recover')]);
    }

    public function forceDelete(Request $request)
    {
        $id = $request->get('id');

        $media = Media::onlyTrashed()->findOrFail($id);

        $disk = $media->private ? 'private_trash' : 'public_trash';
        Storage::disk($disk)->delete($media->full_name);
        $media->forceDelete();

        return response()->json(['message' => __('MediaManager::media.success.force_delete')]);
    }

    # region helpers
    private function getMediaData($medias)
    {
        $mediaData = [];
        foreach ($medias as $media) {
            $mediaData[] = [
                'id' => $media->id,
                'name' => Str::limit($media->full_name, 12),
                'full_name' => $media->full_name,
                'mime_class' => $media->mime_class,
                'mime_type' => $media->mime_type,
                'image' => getMediaImage($media),
                'url' => $media->url,
                'size' => unitSizeForHuman($media->size),
                'in_use' => ModelMedia::where('media_id', $media->id)->exists()
            ];
        }
        return $mediaData;
    }
    #endregion
}
