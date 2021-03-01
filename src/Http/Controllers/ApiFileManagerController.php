<?php

namespace Dawnstar\FileManager\Http\Controllers;

use Carbon\Carbon;
use Dawnstar\FileManager\Foundation\MediaUpload;
use Dawnstar\FileManager\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class ApiFileManagerController extends BaseController
{
    public function getMedias(Request $request)
    {
        $type = $request->get('type');
        $folder = $request->get('folder');
        $order = $request->get('order');
        $search = $request->get('search');

        $medias = Media::where('uploaded_place', 'panel');

        if ($type && $type != 'all') {
            if ($type == 'file') {
                $medias = $medias->whereNotIn('mime_class', ['image', 'audio', 'video']);
            } elseif ($type == 'trash') {
                $medias = $medias->onlyTrashed();
            } else {
                $medias = $medias->where('mime_class', $type);
            }
        }

        if ($folder && $folder != '') {
            $medias = $medias->where('path', 'like', "%$folder");
        }

        if ($order == 'a-z') {
            $medias = $medias->orderBy('fullname');
        } elseif ($order == 'z-a') {
            $medias = $medias->orderByDesc('fullname');
        } elseif ($order == 'size-b') {
            $medias = $medias->orderByDesc('size');
        } elseif ($order == 'size-k') {
            $medias = $medias->orderBy('size');
        } elseif ($order == 'date-k') {
            $medias = $medias->orderBy('created_at');
        } else {
            $medias = $medias->orderByDesc('created_at');
        }

        if ($search && $search != '') {
            $medias = $medias->where('fullname', 'like', "%$search%");
        }

        $medias = $medias->paginate(18);

        $return = [];
        foreach ($medias as $media) {
            $return[] = getMediaArray($media);
        }

        return response()->json(['medias' => $return]);
    }

    public function getSelectedMedias(Request $request)
    {
        $ids = $request->get('selectedMediaIds') ? json_decode($request->get('selectedMediaIds'), 1): [];

        $medias = Media::whereIn('id', $ids)->get();

        $return = [];
        foreach ($medias as $media) {
            $return[] = getMediaArray($media);
        }
        return response()->json(['selectedMedias' => $return]);
    }

    public function getMediaFolders()
    {
        $mediaFolders = Media::select('id', 'path')->get()->groupBy('path');

        $return = [];
        foreach ($mediaFolders as $folder => $mediaFolder) {
            $return[] = [
                'name' => ltrim($folder, '/'),
                'count' => $mediaFolder->count(),
            ];
        }
        return response()->json(['folders' => $return]);
    }

    public function deleteMedia(Request $request)
    {
        $mediaId = $request->get('media_id');

        $media = Media::findOrFail($mediaId);

        $media->delete();

        $folder_path = $media->uploaded_place . '/' . $media->path;
        if (!is_dir(storage_path('app/public/media_trash/' . $folder_path))) {
            mkdir(storage_path('app/public/media_trash/' . $folder_path), 0777, true);
        }

        rename(public_path('uploads/' . $media->uploaded_place . '/' . $media->path . '/' . $media->fullname), storage_path('app/public/media_trash/' . $media->uploaded_place . '/' . $media->path . '/' . $media->fullname));


        // TODO: başka yerde yap!!!!
        // Delete deleted files which is deleted before 30 days
        $deletedMedias = Media::onlyTrashed()->where('deleted_at', '<', Carbon::now()->subDays(30)->toDateTimeString())->get();
        foreach ($deletedMedias as $deletedMedia) {
            $deletedMedia->forceDelete();
            @unlink(storage_path('app/public/media_trash/' . $deletedMedia->uploaded_place . '/' . $deletedMedia->path . '/' . $deletedMedia->fullname));
        }
    }

    public function recoverMedia(Request $request)
    {
        $mediaId = $request->get('media_id');

        $media = Media::withTrashed()->findOrFail($mediaId);

        $media->restore();

        rename(storage_path('app/public/media_trash/' . $media->uploaded_place . $media->path . '/' . $media->fullname), public_path('uploads/' . $media->uploaded_place . '/' . $media->path . '/' . $media->fullname));
    }
}
