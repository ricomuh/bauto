<?php

namespace App\Configs;

class DirectoryConfig
{
    /**
     * Application root directory.
     * 
     * @var string
     */
    const ROOT_DIR = __DIR__ . '/../../';

    /**
     * Application directory.
     * 
     * @var string
     */
    const APP_DIR = __DIR__ . '/../app';

    /**
     * Application controllers directory.
     * 
     * @var string
     */
    const APP_CONTROLLERS_DIR = self::APP_DIR . '/Controllers';

    /**
     * Storage directory.
     * 
     * @var string
     */
    const STORAGE_DIR = self::ROOT_DIR . '/storage';

    /**
     * Storage cache directory.
     * 
     * @var string
     */
    const STORAGE_CACHE_DIR = self::STORAGE_DIR . '/cache';
}
