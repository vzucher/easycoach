<?php

// Valid PHP Version?
$minPHPVersion = '8.1';
if (version_compare(PHP_VERSION, $minPHPVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPHPVersion,
        PHP_VERSION
    );

    exit($message);
}

/*
 * --------------------------------------------------------------------
 * Check for .env file
 * --------------------------------------------------------------------
 */
if (! file_exists(dirname(__DIR__) . '/.env')) {
    // Create a basic .env file
    file_put_contents(dirname(__DIR__) . '/.env', "# Environment Configuration\nCI_ENVIRONMENT = development\n");
}

/*
 * --------------------------------------------------------------------
 * Define path constants
 * --------------------------------------------------------------------
 */
// Path to the front controller (this file)
defined('FCPATH') || define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 * --------------------------------------------------------------------
 * Bootstrap CodeIgniter
 * --------------------------------------------------------------------
 */
if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
} else {
    // Simple response if CodeIgniter isn't installed yet
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode([
        'message' => 'EasyCoach Backend API',
        'status' => 'CodeIgniter installation in progress...',
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit;
}

// Boot the CodeIgniter framework
require_once dirname(__DIR__) . '/app/Config/Paths.php';

$paths = new Config\Paths();

$app = \Config\Services::codeigniter();
$app->initialize();
$app->run(); 