<?php

function __autoload($class_name)
{
    include '../class/'.$class_name.'.php';
}
session_start();
if (isset($_SESSION['hoaxinh'])) {
    $options = [
        'script_url' => '/admin/upload.php',
        'upload_dir' => __DIR__.'/../hoaxinh/',
        'upload_url' => '/hoaxinh/',
        'user_dirs' => false,
        'mkdir_mode' => 0755,
        'param_name' => 'files',
        // Set the following option to 'POST', if your server does not support
        // DELETE requests. This is a parameter sent to the client:
        'delete_type' => 'DELETE',
        'access_control_allow_origin' => '*',
        'access_control_allow_credentials' => false,
        'access_control_allow_methods' => [
            'OPTIONS',
            'HEAD',
            'GET',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
        ],
        'access_control_allow_headers' => [
            'Content-Type',
            'Content-Range',
            'Content-Disposition',
        ],
        // Read files in chunks to avoid memory limits when download_via_php
        // is enabled, set to 0 to disable chunked reading of files:
        'readfile_chunk_size' => 10 * 1024 * 1024, // 10 MiB
        // Defines which files can be displayed inline when downloaded:
        'inline_file_types' => '/\.(gif|jpe?g|png)$/i',
        // Defines which files (based on their names) are accepted for upload:
        'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
        // The php.ini settings upload_max_filesize and post_max_size
        // take precedence over the following max_file_size setting:
        'max_file_size' => null,
        'min_file_size' => 1,
        // The maximum number of files for the upload directory:
        'max_number_of_files' => null,
        // Defines which files are handled as image files:
        'image_file_types' => '/\.(gif|jpe?g|png)$/i',
        // Use exif_imagetype on all files to correct file extensions:
        'correct_image_extensions' => false,
        // Image resolution restrictions:
        'max_width' => null,
        'max_height' => null,
        'min_width' => 1,
        'min_height' => 1,
        // Set the following option to false to enable resumable uploads:
        'discard_aborted_uploads' => true,
        // Set to 0 to use the GD library to scale and orient images,
        // set to 1 to use imagick (if installed, falls back to GD),
        // set to 2 to use the ImageMagick convert binary directly:
        'image_library' => 1,
        // Uncomment the following to define an array of resource limits
        // for imagick:
        /*
        'imagick_resource_limits' => array(
            imagick::RESOURCETYPE_MAP => 32,
            imagick::RESOURCETYPE_MEMORY => 32
        ),
        */
        // Command or path for to the ImageMagick convert binary:
        'convert_bin' => 'convert',
        // Uncomment the following to add parameters in front of each
        // ImageMagick convert call (the limit constraints seem only
        // to have an effect if put in front):
        /*
        'convert_params' => '-limit memory 32MiB -limit map 32MiB',
        */
        // Command or path for to the ImageMagick identify binary:
        'identify_bin' => 'identify',
        'image_versions' => [
            // The empty image version key defines options for the original image:
            '' => [
                // Automatically rotate images based on EXIF meta data:
                'auto_orient' => true,
            ],
            // Uncomment the following to create medium sized images:
            /*
            'medium' => array(
                'max_width' => 800,
                'max_height' => 600
            ),
            */
            'thumbnail' => [
                // Uncomment the following to use a defined directory for the thumbnails
                // instead of a subdirectory based on the version identifier.
                // Make sure that this directory doesn't allow execution of files if you
                // don't pose any restrictions on the type of uploaded files, e.g. by
                // copying the .htaccess file from the files directory for Apache:
                'upload_dir' => __DIR__.'/../thumbs/',
                'upload_url' => '/thumbs/',
                // Uncomment the following to force the max
                // dimensions and e.g. create square thumbnails:
                //'crop' => true,
                'max_width' => HoaXinh::THUMBS_WIDTH,
            ],
        ],
        'print_response' => true,
    ];
    $uploadHandler = new UploadHandler($options);
}
