<?php

use yii\helpers\Html;

/**
 * @var $model \backend\modules\location\models\City
 * @var $modelLang \backend\modules\location\models\CityLang
 * @var $form \backend\widgets\forms\ActiveForm
 */

?>

<div>
    <p>Взять данные можно по ссылке <?= Html::a(
            'http://ru.mygeoposition.com/#geometatags',
            'http://ru.mygeoposition.com/#geometatags',
            ['target' => '_blank']
        ); ?></p>
</div>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->text_line($model, 'lat') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'lng') ?>
    </div>
</div>

<?= $form->text_line($model, 'geo_placename') ?>

<?= $form->text_line($model, 'geo_position') ?>

<?= $form->text_line($model, 'geo_region') ?>

<?= $form->text_line($model, 'icbm') ?>
