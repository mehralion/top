<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 30.04.2016
 */

return array(
    'log.enabled'           => true,
    'log.level'             => \Slim\Log::DEBUG,
    'debug'                 => true,
    //link
    'url.capital'           => 'http://capitalcity.oldbk.com',
    'url.oldbk'             => 'http://oldbk.com',
    'url.chat'              => 'http://chat.oldbk.com',
    'url.jsdomain'          => 'oldbk.com',
    //db
    'db.capital' => array(
        'host'              => 'localhost',
        'dbname'            => 'oldbk',
        'username'          => 'root',
        'password'          => 'root',
        'charset'           => 'utf8'
    ),
    'db.top' => array(
        'host'              => 'localhost',
        'dbname'            => 'topsites',
        'username'          => 'root',
        'password'          => 'root',
        'charset'           => 'utf8'
    ),
    'gzip'                  => true,
);