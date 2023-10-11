<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang
};

/**
 * @var ItalianProduct $model
 * @var ItalianProductLang $modelLang
 */

?>

<div class="form-horizontal add-itprod-content">

    <!-- steps box -->

    <?= $this->render('_steps_box') ?>

    <!-- steps box end -->

    <?= $this->render('../../sale-italy/view', [
        'model' => $model,
        'modelLang' => $modelLang
    ]) ?>

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

        <?= Html::a(
            Yii::t('app', 'Больше просмотров'),
            ['/catalog/italian-product/update', 'id' => $model->id, 'step' => 'promotion'],
            ['class' => 'btn btn-goods', 'style' => 'display: none;']
        ) ?>
    </div>

</div>

<!-- rules box -->
<div class="add-itprod-rules">
    <div class="add-itprod-rules-item">

        <?= Yii::$app->param->getByName('ITALIAN_PRODUCT_STEP3_TEXT') ?>

    </div>
</div>
<!-- rules box end -->
