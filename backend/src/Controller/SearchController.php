<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\CocktailDbService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SearchController
{
    private CocktailDbService $cocktailService;

    public function __construct(CocktailDbService $cocktailService)
    {
        $this->cocktailService = $cocktailService;
    }

    public function searchByName(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        $query = $params['q'] ?? null;

        if (empty($query)) {
            return $this->errorResponse($response, 'Missing query parameter "q"', 400);
        }

        $results = $this->cocktailService->searchByName($query);
        return $this->jsonResponse($response, $results);
    }

    public function searchByIngredient(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        $query = $params['q'] ?? null;

        if (empty($query)) {
            return $this->errorResponse($response, 'Missing query parameter "q"', 400);
        }

        $results = $this->cocktailService->searchByIngredient($query);
        return $this->jsonResponse($response, $results);
    }

    public function getDetailsById(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'] ?? null;

        if (empty($id)) {
            return $this->errorResponse($response, 'Missing path parameter "id"', 400);
        }

        $results = $this->cocktailService->getDetailsById($id);
        return $this->jsonResponse($response, $results);
    }

    public function getRandom(Request $request, Response $response): Response
    {
        $results = $this->cocktailService->getRandom();
        return $this->jsonResponse($response, $results);
    }

    private function jsonResponse(Response $response, mixed $data, int $status = 200): Response
    {
        $response->getBody()->write(json_encode($data));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    private function errorResponse(Response $response, string $message, int $status = 400): Response
    {
        $error = ['error' => 'Bad Request', 'message' => $message];
        return $this->jsonResponse($response, $error, $status);
    }
}