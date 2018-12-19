<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 30.04.2016
 */

require_once __DIR__ . '/common/bootstrap.php';

$app->group('/rate', function () use ($app) {

    $app->group('/archive/:year', function() use ($app) {
        $app->map('/maslo(/:action)', function ($year, $action = 'index') use ($app) {
            new \controllers\MasloController($app, $action, $year);
        })->via('GET', 'POST')->name('maslo_archive');

        $app->map('/march8(/:action)', function ($year, $action = 'index') use ($app) {
            new \controllers\March8Controller($app, $action, $year);
        })->via('GET', 'POST')->name('march8_archive');

		$app->map('/may(/:action)', function ($year, $action = 'index') use ($app) {
			new \controllers\MayArchiveController($app, $action, $year);
		})->via('GET', 'POST')->name('may_archive');

		$app->map('(/:action)', function ($year, $action = 'index') use ($app) {
			new \controllers\MainController($app, $action, $year);
		})->via('GET', 'POST')->name('main_archive');
    });

    $app->map('/maslo(/:action)', function ($action = 'index') use ($app) {
        new \controllers\MasloController($app, $action, 2018);
    })->via('GET', 'POST')->name('maslo');

    $app->map('/march8(/:action)', function ($action = 'index') use ($app) {
        new \controllers\March8Controller($app, $action, 2018);
    })->via('GET', 'POST')->name('march8');

    $app->get('/may(/:action)', function ($action = 'index') use ($app) {
        new \controllers\MayController($app, $action, 2018);
    })->via('GET', 'POST')->name('may');

    $app->get('/tools(/:action)', function ($action = 'index') use ($app) {
        new \controllers\ToolsController($app, $action);
    })->via('GET', 'POST')->name('tools');

    $app->map('/site/:id', function ($id) use ($app) {
        new \controllers\SiteController($app, 'rate', $id);
    })->via('GET', 'POST')->name('rate_site');

	$app->map('/event/:id(/:iteration)', function ($id, $iteration = null) use ($app) {
		new \controllers\RatingController($app, 'index', $id, $iteration);
	})->via('GET', 'POST')->name('ratings');

    $app->map('(/:action)', function ($action = 'index') use ($app) {
        new \controllers\MainController($app, $action, date('Y'));
    })->via('GET', 'POST')->name('main');
});

$app->run();