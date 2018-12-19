<?php
use models\User;
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 30.04.2016
 *
 * @var $image string
 * @var $user array
 * @var $value int
 * @var $position int
 */ ?>

<tr class="search-row table-active">
    <td class="text-center align-middle"><b><?= $position; ?></b></td>
    <td class="text-left align-middle break-all">
        <b class="text-danger"><?= User::htmlLoginFromArray($user); ?></b>
    </td>
    <td class="text-center align-middle">
        <b><?= $value ?></b>
    </td>
    <td class="text-center align-middle">
        <img src="<?= $image ?>" alt="">
    </td>
</tr>
