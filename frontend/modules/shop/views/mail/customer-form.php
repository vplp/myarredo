<?php

use yii\helpers\Html;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
 */
?>
<div class="block-title" style="font-weight: bold; margin-top: 15px;">Данные пользователя:</div>
<div class="customer-data">
    <table>
        <tr>
            <td><label class="label">ФИО</label></td>
            <td><?= Html::encode($model['name']) ?></td>
        </tr>
        <tr>
            <td><label class="label">Телефон</label></td>
            <td><?= Html::encode($model['phone']) ?></td>
        </tr>
        <tr>
            <td><label class="label">Электронный адрес</label></td>
            <td><?= Html::encode($model['email']) ?></td>
        </tr>
        <tr>
            <td><label class="label">Способ доставки:</label></td>
            <td><?= Html::encode($model::rangeDelivery()[$model['delivery']]); ?></td>
        </tr>
        <tr class="comments">
            <td><label class="label">Адресс</label></td>
            <td><?= Html::encode($model['comment']) ?></td>
        </tr>
        <tr class="comments">
            <td><label class="label">Отделение доставки</label></td>
            <td><?= Html::encode($model['department_info']) ?></td>
        </tr>
        <tr class="comments">
            <td><label class="label">Комментарий</label></td>
            <td><?= Html::encode($model['commentuser']) ?></td>
        </tr>

    </table>
</div>