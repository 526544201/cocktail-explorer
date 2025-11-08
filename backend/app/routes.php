<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controller\SearchController;

return function (App $app) {

    $app->group('/api/v1', function (RouteCollectorProxy $group) {

        $group->get('/search/name', [SearchController::class, 'searchByName']);

        $group->get('/search/ingredient', [SearchController::class, 'searchByIngredient']);
        
        $group->get('/lookup/{id}', [SearchController::class, 'getDetailsById']); 
        
        $group->get('/random', [SearchController::class, 'getRandom']);

    });
};