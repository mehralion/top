<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 30.04.2016
 *
 * @var $rows array
 * @var $this \components\slim\View
 */
?>

<div class="tab-content">
    <div>
        <div class="description text-center">
            <?= ($this->getController()->menu->description ?? '') ?>
        </div>
        <div class="table-responsive">
            <table class="table table-hover rate-list">
                <thead>
                <tr>
                    <th class="text-center"><span class="oi oi-bar-chart"></span></th>
                    <th class="text-left"><span class="oi oi-external-link"></span></th>
                    <th class="text-center"><span class="oi oi-person"></span></th>
                    <th class="text-center"><span class="oi oi-people"></span></th>
                </tr>
                </thead>
                <tbody>
                <tr class="search-row"></tr>
                <?php foreach ($rows as $key => $row): ?>
                    <tr>
                        <td class="text-center align-middle">
                            <a class="text-muted" href="<?= $app->urlFor('rate_site', ['id' => $row['id']]) ?>">
                                <?= $row['id'] != 7 ? $key : ''?>
                            </a>
                        </td>
                        <td class="text-left align-middle break-all">
                            <img alt='' src='https://i.oldbk.com/i/klan/<?= $row['gif'] ?>.gif'>
                            <!--noindex-->
                            <a rel="nofollow" href="<?= htmlspecialchars($row['url'],ENT_QUOTES) ?>" target="_blank"><?= $row['sitename'] ?></a>
                            <!--/noindex-->
                        </td>
                        <td class="text-center align-middle">
                            <?= $row['hoststoday'] ?>
                        </td>
                        <td class="text-center align-middle">
                            <?= $row['hitsin'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
