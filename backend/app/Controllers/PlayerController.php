<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PlayerModel;

class PlayerController extends ResourceController
{
  use ResponseTrait;

  protected $playerModel;

  public function __construct()
  {
    $this->playerModel = new PlayerModel();
  }

  private function failValidationError(string $description = 'Bad Request', ?string $code = null, string $message = '')
  {
    return $this->fail($description, $this->codes['invalid_data'], $code, $message);
  }

  /**
   * Get all players with pagination and search
   * GET /api/players
   */
  public function index()
  {
    try {
      $page = $this->request->getGet('page') ?? 1;
      $perPage = min($this->request->getGet('perPage') ?? 10, 50);
      $search = $this->request->getGet('search') ?? '';

      $result = $this->playerModel->getPlayersPaginated($page, $perPage, $search);

      return $this->respond($result);
    } catch (\Exception $e) {
      return $this->failServerError('Error to get players: ' . $e->getMessage());
    }
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

    try {
      $player = $this->playerModel->getPlayerWithStats($id);

      if (!$player) {
        return $this->failNotFound('Player not found');
      }

      return $this->respond($player);
    } catch (\Exception $e) {
      return $this->failServerError('Erro to fetch the player: ' . $e->getMessage());
    }
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

    try {
      $dateFrom = $this->request->getGet('date_from');
      $dateTo = $this->request->getGet('date_to');

      $sessions = $this->playerModel->getPlayerSessions($id, $dateFrom, $dateTo);

      return $this->respond([
        'sessions' => $sessions,
        'player_id' => (int)$id,
        'filters' => [
          'date_from' => $dateFrom,
          'date_to' => $dateTo
        ]
      ]);
    } catch (\Exception $e) {
      return $this->failServerError('Erro ao buscar sessões: ' . $e->getMessage());
    }
  }

  /**
   * Health check endpoint
   * GET /api/health
   */
  public function health()
  {
    $db = \Config\Database::connect();

    $result = [
      'status' => 'healthy',
      'service' => 'EasyCoach API',
      'timestamp' => date('Y-m-d H:i:s'),
      'database' => 'connected',
      'version' => '1.0.0'
    ];

    try {
      $db->query('SELECT 1');
    } catch (\Exception $e) {
      $result['database'] = 'Not Connected. ' . $e->getMessage();
    }
    return $this->respond($result);
  }
}
