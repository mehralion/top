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
            <?= $description ?>
        </div>
        <div class="py-2">
            <?php if(($iteration - 1) > 0 && $show_prev): ?>
                <!--<a class="badge badge-light" href="<?= $app->urlFor('ratings', array('id' => $rating_id, 'iteration' => ($iteration - 1))) ?>" target="_blank">Предыдущий</a>-->
            <?php endif; ?>
        </div>
        <div class="table-responsive">
            <table class="table table-hover rate-list">
                <thead>
                <tr>
                    <th class="text-center">&nbsp;№&nbsp;</th>
                    <th class="text-left">Персонаж</th>
                    <th class="text-center">Очки</th>
                </tr>
                </thead>
                <tbody>
                <?php if($search !== false): ?>
                    <tr class="search-row table-active">
                        <td class="text-center align-middle"><b><?= ($search['position'] == false || $search['position'] > 500) ? '500+' : $search['position']; ?></b></td>
                        <td class="text-left align-middle break-all">
                            <b class="text-danger">
								<?= User::htmlLoginFromArray($search['user']); ?>
                            </b>
                        </td>
                        <td class="text-center align-middle">
                            <b><?= $search['value']; ?></b>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($rows as $key => $row): ?>
                    <tr>
                        <td class="text-center align-middle"><?= $key + 1 ?></td>
                        <td class="text-left align-middle break-all">
							<?= User::htmlLoginFromArray($row); ?>
                        </td>
                        <td class="text-center align-middle">
							<?= $row['rate_value'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
