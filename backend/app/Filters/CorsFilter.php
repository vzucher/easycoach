<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CorsFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    // Não faça nada para requisições OPTIONS
    if ($request->getMethod() === 'options') {
      return response()
        ->setHeader('Access-Control-Allow-Origin', '*')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-API-KEY')
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->setStatusCode(200);
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    $response = $response
      ->setHeader('Access-Control-Allow-Origin', '*')
      ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-API-KEY')
      ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

    return $response;
  }
}
