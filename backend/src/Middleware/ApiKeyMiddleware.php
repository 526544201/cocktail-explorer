<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ApiKeyMiddleware implements MiddlewareInterface
{
    private string $validApiKey;

    public function __construct(string $validApiKey)
    {
        $this->validApiKey = $validApiKey;
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        if ($request->getMethod() === 'OPTIONS') {
            return $handler->handle($request);
        }
        
        $apiKey = $request->getHeaderLine('X-API-KEY');

        if (empty($apiKey) || $apiKey !== $this->validApiKey) {
            
            $responseFactory = new \Slim\Psr7\Factory\ResponseFactory();
            $response = $responseFactory->createResponse(401);
            
            $error = [
                'error' => 'Unauthorized',
                'message' => 'Invalid or missing API Key'
            ];
            $response->getBody()->write(json_encode($error));
            
            return $response->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }
}