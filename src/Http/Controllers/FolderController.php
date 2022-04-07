<?php

namespace Dawnstar\MediaManager\Http\Controllers;

use Dawnstar\MediaManager\Http\Requests\FolderRequest;
use Dawnstar\MediaManager\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class FolderController extends Controller
{
    public function index(Request $request)
    {
        $private = $request->get('private') == 'true';
        $trashed = $request->get('trashed') == 'true';

        $folders = Folder::where('private', $private);

        if ($trashed) {
            $folders = $folders->onlyTrashed()
                ->withCount(['medias' => function ($q) {
                    $q->onlyTrashed();
                }]);
        } else {
            $folders = $folders->withCount('medias');
        }

        $folders = $folders->get();

        return response()->json(['folders' => $folders]);
    }

    public function store(FolderRequest $request)
    {
        $data = $request->validated();
        $data['name'] = slugify($data['name']);

        Folder::create($data);

        return response()->json(['message' => __('MediaManager::folder.success.store')]);
    }

    public function destroy(Folder $folder)
    {
        $disk = $folder->private ? 'private' : 'public';

        $medias = $folder->medias;

        foreach ($medias as $media) {
            $path = $folder->name . '/' . $media->full_name;
            Storage::disk($disk . '_trash')->put($path, Storage::disk($disk)->get($media->path));
            Storage::disk($disk)->delete($media->path);

            $media->delete();
        }

        Storage::disk($disk)->deleteDirectory('medias/' . $folder->name);

        $folder->delete();

        return response()->json(['message' => __('MediaManager::folder.success.destroy')]);
    }

    public function recover(Request $request)
    {
        $id = $request->get('id');

        $folder = Folder::onlyTrashed()->findOrFail($id);
        $medias = $folder->medias()->onlyTrashed()->get();

        $disk = $folder->private ? 'private' : 'public';

        $folder->restore();

        foreach ($medias as $media) {
            $path = $folder->name . '/' . $media->full_name;

            Storage::disk($disk)->put($media->path, Storage::disk($disk . '_trash')->get($path));
            Storage::disk($disk . '_trash')->delete($path);

            $media->restore();
        }

        Storage::disk($disk . '_trash')->deleteDirectory($folder->name);


        return response()->json(['message' => __('MediaManager::folder.success.recover')]);
    }

    public function forceDelete(Request $request)
    {
        $id = $request->get('id');

        $folder = Folder::onlyTrashed()->findOrFail($id);

        $medias = $folder->medias;

        $disk = $folder->private ? 'private_trash' : 'public_trash';

        foreach ($medias as $media) {
            $path = $folder->name . '/' . $media->full_name;
            Storage::disk($disk)->delete($path);
            $media->forceDelete();
        }

        Storage::disk($disk)->deleteDirectory($folder->name);

        $folder->forceDelete();
        return response()->json(['message' => __('MediaManager::folder.success.force_delete')]);
    }
}
