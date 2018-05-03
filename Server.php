<?php
define('BASEPATH', rtrim(realpath('../'), '/'), true);
define('FCPATH', rtrim(dirname(__FILE__).DIRECTORY_SEPARATOR, '/'), true);

$serverScript = array_shift($argv);
parse_str(implode('&', $argv), $params);

date_default_timezone_set(isset($params['timezone']) ? $params['timezone'] : "America/Sao_Paulo");

define('ENVIRONMENT', isset($params['environment']) ? $params['environment'] : 'localhost', true);
define('SERVERSIGN', isset($params['sign']) ? $params['sign'] : 'PauloSouza.info', true);
define('HOST', isset($params['host']) ? $params['host'] : "0.0.0.1", true);
define('PORT', isset($params['port']) ? $params['port'] : 8000, true);
define('CORS', isset($params['cors']) ? $params['cors'] : HOST, true);

if(isset($params['dsn'])) define('DSN', $params['dsn'], true);
else {
  if(!is_file('./application.db')) touch('./application.db');
  define('DSN', 'sqlite:./application.db', true);
}

define('DSNUSER', isset($params['user']) ? $params['user'] : null, true);
define('DSNPASS', isset($params['pass']) ? $params['pass'] : null, true);

// server debug
print_r(strtoupper('Server in '.ENVIRONMENT.' mode').PHP_EOL);


/*
*---------------------------------------------------------------
* Reporte de erros pelo ambiente [localhost/development, testing, production]
*---------------------------------------------------------------
*/
switch (ENVIRONMENT)
{
  case 'localhost':
  case 'development':
    error_reporting(-1);
    ini_set('display_errors', 1);

    $origin = 'http://localhost:4200';
  break;

  case 'testing':
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
  break;

  case 'production':
    ini_set('display_errors', 0);
    if (version_compare(PHP_VERSION, '5.3', '>='))
    {
      error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
    }
    else
    {
      error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
    }
  break;

  default:
    header('HTTP/1.1 503 Serviço não disponível.', TRUE, 503);
    echo 'O ambiente da aplicação não foi configurado corretamente. Ex.: php -f Server.php environment=production';
    exit(1); // EXIT_ERROR
}

require 'vendor/autoload.php';
use \RedBeanPHP\Facade as R;

R::setup(DSN, DSNUSER, DSNPASS);

// sem montagem dinâmica das tabelas
if(isset($params['freeze'])) R::freeze(true);

// sem montagem dinâmica de tabelas específicas
if(isset($params['preserve'])) {
  $preserve = explode(',', $params['preserve']);
  R::freeze($tables);
}

$server = new CapMousse\ReactRestify\Server(SERVERSIGN, HOST);

$server->options('/*', '\Psi\Crud\Preflight@run');

$server->group('database', function($routes) {
  $routes->get('tables', '\Psi\Crud\Database@tables');
  $routes->get('table/{collection}', '\Psi\Crud\Database@table');
});

$server->group('query', function($routes) {
  $routes->get('any', '\Psi\Crud\Query@whatever');
  $routes->get('exec', '\Psi\Crud\Query@execute');
  $routes->get('row', '\Psi\Crud\Query@row');
  $routes->get('col', '\Psi\Crud\Query@col');
  $routes->get('cell', '\Psi\Crud\Query@cell');
});

$server->get('/{collection}/{id}', '\Psi\Crud\Find@one');
$server->get('/{collection}', '\Psi\Crud\Find@many');
$server->post('/{collection}', '\Psi\Crud\Create@save');
$server->put('/{collection}/{id}', '\Psi\Crud\Update@save');
$server->delete('/{collection}/{id}', '\Psi\Crud\Delete@remove');

$server->listen(PORT);
