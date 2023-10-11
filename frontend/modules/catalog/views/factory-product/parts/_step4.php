<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
//
use frontend\modules\catalog\models\{
    FactoryProduct, FactoryProductLang
};
use frontend\modules\payment\models\Payment;
use frontend\modules\promotion\models\PromotionPackage;

/**
 * @var FactoryProduct $model
 * @var FactoryProductLang $modelLang
 * @var PromotionPackage $modelPromotionPackage
 * @var Payment $modelPayment
 */

$modelsPromotionPackage = PromotionPackage::findBase()->all();

$modelPayment = new Payment();
$modelPayment->setScenario('frontend');

$modelPayment->user_id = Yii::$app->user->id;
$modelPayment->type = 'promotion_item';
$modelPayment->promotion_package_id = 0;
$modelPayment->amount = 0;
$modelPayment->currency = 'RUB';
?>

    <div class="form-horizontal add-itprod-content">
        <!-- steps box -->

        <?= $this->render('_steps_box') ?>

        <!-- steps box end -->

        <div class="page create-sale page-reclamations">
            <div class="largex-container">

                <div class="column-center">
                    <div class="form-horizontal">

                        <?php $form = ActiveForm::begin([
                            'action' => Url::toRoute(['/payment/payment/invoice']),
                        ]); ?>

                        <?php foreach ($modelsPromotionPackage as $key => $modelPromotionPackage) { ?>
                            <div class="package-item">
                                <div class="package-name">
                                    <div class="left">
                                        <?= $modelPromotionPackage['lang']['title'] ?>
                                        <div class="package-question"></div>
                                        <div class="package-comment">
                                            <?= $modelPromotionPackage['lang']['content'] ?>
                                        </div>
                                    </div>
                                    <div class="right package-check-box">

                                        <span class="for-checkbox">
                                            <?= Html::radio('PromotionPackage[id]', ($key == 0 ? true : false), [
                                                'value' => $modelPromotionPackage['id'],
                                                'data-price' => $modelPromotionPackage->getPriceInRub(),
                                                'id' => 'radio' . $key,
                                                'class' => 'radio',
                                                'enableLabel' => false,
                                            ]) . Html::label(null, 'radio' . $key)
                                            ?>
                                        </span>
                                        <span class="for-price">
                                            <?= $modelPromotionPackage->getPriceInRub() ?> RUB
                                        </span>
                                    </div>
                                </div>
                                <div class="package-descr">
                                    <div class="left">
                                        <?= $modelPromotionPackage['lang']['description'] ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        echo $form
                                ->field($modelPayment, 'amount')
                                ->label(false)
                                ->input('hidden') .
                            $form
                                ->field($modelPayment, 'user_id')
                                ->label(false)
                                ->input('hidden') .
                            $form
                                ->field($modelPayment, 'promotion_package_id')
                                ->label(false)
                                ->input('hidden') .
                            $form
                                ->field($modelPayment, 'type')
                                ->label(false)
                                ->input('hidden') .
                            $form
                                ->field($modelPayment, 'currency')
                                ->label(false)
                                ->input('hidden') .
                            Html::input(
                                'hidden',
                                'Payment[items_ids][]',
                                $model->id
                            );
                        ?>

                        <div class="buttons-cont">
                            <?= Html::submitButton(
                                Yii::t('app', 'Оплатить'),
                                ['class' => 'btn btn-success']
                            ) ?>

                            <?= Html::a(
                                Yii::t('app', 'Cancel'),
                                ['/catalog/factory-product/list'],
                                ['class' => 'btn btn-primary']
                            ) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
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
var promotion_package_id = $('input[name="PromotionPackage[id]"]:checked').val();
var amount = $('input[name="PromotionPackage[id]"]:checked').data('price');
$('input[name="Payment[amount]"]').val(amount);
$('input[name="Payment[promotion_package_id]"]').val(promotion_package_id);

$('input[name="PromotionPackage[id]"]').on('change', function () {
    var promotion_package_id = $(this).val();
    var amount = $(this).data('price');
    $('input[name="Payment[amount]"]').val(amount);
    $('input[name="Payment[promotion_package_id]"]').val(promotion_package_id);
});
// js for info tooltip
// если блок с коментарием не пустой - активизируем механизм его показа по наведению на иконку
(function() {
    // если на странице существует хоча бы один блок с коментами
    if ($('.package-comment').length > 0) {
        // проходим по всем
        $('.package-comment').each(function(i, elem) {
            // и если данный блок  не пустой
            if ($(elem).children().length > 0) {
                // показываем для него иконку
                $(elem).siblings('.package-question').addClass('isset');
            }
        });
    }
})();
JS;

$this->registerJs($script);