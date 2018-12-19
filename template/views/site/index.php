<?php
/**
 * @var $site array
 * @var $rank int
 * @var \components\slim\View $this
 */
?>

<div class="mx-auto">

    <? if (filled($site['short'])) : ?>
        <div class="float-right p-2">
            <img class="img-fluid" src='https://i.oldbk.com/i/klan/<?= $site['short'] ?>_big.gif'>
        </div>
    <? endif; ?>

    <div>
        <b>ID</b> : <span class="font-weight-bold"><?= intval($site['memberid']) ?></span>
    </div>

    <? if (filled($site['encicl'])) : ?>
        <div>
            <b><?= $site['klan_type'] ?></b> : <?= $site['encicl'] ?>
        </div>
    <? endif; ?>

    <div>
        <b>Название</b> : <?= e($site['sitename']); ?>
    </div>

    <? if (filled($site['url'])) : ?>
        <div>
            <b>Сайт</b> :
            <? if ($site['ban'] < 1) : ?>
                <a href="<?= e($site['url']); ?>" target="_blank">
                    <?= e($site['url']); ?>
                </a>
            <? else: ?>
                <span class="text-danger font-weight-bold">Заблокирован</span>
            <? endif; ?>
        </div>
    <? endif; ?>

    <div class="pb-4">
        <div>
            <a class="text-dark font-weight-bold" data-toggle="collapse" href="#description" role="link"
               aria-expanded="false" aria-controls="description">
                Описание <span class="oi oi-chevron-bottom" id="desc-type"></span>
            </a>
        </div>
        <div class="collapse" id="description">
            <div class="card card-body">
                <?= $site['description'] && $site['description'] !== 'NULL' ? e($site['description']) : ''; ?>
            </div>
        </div>
    </div>

    <?
    if ($rank === 0) {
        echo "<div>Сегодня нет в рейтинге!</div>";
    } else {
        echo "<div><b>Позиция в рейтинге</b> : <h6 class=\"d-inline\"><span class=\"badge badge-pill badge-success\"><b>$rank</b></span></h6></div>";
    }

    $hitsToday = explode("|", $site['hitstoday']);

    ?>

    <div>
        <b>Посетители сегодня/всего </b> :
        <h6 class="d-inline">
            <span class="badge badge-pill badge-info">
                <?= $rank > 0 ? number_format($site['hoststoday']) : 0 ?> / <?= number_format($site['allhosts']) ?>
            </span>
        </h6>
    </div>

    <div>
        <b>Посещений сегодня/всего </b> :
        <h6 class="d-inline">
            <span class="badge badge-pill badge-info">
                <?= isset($hitsToday[1]) && $rank > 0 ? number_format($hitsToday[1]) : 0 ?>
                / <?= number_format($site['hitstotal']) ?>
            </span>
        </h6>
    </div>

    <?
    $days = explode(" | ", $site['date']);

    if (!isset($days[1])) $days[1] = 0;
    ?>
    <div class="pb-4">
        <b>Статистика за </b> : <h6 class="d-inline"><span
                    class="badge badge-pill badge-primary"><?= number_format($days[1]) ?></span></h6> дней
    </div>

    <div>
        <b>Для возврата на предыдущую страницу нажмите <a href="<?= $app->urlFor('main') ?>"><< сюда</a></b>
    </div>
</div>

<script>
    $(function () {
        $('#description').on('show.bs.collapse', function () {
            $('#desc-type').removeClass('oi-chevron-bottom').addClass('oi-chevron-top');
        }).on('hide.bs.collapse', function () {
            $('#desc-type').removeClass('oi-chevron-top').addClass('oi-chevron-bottom');
        });
    });
</script>


