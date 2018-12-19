<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 18.11.2015
 */

namespace components\slim;
use components\slim\Middleware\ClientScript\ClientScriptRegister;
use components\slim\Middleware\Session\Session;
use components\WebUser;
use phpFastCache\Core\DriverAbstract;

/**
 * Class Slim
 * @package components\Slim
 *
 * @property \database\DB $db
 * @property \database\DB $db_top
 * @property \components\slim\Middleware\Session\Helper $session
 * @property \components\slim\Middleware\ClientScript\ClientScript $clientScript
 * @property \components\WebUser $webUser
 * @property DriverAbstract $cache
 * @property \models\Settings $app_config
 *
 */
class Slim extends \Slim\Slim
{
    public function __construct(array $userSettings = array())
    {
        parent::__construct($userSettings);

        // Default environment
        $this->container->singleton('environment', function ($c) {
            $env = \Slim\Environment::getInstance();
            $env['slim.tests.ignore_multibyte'] = true;//это для того, чтобы слим не портил $_POST
            return $env;
        });

        $this->add(new Session());
        $this->add(new ClientScriptRegister());

        $this->container->singleton('router', function ($c) {
            return new Router();
        });

        $this->container->singleton('logWriter', function ($c) {
            $logWriter = $c['settings']['log.writer'];

            return is_object($logWriter) ? $logWriter : new LogWriter($c['environment']['slim.errors']);
        });

        $_that = $this;
        $this->container->singleton('webUser', function () use ($_that) {
            return new WebUser($_that);
        });
    }

    /**
     * @param string $name
     * @return self
     */
    public static function getInstance($name = 'default')
    {
        return parent::getInstance($name);
    }


    /**
     * @param null $viewClass
     * @return View
     */
    public function view($viewClass = null)
    {
        return parent::view($viewClass);
    }

    public function redirect2($url, $status = 302)
    {
        header('Location: '.$url, true, $status);
        exit;
    }
}