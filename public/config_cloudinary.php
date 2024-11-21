<?php
// require 'vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

Configuration::instance([
    'cloud' => [
        'cloud_name' => 'dozek1by6',
        'api_key'    => '269333762127956',
        'api_secret' => '4JPmec5ClM7ZphsP-YY_ySmRaEc',
    ],
    'url' => [
        'secure' => true
    ]
]);
?>
