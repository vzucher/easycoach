<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class PlayerController extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        require_once __DIR__ . '/../../routes/api.php';
        $response = handleGetPlayers();
        return $this->respond($response);
    }

    public function show($id = null)
    {
        if (!$id) {
            return $this->failValidationError('Player ID is required');
        }

        require_once __DIR__ . '/../../routes/api.php';
        $response = handleGetPlayer((int)$id);
        return $this->respond($response);
    }

    public function sessions($id = null)
    {
        if (!$id) {
            return $this->failValidationError('Player ID is required');
        }

        require_once __DIR__ . '/../../routes/api.php';
        $response = handleGetPlayerSessions((int)$id);
        return $this->respond($response);
    }

    public function health()
    {
        return $this->respond([
            'status' => 'healthy',
            'service' => 'EasyCoach API',
            'timestamp' => date('Y-m-d H:i:s'),
            'database' => 'connected',
            'version' => '1.0.0'
        ]);
    }
}
