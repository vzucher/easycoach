<?php

namespace App\Models;

use CodeIgniter\Model;

class PlayerModel extends Model
{
  protected $table = 'players';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $returnType = 'array';
  protected $useSoftDeletes = false;
  protected $protectFields = true;
  protected $allowedFields = ['name', 'position', 'created_at'];

  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'created_at';

  protected $validationRules = [
    'name' => 'required',
    'position' => 'required',
  ];

  /**
   * Get players with pagination and name filter
   * 
   * @param int $page Current page
   * @param int $perPage Items per page
   * @param string $name Name filter
   * @param string $search General search term
   * @return array
   */
  public function getPlayersPaginated($page = 1, $perPage = 10, $search = '')
  {
    $builder = $this->builder();

    if (!empty($search)) {
      $builder->groupStart()
        ->like('name', $search, 'both')
        ->groupEnd();
    }

    $total = $builder->countAllResults(false);

    $offset = ($page - 1) * $perPage;
    $players = $builder->limit($perPage, $offset)
      ->orderBy('name', 'ASC')
      ->get()
      ->getResultArray();

    return [
      'players' => $players,
      'pagination' => [
        'page' => (int)$page,
        'perPage' => (int)$perPage,
        'total' => $total,
        'totalPages' => ceil($total / $perPage)
      ],
      'search' => $search
    ];
  }

  /**
   * Get Player by ID with Stats
   * 
   * @param int $id Player ID
   * @return array|null
   */
  public function getPlayerWithStats($id)
  {
    $player = $this->find($id);

    if (!$player) {
      return null;
    }

    $player['stats'] = [
      'last_30_days' => [
        'total_distance' => rand(50, 150) . ' km',
        'top_speed' => rand(25, 35) . ' km/h',
        'sessions_count' => rand(8, 20)
      ]
    ];

    return $player;
  }

  /**
   * Get player sessions
   * 
   * @param int $id Player ID
   * @param string $dateFrom Start date filter
   * @param string $dateTo End date filter
   * @return array
   */
  public function getPlayerSessions($id, $dateFrom = null, $dateTo = null)
  {
    $sessions = [];
    for ($i = 1; $i <= 10; $i++) {
      $sessionDate = date('Y-m-d', strtotime("-{$i} days"));

      if ($dateFrom && $sessionDate < $dateFrom) continue;
      if ($dateTo && $sessionDate > $dateTo) continue;

      $sessions[] = [
        'id' => $i,
        'player_id' => (int)$id,
        'date' => $sessionDate,
        'distance' => rand(5, 15) . ' km',
        'duration' => rand(60, 120) . ' minutes',
        'top_speed' => rand(25, 35) . ' km/h'
      ];
    }

    return $sessions;
  }
}
