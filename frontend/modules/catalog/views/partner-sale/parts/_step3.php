<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\{
    Sale, SaleLang
};

/**
 * @var $model Sale
 * @var $modelLang SaleLang
 */

?>

<!-- steps box -->

<?= $this->render('_steps_box') ?>

<!-- steps box end -->

<?= $this->render('../../sale/view', [
    'model' => $model,
    'modelLang' => $modelLang
]) ?>

<div class="buttons-cont">
    <?= Html::a(
        Yii::t('app', 'Вернуться к списку'),
        ['/catalog/partner-sale/list'],
        ['class' => 'btn btn-primary']
    ) ?>

    <?= Html::a(
        Yii::t('app', 'Edit'),
        ['/catalog/partner-sale/update', 'id' => $model->id],
        ['class' => 'btn btn-primary']
    ) ?>

    <?= Html::a(
        Yii::t('app', 'Больше просмотров'),
        ['/catalog/partner-sale/update', 'id' => $model->id, 'step' => 'promotion'],
        ['class' => 'btn btn-goods', 'style' => 'display: none;']
    ) ?>
</div>