<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 30.04.2016
 */

return array(
    'log.enable'            => true,
    'log.level'             => \Slim\Log::DEBUG,
    'debug'                 => true,
    //link
    'url.capital'           => 'http://capitalcity.oldbk.com',
    'url.oldbk'             => 'http://oldbk.com',
    'url.chat'              => 'http://chat.oldbk.com',
    'url.jsdomain'          => 'oldbk.com',
    //db
    'db.capital' => array(
        'host'              => 'oldbkfastdb.c4c2zvyoc0zt.eu-west-1.rds.amazonaws.com',
        'dbname'            => 'oldbk',
        'username'          => 'oldbk',
        'password'          => 'Psh2nDye09hlq29mz',
        'charset'           => 'utf8'
    ),
    'db.top' => array(
        'host'              => 'oldbkfastdb.c4c2zvyoc0zt.eu-west-1.rds.amazonaws.com',
        'dbname'            => 'topsites',
        'username'          => 'oldbk',
        'password'          => 'Psh2nDye09hlq29mz',
        'charset'           => 'utf8'
    ),
    'gzip'                  => true,
);