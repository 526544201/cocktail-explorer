<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {

    // Just a test route to verify the API is working
    $app->get('/api/hello', function (Request $request, Response $response) {
        $data = ['message' => 'Hello Wordl!'];
        $payload = json_encode($data);
        
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    });

};