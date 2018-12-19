<?php
use models\User;
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 30.04.2016
 *
 * @var $clans array
 * @var $castles array
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
                    <th class="text-left">Название клана</th>
                    <th class="text-center">9</th>
                    <th class="text-center">10</th>
                    <th class="text-center">11</th>
                    <th class="text-center">12</th>
                    <th class="text-center">13</th>
                    <th class="text-center">14</th>
                    <th class="text-center">Всего</th>
                </tr>
                </thead>
                <tbody>
                <tr class="search-row"></tr>
                <?php $i = 1; foreach ($castles as $key => $value): ?>
                    <tr>
                        <td class="text-center align-middle"><b><?= $i; ?></b></td>
                        <td class="text-left align-middle break-all">
                            <?= \models\Clans::htmlFullFromArray($clans[$key]['short'], $clans[$key]['align']) ?>
                        </td>
                        <td class="text-center align-middle"><?= $value[9] > 0 ? $value[9] : '' ?></td>
                        <td class="text-center align-middle"><?= $value[10] > 0 ? $value[10] : '' ?></td>
                        <td class="text-center align-middle"><?= $value[11] > 0 ? $value[11] : '' ?></td>
                        <td class="text-center align-middle"><?= $value[12] > 0 ? $value[12] : '' ?></td>
                        <td class="text-center align-middle"><?= $value[13] > 0 ? $value[13] : '' ?></td>
                        <td class="text-center align-middle"><?= $value[14] > 0 ? $value[14] : '' ?></td>
                        <td class="text-center align-middle"><?= ($value[7] + $value[8] + $value[9] + $value[10] + $value[11] + $value[12] + $value[13] + $value[14]) ?></td>
                    </tr>
                    <tr>
                        <td colspan="9" class="hr"></td>
                    </tr>
                    <?php $i++; endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
