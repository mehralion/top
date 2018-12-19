<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 02.02.2016
 */

namespace components;


use \models\User;

class WebUser extends AbstractComponent
{
    /** @var User */
    private $_user;
    private $_is_guest = true;

    protected function run()
    {
        try {
            $app = $this->app();
            if(!$app->session->get('uid')) {
                $this->_user = null;
                $this->_is_guest = true;
                throw new \Exception();
            } else {
                $this->login();
            }

        } catch (\Exception $ex) {

        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function login()
    {
        $app = $this->app();
        if($app->session->get('uid')) {
            $this->_user = User::findByPk($this->app()->session->get('uid'))->asModel();
            if($this->_user) {
                $this->_is_guest = false;
                return true;
            }
        }

        return false;
    }

    public function getUser()
    {
        if(!$this->_user && !$this->login()) {
            return null;
        }

        return $this->_user;
    }

    public function getId()
    {
        $user = $this->getUser();
        if(!$user) {
            return null;
        }

        return $user->id;
    }

    public function getLogin()
    {
        $user = $this->getUser();
        if(!$user) {
            return null;
        }

        return $user->login;
    }

    public function getAlign()
    {
        $user = $this->getUser();
        if(!$user) {
            return null;
        }

        return $user->align;
    }

    public function getLevel()
    {
        $user = $this->getUser();
        if(!$user) {
            return null;
        }

        return $user->level;
    }

    public function getRoom()
    {
        $user = $this->getUser();
        if(!$user) {
            return null;
        }

        return $user->room;
    }

    public function getKlan()
    {
        $user = $this->getUser();
        if(!$user) {
            return null;
        }

        return $user->klan;
    }

    public function isGuest()
    {
        return $this->_is_guest;
    }

    public function getCityId()
    {
        $user = $this->getUser();
        if(!$user) {
            return null;
        }

        return $user->id_city;
    }

    public function getGender()
    {
        $user = $this->getUser();
        if(!$user) {
            return null;
        }

        return $user->sex;
    }
}