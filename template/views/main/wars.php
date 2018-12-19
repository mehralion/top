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
                    <th class="text-left">Клан</th>
                    <th class="text-center">Воинственность</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($rows as $key => $row): ?>
                    <tr>
                        <td class="text-center align-middle"><?= $key + 1 ?></td>
                        <td class="text-left align-middle break-all">
                            <!--noindex-->
                            <?= \models\Clans::htmlFullFromArray(($row['short']=='pal'?'pal':$row['short']), ($row['short']=='pal'?'1.99':$row['align'])) ?>
                            <?php if($row['cwshort']!=''): ?>
                                , <?= \models\Clans::htmlFullFromArray($row['cwshort'], $row['cwalign']) ?>
                            <?php endif; ?>
                            <!--/noindex-->
                        </td>
                        <td class="text-center align-middle">
                            <?= $row['allvoinst'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
