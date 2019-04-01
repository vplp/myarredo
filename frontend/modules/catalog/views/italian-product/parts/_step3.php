<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\catalog\models\ItalianProduct $model
 * @var \frontend\modules\catalog\models\ItalianProductLang $modelLang
 */

?>

step3

<div class="buttons-cont">
    <?= Html::a(
        Yii::t('app', 'Edit'),
        ['/catalog/italian-product/update', 'id' => $model->id],
        ['class' => 'btn btn-primary']
    ) ?>

    <?= Html::a(
        Yii::t('app', 'Опубликовать'),
        ['/catalog/italian-product/update', 'id' => $model->id, 'step' => 'payment'],
        ['class' => 'btn btn-primary']
    ) ?>
</div>
