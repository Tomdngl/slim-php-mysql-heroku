<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';
// require_once './middlewares/Logger.php';

require_once './controllers/ClienteController.php';
require_once './controllers/EmpleadoController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/MesaController.php';

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();
// Set base path
$app->setBasePath('/app');

// Add error middleware
$app->addErrorMiddleware(true, true, true);

//Eloquent
$container=$app->getContainer();

$capsule = new Capsule();
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'remotemysql.com',
    'database' => $_ENV['MYSQL_DB'],
    'username' => $_ENV['MYSQL_USER'],
    'password' => $_ENV['MYSQL_PASS'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->group('/clientes', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ClienteController::class . ':TraerTodos');
    $group->get('/{usuario}', \ClienteController::class . ':TraerUno');
    $group->post('[/]', \ClienteController::class . ':CargarUno');
    $group->put('/{id}', \ClienteController::class . ':ModificarUno');
    $group->delete('/{id}', \ClienteController::class . ':BorrarUno');
  });

$app->group('/empleados', function (RouteCollectorProxy $group) {
    $group->get('[/]', \EmpleadoController::class . ':TraerTodos');
    $group->get('/{usuario}', \EmpleadoController::class . ':TraerUno');
    $group->post('[/]', \EmpleadoController::class . ':CargarUno');
    $group->post('/modificar', \EmpleadoController::class . ':ModificarUno');
});

$app->group('/productos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \ProductoController::class . ':TraerTodos');
  $group->get('/{producto}', \ProductoController::class . ':TraerUno');
  $group->post('[/]', \ProductoController::class . ':CargarUno');
  $group->post('/modificar', \ProductoController::class . ':ModificarUno');
});

$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->get('[/]', \MesaController::class . ':TraerTodos');
  $group->get('/{mesa}', \MesaController::class . ':TraerUno');
  $group->post('[/]', \MesaController::class . ':CargarUno');
  $group->post('/modificar', \MesaController::class . ':ModificarUno');
});

$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("Slim Framework 4 PHP");
    return $response;
  });

  /*
$app->group('/credenciales', function (RouteCollectorProxy $group) {
    $group->get('[/]', function (Request $request, Response $response) {
      $response->getBody()->write("Slim Framework 4 PHP");
    });
    $group->post('[/]', function (Request $request, Response $response) {
      $response->getBody()->write("Slim Framework 4 PHP");
    });
})->add(\Logger::class . "LogOperacion");
  */

$app->run();
