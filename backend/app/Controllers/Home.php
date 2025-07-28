<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Home extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     */
    protected $helpers = [];

    /**
     * Initialize the controller
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
    }

    /**
     * Default home page
     */
    public function index(): string
    {
        return json_encode([
            'message' => 'EasyCoach API',
            'status' => 'active',
            'version' => '1.0.0',
            'endpoints' => [
                'GET /api/players' => 'List all players',
                'GET /api/players/{id}' => 'Get player details',
                'GET /api/players/{id}/sessions' => 'Get player sessions',
                'GET /api/health' => 'Health check'
            ],
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }
} 