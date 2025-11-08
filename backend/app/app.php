<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;
use Slim\App;

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = AppFactory::create();

(require __DIR__ . '/middleware.php')($app);

(require __DIR__ . '/routes.php')($app);

return $app;