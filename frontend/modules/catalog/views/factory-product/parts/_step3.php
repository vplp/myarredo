<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\{
    FactoryProduct, FactoryProductLang
};
use yii\helpers\Url;

/**
 * @var FactoryProduct $model
 * @var FactoryProductLang $modelLang
 */

?>
    <div class="form-horizontal add-itprod-content">
        <!-- steps box -->

        <?= $this->render('_steps_box') ?>

        <!-- steps box end -->

        <?= $this->render('../../product/view', [
            'model' => $model,
            'modelLang' => $modelLang
        ]) ?>

        <div class="buttons-cont">
            <?= Html::a(
                Yii::t('app', 'Edit'),
                ['/catalog/factory-product/update', 'id' => $model->id],
                ['class' => 'btn btn-primary']
            ) ?>

            <?= Html::a(
                Yii::t('app', 'Больше просмотров'),
                ['/catalog/factory-product/update', 'id' => $model->id, 'step' => 'promotion'],
                ['class' => 'btn btn-goods']
            ) ?>
        </div>

    </div>

    <!-- rules box -->
    <div class="add-itprod-rules">
        <div class="add-itprod-rules-item">

            <?= Yii::$app->param->getByName('PARTNER_SALE_TEXT') ?>

        </div>
    </div>
    <!-- rules box end -->

<?php
$script = <<<JS
$('.best-price-form').parent().hide();
$('.best-price').hide();
$('.rec-slider-wrap').hide();
JS;

$this->registerJs($script);
