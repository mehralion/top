<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 30.04.2016
 */

define('ROOT_DIR', realpath(__DIR__ . '/../'));
define('PRODUCTION_MODE', require(__DIR__ . '/check_prod_mode.php'));
//define('PRODUCTION_MODE', true);
if (!PRODUCTION_MODE) require(__DIR__ . '/debugmode.php');


switch (true) {

    case PRODUCTION_MODE:
        {
            $mode = 'production';
            $filename = 'prod';
            break;
        }

    case PHP_OS === "Darwin":
        {
            $mode = 'local';
            $filename = 'local';
            break;
        }

    default:
        {
            $mode = 'development';
            $filename = 'dev';
        }

}
require_once ROOT_DIR . '/vendor/autoload.php';

use models\_base\AbstractCapitalModel;
use models\_base\AbstractTopModel;


$logWriter = new \Slim\LogWriter(fopen(rtrim(ROOT_DIR, '/').'/logs/slim.log', 'a'));
$app = new \components\slim\Slim(array(
    'mode' => $mode,
    'templates.path' => './template',
    'view' => '\components\slim\View',
    'log.writer' => $logWriter,
));

$app->configureMode($mode, function () use ($app, $filename) {
    $app->config(require(__DIR__ . '/config/' . $filename . '.php'));
});

$app->container->singleton('cache', function () use ($app) {
    $config = array(
        "storage" => "files",
        "path" => "/www/cache/top/",
    );
    \phpFastCache\CacheManager::setup($config);
    return \phpFastCache\CacheManager::Files();
});

$db_config = $app->config('db.capital');
\database\DB::setConfig(array(
    'dsn' => sprintf("mysql:host=%s;dbname=%s;charset=%s", $db_config['host'], $db_config['dbname'], $db_config['charset']),
    'username' => $db_config['username'],
    'password' => $db_config['password'],
), AbstractCapitalModel::connectionName());
$app->container->singleton('db', function () {
    $db = \database\DB::getInstance(AbstractCapitalModel::connectionName());
    $db->execQueryString('SET time_zone = "+3:00";');
    //$db->execQueryString('SET NAMES cp1251;');
    return $db;
});

$db_config = $app->config('db.top');
\database\DB::setConfig(array(
    'dsn' => sprintf("mysql:host=%s;dbname=%s;charset=%s", $db_config['host'], $db_config['dbname'], $db_config['charset']),
    'username' => $db_config['username'],
    'password' => $db_config['password'],
), AbstractTopModel::connectionName());
$app->container->singleton('db_top', function () {
    $db = \database\DB::getInstance(AbstractTopModel::connectionName());
    //$db->execQueryString('SET time_zone = "+3:00";');
    //$db->execQueryString('SET NAMES cp1251;');
    return $db;
});

if (!PRODUCTION_MODE) {
    $debugbar = new \Slim\Middleware\DebugBar();
    $pdo = new DebugBar\DataCollector\PDO\TraceablePDO($app->container->get('db'));
    $debugbar->addCollector(new DebugBar\DataCollector\PDO\PDOCollector($pdo));
    $app->add($debugbar);
}


$app->hook('slim.before', function () use ($app) {
    \models\Settings::getAll();
});
$app->hook('slim.after.router', function () use ($app) {
    $app->response->header('Content-Type', 'text/html; charset=utf-8');
});



register_shutdown_function(function() {
	$error = error_get_last();
	if(isset($error)) {
		$message = sprintf('[%s] Level error: %s | message: %s | file: %s | line: %s', date('d.m.Y H:i:s'), $error['type'], $error['message'], $error['file'], $error['line']).PHP_EOL;

		$filename = 'other';
		$write = true;
		switch ($error['type']) {
			case E_ERROR:
			case E_PARSE:
			case E_COMPILE_ERROR:
			case E_CORE_ERROR:
				$filename = 'fatal';
				$write = true;
				break;
			case E_USER_ERROR:
			case E_RECOVERABLE_ERROR:
				$filename = 'error';
				$write = true;
				break;
			case E_WARNING:
			case E_CORE_WARNING:
			case E_COMPILE_WARNING:
			case E_USER_WARNING:
				$filename = 'warn';
				$write = false;
				break;
			case E_NOTICE:
			case E_USER_NOTICE:
				$filename = 'info';
				$write = false;
				break;
			case E_STRICT:
				$filename = 'debug';
				$write = true;
				break;
			default:
				$filename = 'default';
				$write = true;
				break;
		}
		
		if($write === true) {
			try {
				$filePath = rtrim(ROOT_DIR, '/').'/logs/'.$filename.'.log';

				$h = fopen($filePath, "a");
				fwrite($h, $message);
				fclose($h);
			} catch (\Exception $ex) {

			}
		}
	}
});