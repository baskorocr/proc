<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
    /*
    |--------------------------------------------------------------------------
    | Manifest Order Location Folder for ZIP Download
    |--------------------------------------------------------------------------
    |
    */
        'mf_directory' => [
                'driver' => 'local',
                'root'   => '/manifest/MI/PRD-MI', ///Lokasi File MF
            ],  

        'mf_qas_directory' => [
                'driver' => 'local',
                'root'   => '/manifest/MI/PRD-MI', ///Lokasi File MF
            ], 

        'mf_kanban_directory' => [
                'driver' => 'local',
                'root'   => '/manifest/MI-KANBAN/PRD-MI-KANBAN', ///Lokasi File MF
            ], 

        'mf_qas_kanban_directory' => [
                'driver' => 'local',
                'root'   => '/manifest/MI-KANBAN/PRD-MI-KANBAN', ///Lokasi File MF
            ],
     /////////////////////////////////////////////////////////////////////////
            

    /*
    |--------------------------------------------------------------------------
    | Special Order Location Folder for ZIP Download
    |--------------------------------------------------------------------------
    |
    */
        'so_directory' => [
                'driver' => 'local',
                'root'   => '/manifest/SO/PRD-SO', ///Lokasi File MF
            ], 

        'so_kanban_directory' => [
                'driver' => 'local',
                'root'   => '/manifest/SO-KANBAN/PRD-SO-KANBAN', ///Lokasi File MF
            ],

        'so_qas_directory' => [
                'driver' => 'local',
                'root'   => '/manifest/SO/PRD-SO', ///Lokasi File MF
            ], 

        'so_qas_kanban_directory' => [
                'driver' => 'local',
                'root'   => '/manifest/SO-KANBAN/PRD-SO-KANBAN', ///Lokasi File MF
            ],
    /*
    |--------------------------------------------------------------------------
    | PO File Location Folder for ZIP Download
    |--------------------------------------------------------------------------
    |
    */
        'po_directory' => [
                'driver' => 'local',
                'root'   => '/popdf/PRD-PROC', ///Lokasi File PO
            ],  
        'po_qas_directory' => [
                'driver' => 'local',
                'root'   => '/popdf/PRD-PURC', ///Lokasi File PO
            ], 

    /////////////////////////////////////////////////////////////////////////
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
    /////////////////////////////////////////////////////////////////////////


        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
