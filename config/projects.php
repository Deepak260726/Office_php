<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Attachment Path
    |--------------------------------------------------------------------------
    |
    | Path to store the Attachments
    |
    */

    'attachments_path' => storage_path('projects/attachments/'),


    /*
    |--------------------------------------------------------------------------
    | Allowed Extensions
    |--------------------------------------------------------------------------
    |
    | List of file extensions allowed to upload
    |
    */

    'allowed_extensions' => array('jpeg', 'jpg', 'png', 'pdf', 'csv', 'xlsx', 'xls', 'doc', 'docx', 'ppt', 'pptx', 'msg', 'eml', 'txt', 'edi'),


    /*
    |--------------------------------------------------------------------------
    | Max Attachment Size
    |--------------------------------------------------------------------------
    |
    | Max Allowed Attachments Size
    |
    */

    'max_allowed_size' => 6100000,


    /*
    |--------------------------------------------------------------------------
    | Weather Color Codes
    |--------------------------------------------------------------------------
    |
    | Different Color Codes used 
    |
    */

    'weather_color_sunny' => 'D4EDB9',
    'weather_color_cloudy' => 'FDE9D9',
    'weather_color_rainy' => 'FDE9D9',
    'weather_color_stormy' => 'FFBDBD',

];
