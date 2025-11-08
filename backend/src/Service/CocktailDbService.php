<?php
declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;

class CocktailDbService
{
    private Client $client;
    private string $baseUrl; 

    public function __construct(Client $client, string $baseUrl)
    {
        $this->client = $client;
        $this->baseUrl = rtrim($baseUrl, '/') . '/';
    }

    public function searchByName(string $name): ?array
    {
        return $this->makeRequest('search.php', ['s' => $name]);
    }

    public function searchByIngredient(string $ingredient): ?array
    {
        return $this->makeRequest('filter.php', ['i' => $ingredient]);
    }

    public function getDetailsById(string $id): ?array
    {
        return $this->makeRequest('lookup.php', ['i' => $id]);
    }

    public function getRandom(): ?array
    {
        return $this->makeRequest('random.php');
    }

    private function makeRequest(string $endpoint, array $query = []): ?array
    {
        try {
            $response = $this->client->request('GET', $this->baseUrl . $endpoint, [
                'query' => $query
            ]);

            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            return $data['drinks'] ?? null; 

        } catch (RequestException $e) {
            return null;
        }
    }
}