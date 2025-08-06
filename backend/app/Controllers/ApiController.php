<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class ApiController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        require_once __DIR__ . '/../../routes/api.php';
    }

    public function health()
    {
        $response = handleHealthCheck();
        return $this->respond($response);
    }

    public function index()
    {
        $response = handleDefault();
        return $this->respond($response);
    }
} 