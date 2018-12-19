<?php
use models\User;
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 30.04.2016
 *
 * @var $rows array
 * @var $this \components\slim\View
 */ ?>
<div class="tab-content">
    <div>
        <div class="description text-center">
            <?= $this->getController()->menu->description ?>
        </div>
        <div class="table-responsive">
            <table class="table table-hover rate-list">
                <thead>
                <tr>
                    <th class="text-center">&nbsp;№&nbsp;</th>
                    <th class="text-left">Воин</th>
                    <th class="text-center">Воинственность</th>
                    <th class="text-center">Награда</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                foreach ($rows as $key => $row):
                    $item_link = 'svitok_exp_40';
                    $item_name = 'Повышенный опыт (+40%)';
                    switch (true) {
                        case ($i < 11):
                            $item_name = 'Повышенный опыт (+100%)';
                            $item_link = 'svitok_exp_100';
                            break;
                        case ($i > 10 && $i < 26):
                            $item_name = 'Повышенный опыт (+80%)';
                            $item_link = 'svitok_exp_80';
                            break;
                        case ($i > 25 && $i < 51):
                            $item_name = 'Повышенный опыт (+60%)';
                            $item_link = 'svitok_exp_60';
                            break;
                    }

                    ?>
                    <tr>
                        <td class="text-center align-middle"><?= $i ?></td>
                        <td class="text-left align-middle break-all">
                            <?= User::htmlLoginFromArray($row); ?>
                        </td>
                        <td class="text-center align-middle">
                            <?= $row['voin'] ?>
                        </td>
                        <td class="text-center align-middle">
                            <?= sprintf('<a href="https://oldbk.com/encicl/mag1/%s.html" target="_blank"><img title="%s" src="https://i.oldbk.com/i/sh/%s.gif"></a>', $item_link, $item_name, $item_link); ?>
                        </td>
                    </tr>
                    <?php
                    $i++;
                endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
