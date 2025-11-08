<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;
use Slim\App;
use DI\Container;
use GuzzleHttp\Client;
use App\Service\CocktailDbService;

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$container = new Container();

$container->set(Client::class, function() {
    return new Client();
});

$container->set(CocktailDbService::class, function($c) {
    $client = $c->get(Client::class);
    $base = $_ENV['COCKTAILDB_API_BASE_URL'] ?? getenv('COCKTAILDB_API_BASE_URL') ?? '';
    return new CocktailDbService($client, $base);
});

AppFactory::setContainer($container);

$app = AppFactory::create();

(require __DIR__ . '/middleware.php')($app);

(require __DIR__ . '/routes.php')($app);

return $app;