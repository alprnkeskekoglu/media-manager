<?php

namespace Dawnstar\MediaManager\Http\Controllers;

use Illuminate\Routing\Controller;

class MainController extends Controller
{
    public function index()
    {
        return view('MediaManager::index');
    }

    public function getStorageStatus()
    {
        $total = disk_total_space('/');
        $free = disk_free_space('/');
        $filled = $total - $free;
        $rate = floor($filled * 100 / $total);
        $total = unitSizeForHuman($total);
        $filled = unitSizeForHuman($filled);

        $text = __('MediaManager::general.storage_text', ['rate' => $rate, 'total' => $total, 'filled' => $filled]);

        return response()->json(['rate' => $rate, 'text' => $text]);
    }

    public function translations()
    {
        return response()->json([
            'send' => __('MediaManager::general.send'),
            'save' => __('MediaManager::general.save'),
            'delete' => __('MediaManager::general.delete'),
            'download' => __('MediaManager::general.download'),
            'storage' => __('MediaManager::general.storage'),
            'mod' => __('MediaManager::general.mod'),

            'create' => __('MediaManager::general.create'),
            'upload' => __('MediaManager::general.upload'),

            'type' => __('MediaManager::general.type'),
            'order' => __('MediaManager::general.order'),
            'search' => __('MediaManager::general.search'),

            'folder' => [
                'title' => __('MediaManager::folder.title.index'),
                'create_title' => __('MediaManager::folder.title.create'),
                'deleted_title' => __('MediaManager::folder.title.delete'),
                'home' => __('MediaManager::folder.home'),
                'name' => __('MediaManager::folder.labels.name')
            ],

            'media' => [
                'title' => __('MediaManager::media.title.index'),
                'create_title' => __('MediaManager::media.title.create'),
                'deleted_title' => __('MediaManager::media.title.delete'),
                'upload' => __('MediaManager::media.upload'),
                'dropzone' => __('MediaManager::media.dropzone'),

            ],

        ]);
    }
}
