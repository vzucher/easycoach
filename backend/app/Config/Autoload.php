<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

class Autoload extends AutoloadConfig
{
    /**
     * Array of namespaces for autoloading.
     */
    public $psr4 = [
        APP_NAMESPACE => APPPATH, // For custom app namespace
        'Config'      => APPPATH . 'Config',
    ];

    /**
     * Map of class names and locations
     */
    public $classmap = [];

    /**
     * List of files to autoload
     */
    public $files = [];

    /**
     * List of helpers to autoload
     */
    public $helpers = [];
} 