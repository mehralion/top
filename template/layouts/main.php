<?php

use components\slim\Middleware\ClientScript\ClientScript;

/**
 * @var $this \components\slim\View
 */
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="document-state" content="Dynamic"/>
    <meta name="resource-type" content="document"/>
    <meta name="copyright" lang="ru" content="Oldbk"/>
    <meta name="viewport" content="initial-scale=1.0, width=device-width">

    <meta name='yandex-verification' content='60ef46abc2646a77'>
    <meta name='yandex-verification' content='72aca2e356914f7e'>

    <meta name="keywords" content="бойцовский клуб, бк, онлайн игра, rpg, магия бой, игра фэнтези, fantasy, маг ">
    <meta name="description"
          content="Бойцовский клуб - rpg онлайн игра, он же БК, созданный в 2003 году. Борьба Тьмы и Света. Бои, магия, персонажи - всё это Бойцовский клуб">
    <meta name="robots" content="index, follow"/>

    <!-- start favicons -->
    <link rel="apple-touch-icon" sizes="512x512" href="http://i.oldbk.com/i/icon/oldbk_512x512.png"/>
    <link rel="apple-touch-icon" sizes="144x144" href="http://i.oldbk.com/i/icon/oldbk_144x144.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="http://i.oldbk.com/i/icon/oldbk_114x114.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="http://i.oldbk.com/i/icon/oldbk_72x72.png"/>
    <link rel="apple-touch-icon" sizes="58x58" href="http://i.oldbk.com/i/icon/oldbk_58x58.png"/>
    <link rel="apple-touch-icon" sizes="48x48" href="http://i.oldbk.com/i/icon/oldbk_48x48.png"/>
    <link rel="apple-touch-icon" sizes="29x29" href="http://i.oldbk.com/i/icon/oldbk_29x29.png"/>
    <link rel="apple-touch-icon" href="http://i.oldbk.com/i/icon/oldbk_57x57.png"/>
    <!-- end favicons -->

    <title>Рейтинги ОлдБК</title>


    <?php foreach ($app->clientScript->getCssFiles() as $cssFile): ?>
        <link rel="stylesheet" href="<?= $cssFile ?>" type="text/css">
    <?php endforeach; ?>

    <?php foreach ($app->clientScript->getJsFiles(ClientScript::JS_POSITION_BEGIN) as $jsFile): ?>
        <script src="<?= $jsFile; ?>"></script>
    <?php endforeach; ?>

    <?php
    if ($debugbar) {
        echo $debugbar->getJavascriptRenderer()->renderHead();
    }
    ?>

</head>

<body class="im-01">

<div id="sidebar" class="sidebar d-md-none animated menu-bg">
    <div class="po-re">
        <div class="po-re menu mx-2">
            <ul>
                <?php foreach ($this->getController()->menu_list as $menu): ?>
                    <li class="hr mx-auto"></li>
                    <li class="<?= ($this->getController()->menu && $this->getController()->menu->id == $menu->id) ? ' active' : '' ?>">
                        <a href="<?= $app->urlFor($menu->controller, array('action' => $menu->action)) ?>"><?= $menu->name ?></a>
                        <div class="bg"></div>
                    </li>
                <?php endforeach; ?>
                <li class="hr mx-auto"></li>
            </ul>
        </div>
    </div>
</div>

<div id="wrapper">
    <div class="container-fluid" id="header">
        <div class="row">
            <div class="col header"></div>
        </div>
    </div>

    <div class="container mb-3" id="main">
        <div class="row">
            <div class="kp-class-all po-re mx-auto px-4 sh-10">
                <div class="kp-border po-ab">
                    <div class="border-line-top po-ab im-60"></div>
                    <div class="border-line-bootom po-ab im-4"></div>
                    <div class="border-line-left po-ab im-5-fix"></div>
                    <div class="border-line-right po-ab im-6-fix"></div>
                    <img id="sidebarCollapse" class="d-md-none sps sps--abv" data-toggle="tooltip"
                         data-placement="right" title="Меню"
                         src="/asset/adaptive/img/block/left_show_button.png" alt="">
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-4 d-none d-md-block menu-bg">
                            <div class="po-re menu mx-2">
                                <ul>
                                    <li></li>
                                    <?php foreach ($this->getController()->menu_list as $menu): ?>
                                        <li class="hr mx-auto"></li>
                                        <li class="<?= ($this->getController()->menu && $this->getController()->menu->id == $menu->id) ? ' active' : '' ?>">
                                            <a href="<?= $app->urlFor($menu->controller, array('action' => $menu->action)) ?>"><?= $menu->name ?></a>
                                            <div class="bg"></div>
                                        </li>
                                    <?php endforeach; ?>
                                    <?php foreach ($this->getController()->rating_list as $menu): ?>
                                        <?php
                                        $active = '';
                                        if($app->router()->getCurrentRoute()->getName() == 'ratings' && $this->getController()->ratingId == $menu->id) {
                                            $active = ' active';
                                        } ?>
                                        <li class="hr mx-auto"></li>
                                        <li class="<?= $active ?>">
                                            <a href="<?= $app->urlFor('ratings', array('id' => $menu->id)) ?>"><?= $menu->name ?></a>
                                            <div class="bg"></div>
                                        </li>
                                    <?php endforeach; ?>
                                    <li class="hr mx-auto"></li>
                                </ul>
                                <div class="menu-vert-hr"></div>
                            </div>
                        </div>
                        <div class="col-md-8 p-4" id="mainContent">
                            <div class="row">
                                <div class="col-12">
                                    <?= $content ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="footer po-ab im-27">
        <div class="container-fluid d-flex h-100">
            <div class="row align-self-center w-100">
                <div class="col-8">
                    <div class="text-muted m-1">
                        © 2010—<?= Carbon\Carbon::now()->year; ?> «Бойцовский Клуб ОлдБК»
                        <br>
                        <a href="https://oldbk.com/" class="text-muted">Многопользовательская бесплатная онлайн
                            фэнтези рпг - ОлдБК - Старый Бойцовский Клуб</a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="float-right">
                        <!--noindex-->
                        <?= helpers\Counters::getCounters() ?>
                        <!--/noindex-->
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>


<?php foreach ($app->clientScript->getJsFiles(ClientScript::JS_POSITION_END) as $jsFile): ?>
    <script src="<?= $jsFile; ?>"></script>
<?php endforeach; ?>

</body>
</html>
