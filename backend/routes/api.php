<?php


function getAllPlayersFromDB($search = '', $page = 1, $perPage = 10) {
    $dbPath = __DIR__ . '/../seed/hello.db';
    
    try {
        $pdo = new PDO("sqlite:$dbPath");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $whereClause = '';
        $params = [];
        if ($search) {
            $whereClause = 'WHERE name LIKE :search';
            $params[':search'] = "%$search%";
        }
        
        $countQuery = "SELECT COUNT(*) FROM players $whereClause";
        $countStmt = $pdo->prepare($countQuery);
        $countStmt->execute($params);
        $total = $countStmt->fetchColumn();
        
        $offset = ($page - 1) * $perPage;
        $totalPages = ceil($total / $perPage);
        
        $query = "SELECT * FROM players $whereClause ORDER BY id LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute($params);
        $players = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'players' => $players,
            'total' => $total,
            'pagination' => [
                'page' => $page,
                'perPage' => $perPage,
                'total' => $total,
                'totalPages' => $totalPages,
                'offset' => $offset,
                'hasNextPage' => $page < $totalPages,
                'hasPrevPage' => $page > 1
            ]
        ];
        
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $mockPlayers = require __DIR__ . '/../data/mockPlayers.php';
        
        if ($search) {
            $mockPlayers = array_filter($mockPlayers, function($player) use ($search) {
                return stripos($player['name'], $search) !== false;
            });
        }
        
        $total = count($mockPlayers);
        $offset = ($page - 1) * $perPage;
        $totalPages = ceil($total / $perPage);
        $players = array_slice($mockPlayers, $offset, $perPage);
        
        return [
            'players' => $players,
            'total' => $total,
            'pagination' => [
                'page' => $page,
                'perPage' => $perPage,
                'total' => $total,
                'totalPages' => $totalPages,
                'offset' => $offset,
                'hasNextPage' => $page < $totalPages,
                'hasPrevPage' => $page > 1
            ]
        ];
    }
}


function handleHealthCheck() {
    return [
        'status' => 'healthy',
        'service' => 'EasyCoach API',
        'timestamp' => date('Y-m-d H:i:s'),
        'version' => '1.0.0'
    ];
}

function handleGetPlayers() {
    $search = $_GET['search'] ?? '';
    $page = max(1, (int)($_GET['page'] ?? 1));
    $perPage = min(max(1, (int)($_GET['perPage'] ?? 10)), 50);
    $result = getAllPlayersFromDB($search, $page, $perPage);
    
    return [
        'players' => $result['players'],
        'pagination' => $result['pagination'],
        'search' => $search
    ];
}

function handleGetPlayer($id) {
    return [
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
    ];
}

function handleGetPlayerSessions($id) {
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
    return ['sessions' => $sessions, 'player_id' => $id];
}

function handleDefault() {
    return require __DIR__ . '/../data/apiInfo.php';
}


function routeRequest($path) {
    switch (true) {
        case $path === '/api/health':
            return handleHealthCheck();

        case $path === '/api/players':
            return handleGetPlayers();

        case preg_match('#^/api/players/(\d+)$#', $path, $matches):
            return handleGetPlayer((int)$matches[1]);

        case preg_match('#^/api/players/(\d+)/sessions$#', $path, $matches):
            return handleGetPlayerSessions((int)$matches[1]);

        default:
            return handleDefault();
    }
} 