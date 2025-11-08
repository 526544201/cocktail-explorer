<?php
declare(strict_types=1);

use App\Middleware\ApiKeyMiddleware;
use Slim\App;

return function (App $app) {

    $isDevelopment = ($_ENV['APP_ENV'] ?? 'production') === 'development';

    $corsOrigin = $_ENV['CORS_ALLOWED_ORIGIN'] ?? '';

    $app->add(new ApiKeyMiddleware($_ENV['API_KEY']));

    $app->add(function ($request, $handler) use ($corsOrigin) {
        $response = $handler->handle($request);
        
        return $response
            ->withHeader('Access-Control-Allow-Origin', $corsOrigin) 
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, X-API-KEY')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    });

    $app->addBodyParsingMiddleware();

    $app->addErrorMiddleware($isDevelopment, true, true);
};