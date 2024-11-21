<?php
require 'vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

Configuration::instance([
    'cloud' => [
        'cloud_name' => 'TU_CLOUD_NAME',
        'api_key'    => 'TU_API_KEY',
        'api_secret' => 'TU_API_SECRET',
    ],
    'url' => [
        'secure' => true
    ]
]);
?>
