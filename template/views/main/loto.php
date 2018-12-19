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
                    <th class="text-left">Ник</th>
                    <th class="text-center">Предмет</th>
                </tr>
                </thead>
                <tbody>
                <tr class="search-row"></tr>
                <?php foreach ($rows as $key => $row): ?>
                    <tr>
                        <td class="text-center align-middle"><?= $key + 1 ?></td>
                        <td class="text-left align-middle break-all">
                            <?= User::htmlLoginFromArray($row) ?>
                        </td>
                        <td class="text-center align-middle break-all">
                            <?= $row['item_name'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
