<?php

namespace Dawnstar\FileManager\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class FileManagerController extends BaseController
{
    public function index()
    {
        return view('FileManagerView::pages.filemanager.index');
    }

    public function upload()
    {
        return view('FileManagerView::pages.filemanager.upload');
    }

}
