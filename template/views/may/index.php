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
 * @var $year int
 * @var \components\slim\View $this
 */
?>

<div class="tab-content">
    <div class="search-block py-3">
        <form class="form-inline">
            <div class="form-group mx-auto">
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-sm" id="search-field" placeholder="Логин..."
                           aria-label="Логин..." aria-describedby="basic-addon2">
                    <input type="hidden" value="" id="search-category">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-sm" type="button">Поиск</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div>
        <div class="description text-center">
            <?= $this->getController()->menu->description ?>
        </div>
		<?php if($year == date('Y')): ?>
            <div class="py-2">
                <a class="badge badge-light" href="<?= $app->urlFor('may_archive', array('year' => 2016)) ?>" target="_blank">Рейтинг-2016</a>
                <a class="badge badge-light" href="<?= $app->urlFor('may_archive', array('year' => 2017)) ?>" target="_blank">Рейтинг-2017</a>
            </div>
		<?php endif; ?>
        <div class="table-responsive">
            <table class="table table-hover rate-list">
                <thead>
                <tr>
                    <th class="text-center">&nbsp;№&nbsp;</th>
                    <th class="text-left">Ник</th>
                    <th class="text-center">Знаки героя</th>
                    <th class="text-center">Награда</th>
                </tr>
                </thead>
                <tbody>
                <tr class="search-row"></tr>
                <?php $i = 1;
                foreach ($rows as $key => $row):
                    $img_num = 1;
                    if ($i > 10 && $i < 51) {
                        $img_num = 2;
                    } elseif ($i > 50) {
                        $img_num = 3;
                    }
                    $img = sprintf($image, $img_num);
                    ?>
                    <tr>
                        <td class="text-center align-middle"><?= $i ?></td>
                        <td class="text-left align-middle break-all">
                            <?php if ($row['align'] == 4 || $row['block'] == 1): ?>
                                <i>Невидимка</i>
                            <?php else: ?>
                                <?= User::htmlLoginFromArray($row) ?>
                            <?php endif; ?>
                        </td>
                        <td class="text-center align-middle">
                            <?= $row['rate_value']; ?>
                        </td>
                        <td class="text-center align-middle"><?= $img ? '<img src="' . $img . '" alt="">' : ''; ?></td>
                    </tr>
                    <?php $i++; endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    $(function () {
        $(document.body).on('click', '.search-block button', function (e) {
            e.preventDefault();
            var $self = $(this);
            var login = $('#search-field').val();
            if (login.length == 0) {
                alert('Введите логин');
                return false;
            }

            $.ajax({
                'url': '<?= $app->urlFor('may', array('action' => 'search')) ?>',
                'data': {
                    'login': $('#search-field').val()
                },
                'type': 'post',
                'dataType': 'json',
                'success': function (response) {
                    if (response.html !== undefined) {
                        $('.search-row').replaceWith(response.html);
                    }
                    if (response.message) {
                        alert(response.message);
                    }
                    $('#search-field').val('');
                }
            });
        });
    });
</script>