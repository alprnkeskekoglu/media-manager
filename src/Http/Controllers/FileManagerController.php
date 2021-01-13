<?php

namespace Dawnstar\FileManager\Http\Controllers;

use Dawnstar\FileManager\Foundation\MediaUpload;
use Dawnstar\FileManager\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends BaseController
{
    public function index()
    {
        $medias = Media::all();
        
        return view('FileManagerView::pages.filemanager.index', compact('medias'));
    }

    public function create()
    {
        return view('FileManagerView::pages.filemanager.create');
    }

    public function uploadFromComputer(Request $request)
    {
        $mediaUpload = new MediaUpload();

        $mediaUpload->fromComputer($request);
    }

}
