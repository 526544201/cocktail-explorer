<?php
declare(strict_types=1);

use App\Middleware\ApiKeyMiddleware;
use Slim\App;
use Psr\Http\Message\ServerRequestInterface as Request; 
use Psr\Http\Server\RequestHandlerInterface as RequestHandler; 

return function (App $app) {

    $isDevelopment = ($_ENV['APP_ENV'] ?? 'production') === 'development';

    $app->add(new ApiKeyMiddleware($_ENV['API_KEY']));

    $app->add(function (Request $request, RequestHandler $handler) { 
        
        $allowedOrigin = $_ENV['CORS_ALLOWED_ORIGIN'];

        if ($request->getMethod() === 'OPTIONS') {
            $responseFactory = new \Slim\Psr7\Factory\ResponseFactory();
            $response = $responseFactory->createResponse(200);

            return $response
                ->withHeader('Access-Control-Allow-Origin', $allowedOrigin)
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, X-API-KEY')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
                ->withHeader('Access-Control-Allow-Credentials', 'true');
        }

        $response = $handler->handle($request);
        
        return $response
            ->withHeader('Access-Control-Allow-Origin', $allowedOrigin)
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, X-API-KEY')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    });

    $app->addBodyParsingMiddleware();
    $app->addErrorMiddleware($isDevelopment, true, true);
};