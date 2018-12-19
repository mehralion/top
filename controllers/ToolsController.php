<?php
namespace controllers;
use controllers\_base\WebController;
use models\User;

/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 18.11.2015
 *
 */
class ToolsController extends WebController
{
    public function cacheAction()
    {
        $this->app->cache->clean();

        return $this->renderJSON(array(
            'ok' => true
        ));
    }
}