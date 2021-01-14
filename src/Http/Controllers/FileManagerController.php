<?php

namespace Dawnstar\FileManager\Http\Controllers;

use Carbon\Carbon;
use Dawnstar\FileManager\Foundation\MediaUpload;
use Dawnstar\FileManager\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends BaseController
{
    public function index()
    {
        $medias = Media::orderByDesc('id')->get();

        return view('FileManagerView::pages.filemanager.index', compact('medias'));
    }

    public function upload()
    {
        return view('FileManagerView::pages.filemanager.upload');
    }

    public function trash()
    {
        $medias = Media::onlyTrashed()->orderByDesc('deleted_at')->get();

        return view('FileManagerView::pages.filemanager.trash', compact('medias'));
    }

    public function delete(Request $request)
    {
        $mediaId = $request->get('media_id');

        $media = Media::findOrFail($mediaId);

        $media->delete();

        $folder_path = $media->uploaded_place . '/' . $media->path;
        if (!is_dir(storage_path('app/public/media_trash/' . $folder_path))) {
            mkdir(storage_path('app/public/media_trash/' . $folder_path), 0777, true);
        }

        rename(public_path('uploads/' . $media->uploaded_place . '/' . $media->path . '/' . $media->fullname), storage_path('app/public/media_trash/' . $media->uploaded_place . '/' . $media->path . '/' . $media->fullname));


        // Delete deleted files which is deleted before 30 days
        Media::where('deleted_at', '<', Carbon::now()->subDays(30)->toDateTimeString());
    }

    public function recover(Request $request)
    {
        $mediaId = $request->get('media_id');

        $media = Media::withTrashed()->findOrFail($mediaId);

        $media->restore();

        $folder_path = $media->uploaded_place . '/' . $media->path;

        rename(storage_path('app/public/media_trash/' . $media->uploaded_place . '/' . $media->path . '/' . $media->fullname), public_path('uploads/' . $media->uploaded_place . '/' . $media->path . '/' . $media->fullname));
    }

    public function uploadFromComputer(Request $request)
    {
        $mediaUpload = new MediaUpload();
        $uploadedFile = $mediaUpload->fromComputer($request);

        return response()->json(['message' => $uploadedFile->file_name . ' isimli dosya yükelemesi başarılı!']);
    }

    public function uploadFromUrl(Request $request)
    {
        $url = $request->get('url');

        if(is_null($url)) {
            throw new \Exception('Geçerli bir url girmeniz gerekmektedir.');
        }

        $mediaUpload = new MediaUpload();
        $uploadedFile = $mediaUpload->fromUrl($url);

        return response()->json(['message' => $uploadedFile->file_name . ' isimli dosya yükelemesi başarılı!']);
    }

}
