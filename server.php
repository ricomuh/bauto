<?php

if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // serve the requested resource as-is.
} else {
    $_GET['url'] = $_SERVER['REQUEST_URI'];

    include __DIR__ . '/public/index.php';

    // rewrite like this: RewriteRule ^(.*)$ index.php?url=$1 [L,QSA]

}
