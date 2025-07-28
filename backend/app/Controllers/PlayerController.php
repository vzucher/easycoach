<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class PlayerController extends ResourceController
{
    use ResponseTrait;

    /**
     * Get all players with pagination and search
     * GET /api/players
     */
    public function index()
    {
        // Mock data for now - replace with database queries
        $mockPlayers = [
            ['id' => 1, 'name' => 'Lionel Messi', 'position' => 'Forward', 'created_at' => '2024-01-15'],
            ['id' => 2, 'name' => 'Cristiano Ronaldo', 'position' => 'Forward', 'created_at' => '2024-01-10'],
            ['id' => 3, 'name' => 'Kylian Mbappé', 'position' => 'Forward', 'created_at' => '2024-01-20'],
            ['id' => 4, 'name' => 'Erling Haaland', 'position' => 'Forward', 'created_at' => '2024-01-12'],
            ['id' => 5, 'name' => 'Neymar Jr', 'position' => 'Forward', 'created_at' => '2024-01-08'],
            ['id' => 6, 'name' => 'Kevin De Bruyne', 'position' => 'Midfielder', 'created_at' => '2024-01-18'],
            ['id' => 7, 'name' => 'Virgil van Dijk', 'position' => 'Defender', 'created_at' => '2024-01-14'],
            ['id' => 8, 'name' => 'Sadio Mané', 'position' => 'Forward', 'created_at' => '2024-01-16'],
        ];

        // Get pagination parameters
        $page = $this->request->getGet('page') ?? 1;
        $perPage = min($this->request->getGet('perPage') ?? 10, 50); // Max 50 per page
        $search = $this->request->getGet('search') ?? '';

        // Apply search filter
        if ($search) {
            $mockPlayers = array_filter($mockPlayers, function($player) use ($search) {
                return stripos($player['name'], $search) !== false;
            });
        }

        // Apply pagination
        $total = count($mockPlayers);
        $offset = ($page - 1) * $perPage;
        $players = array_slice($mockPlayers, $offset, $perPage);

        return $this->respond([
            'players' => array_values($players),
            'pagination' => [
                'page' => (int)$page,
                'perPage' => (int)$perPage,
                'total' => $total,
                'totalPages' => ceil($total / $perPage)
            ],
            'search' => $search
        ]);
    }

    /**
     * Get single player with stats
     * GET /api/players/{id}
     */
    public function show($id = null)
    {
        if (!$id) {
            return $this->failValidationError('Player ID is required');
        }

        // Mock player data
        $mockPlayer = [
            'id' => (int)$id,
            'name' => 'Player ' . $id,
            'position' => 'Forward',
            'created_at' => '2024-01-15',
            'stats' => [
                'last_30_days' => [
                    'total_distance' => rand(50, 150) . ' km',
                    'top_speed' => rand(25, 35) . ' km/h',
                    'sessions_count' => rand(8, 20)
                ]
            ]
        ];

        return $this->respond($mockPlayer);
    }

    /**
     * Get player sessions
     * GET /api/players/{id}/sessions
     */
    public function sessions($id = null)
    {
        if (!$id) {
            return $this->failValidationError('Player ID is required');
        }

        // Mock sessions data
        $mockSessions = [];
        for ($i = 1; $i <= 10; $i++) {
            $mockSessions[] = [
                'id' => $i,
                'player_id' => (int)$id,
                'date' => date('Y-m-d', strtotime("-{$i} days")),
                'distance' => rand(5, 15) . ' km',
                'duration' => rand(60, 120) . ' minutes',
                'top_speed' => rand(25, 35) . ' km/h'
            ];
        }

        // Apply date filters if provided
        $dateFrom = $this->request->getGet('date_from');
        $dateTo = $this->request->getGet('date_to');

        return $this->respond([
            'sessions' => $mockSessions,
            'player_id' => (int)$id,
            'filters' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo
            ]
        ]);
    }

    /**
     * Health check endpoint
     * GET /api/health
     */
    public function health()
    {
        return $this->respond([
            'status' => 'healthy',
            'service' => 'EasyCoach API',
            'timestamp' => date('Y-m-d H:i:s'),
            'database' => 'connected', // TODO: Add real DB health check
            'version' => '1.0.0'
        ]);
    }
}
