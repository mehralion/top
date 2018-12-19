<?php
namespace controllers\_base;

use components\slim\Slim;

/**
 * Class BaseController
 * @package controllers\_base
 */
abstract class BaseController
{
    /** @var Slim */
    protected $app;


    public $actionId;
    protected $htmlCache = null;
    protected $cache = true;

    /**
     * BaseController constructor.
     * @param Slim $container
     * @param $action
     * @throws \Exception
     */
    public function __construct(Slim $container, $action)
    {
        $this->app = $container;

        if ($this->app->getMode() === 'local') {
            $this->cache = false;
        }

        $this->run($action);
    }

    /**
     * @param $service_name
     * @return mixed
     */
    protected function get($service_name)
    {
        return $this->app->container->get($service_name);
    }

    /**
     * @param $action
     * @throws \Exception
     */
    protected function run($action)
    {
        $actionMethod = method_exists($this, $action.'Action') ? $action.'Action' : 'indexAction';
        if(!method_exists($this, $actionMethod))
            throw new \Exception(sprintf('Action not found. Action: %s', $actionMethod));

        $this->actionId = str_replace('Action', '' , $actionMethod);
        if($this->beforeAction($action)) {
            if($this->htmlCache === null || $this->cache === false) {
                $response = $this->{$actionMethod}();
                if($response) {
                    echo $response;
                }
            } else {
                echo $this->htmlCache;
            }

            $this->afterAction($action);
        }
    }

    /**
     * @param $action
     * @return bool
     */
    protected function beforeAction($action)
    {
        return true;
    }

    /**
     * @param $action
     */
    protected function afterAction($action)
    {

    }

    /**
     * @return mixed
     * @throws \ReflectionException
     */
    protected function getControllerId()
    {
        $ref = (new \ReflectionClass($this));

        return str_replace('controller', '', strtolower($ref->getShortName()));
    }
}