<?php

// Simple standalone API for EasyCoach challenge
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Parse the request path
$path = $_GET['REQUEST_URI'] ?? $_SERVER['REQUEST_URI'] ?? '';
$path = parse_url($path, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Debug path for development
if (isset($_GET['debug'])) {
    echo json_encode(['debug_path' => $path, 'full_uri' => $_SERVER['REQUEST_URI'] ?? 'not_set']);
    exit;
}

/**
 * 🚫 BAD PRACTICE: Fetching ALL players without pagination
 * This will cause performance issues with large datasets!
 */
function getAllPlayersFromDB($search = '') {
    $dbPath = '/var/www/seed/hello.db';
    
    try {
        $pdo = new PDO("sqlite:$dbPath");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Build query with search but NO PAGINATION
        $whereClause = '';
        $params = [];
        if ($search) {
            $whereClause = 'WHERE name LIKE :search';
            $params[':search'] = "%$search%";
        }
        
        // Get total count
        $countQuery = "SELECT COUNT(*) FROM players $whereClause";
        $countStmt = $pdo->prepare($countQuery);
        $countStmt->execute($params);
        $total = $countStmt->fetchColumn();
        
        // 🚫 Get ALL results without LIMIT - intentionally bad!
        $query = "SELECT * FROM players $whereClause ORDER BY id";
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $players = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'players' => $players,
            'total' => $total,
            'pagination' => null // No pagination info
        ];
        
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        // Fallback mock data if database fails
        $mockPlayers = [
            ['id' => 1, 'name' => 'Lionel Messi', 'position' => 'Forward', 'created_at' => '2024-01-15'],
            ['id' => 2, 'name' => 'Cristiano Ronaldo', 'position' => 'Forward', 'created_at' => '2024-01-10'],
            ['id' => 3, 'name' => 'Kylian Mbappé', 'position' => 'Forward', 'created_at' => '2024-01-20'],
        ];
        
        return [
            'players' => $mockPlayers,
            'total' => count($mockPlayers),
            'pagination' => null
        ];
    }
}

// Router
switch (true) {
    case $path === '/api/health':
        echo json_encode([
            'status' => 'healthy',
            'service' => 'EasyCoach API',
            'timestamp' => date('Y-m-d H:i:s'),
            'version' => '1.0.0'
        ]);
        break;

    case $path === '/api/players':
        $search = $_GET['search'] ?? '';

        // 🚫 BAD: Ignoring pagination parameters completely
        $result = getAllPlayersFromDB($search);
        
        echo json_encode([
            'players' => $result['players'],
            'total' => $result['total'],
            'search' => $search,
            'warning' => '⚠️ All players loaded at once - no pagination!'
        ]);
        break;

    case preg_match('#^/api/players/(\d+)$#', $path, $matches):
        $id = (int)$matches[1];
        echo json_encode([
            'id' => $id,
            'name' => "Player $id",
            'position' => 'Forward',
            'created_at' => '2024-01-15',
            'stats' => [
                'last_30_days' => [
                    'total_distance' => rand(50, 150) . ' km',
                    'top_speed' => rand(25, 35) . ' km/h',
                    'sessions_count' => rand(8, 20)
                ]
            ]
        ]);
        break;

    case preg_match('#^/api/players/(\d+)/sessions$#', $path, $matches):
        $id = (int)$matches[1];
        $sessions = [];
        for ($i = 1; $i <= 10; $i++) {
            $sessions[] = [
                'id' => $i,
                'player_id' => $id,
                'date' => date('Y-m-d', strtotime("-$i days")),
                'distance' => rand(5, 15) . ' km',
                'duration' => rand(60, 120) . ' minutes',
                'top_speed' => rand(25, 35) . ' km/h'
            ];
        }
        echo json_encode(['sessions' => $sessions, 'player_id' => $id]);
        break;

    default:
        echo json_encode([
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
        break;
} 