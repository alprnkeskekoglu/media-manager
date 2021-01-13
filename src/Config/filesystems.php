<?php
return [
    'disks' => [
        'dawnstar_panel' => [
            'driver' => 'local',
            'root' => public_path('uploads/panel'),
        ],
        'dawnstar_web' => [
            'driver' => 'local',
            'root' => public_path('uploads/web'),
        ],
    ],
];
