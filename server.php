<?php

require_once __DIR__ . '/vendor/autoload.php';

use Mimey\MimeTypes;

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    $file = __DIR__ . '/public' . $uri;
    $mime = new MimeTypes;
    $ext = $mime->getExtension(mime_content_type($file));
    header('Content-Type: ' . $mime->getMimeType($ext));
    readfile($file);

    return false;
}

$_GET['url'] = $_SERVER['REQUEST_URI'];

require_once __DIR__ . '/public/index.php';
