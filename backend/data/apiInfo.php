<?php



return [
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
]; 