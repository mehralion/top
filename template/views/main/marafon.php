<?php
use models\User;

/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 30.04.2016
 *
 * @var $rows array
 * @var $user_id int|boolean
 * @var $image string
 * @var \components\slim\View $this
 * @var int $year
 */ ?>

<div class="tab-content">
    <div>
        <div class="description text-center">
            <?= $this->getController()->menu->description ?>
        </div>
		<?php if($year == date('Y')): ?>
            <div class="py-2">
                <a class="badge badge-light" href="<?= $app->urlFor('main_archive', array('year' => 201609, 'action' => 'marafon')) ?>" target="_blank">Рейтинг-2016</a>
                <a class="badge badge-light" href="<?= $app->urlFor('main_archive', array('year' => 2017, 'action' => 'marafon')) ?>" target="_blank">Рейтинг-2017</a>
            </div>
		<?php endif; ?>
        <div class="table-responsive">
            <table class="table table-hover rate-list">
                <thead>
                <tr>
                    <th class="text-center">&nbsp;№&nbsp;</th>
                    <th class="text-left">Ник</th>
                    <th class="text-center">Баллы</th>
                    <th class="text-center">Награда</th>
                </tr>
                </thead>
                <tbody>
                <tr class="search-row"></tr>
                <?php foreach ($rows as $key => $row):
                    $img_num = 3;
                    $i = $key + 1;
                    if($i > 10 && $i < 51) {
                        $img_num = 2;
                    } elseif($i > 50) {
                        $img_num = 1;
                    }
                    $img = sprintf($image, $img_num);
                    ?>
                    <tr>
                        <td class="text-center align-middle"><?= $i ?></td>
                        <td class="text-left align-middle break-all">
                            <?php if($row['align'] == 4 || $row['block'] == 1): ?>
                                <i>Невидимка</i>
                            <?php else: ?>
                                <?= User::htmlLoginFromArray($row) ?>
                            <?php endif; ?>
                        </td>
                        <td class="text-center align-middle">
                            <?= $row['rate_value']; ?>
                        </td>
                        <td class="text-center align-middle"><?= $img ? '<img src="'.$img.'" alt="">' : ''; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>