<?php

use kartik\widgets\Select2;
use yii\helpers\{ArrayHelper, Html, Url};
use backend\app\bootstrap\ActiveForm;
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\user\models\User;
use frontend\modules\shop\modules\market\models\MarketOrder;

/** @var $model MarketOrder */

$this->title = $this->context->title;
?>
<main>
    <div class="page adding-product-page">
        <div class="largex-container">

            <?= Html::tag('h1', $this->context->title); ?>

            <div class="container large-container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4">

                        <?php $form = ActiveForm::begin([
                            'action' => ($model->isNewRecord)
                                ? Url::toRoute(['/shop/market/market-order-admin/create'])
                                : Url::toRoute(['/shop/market/market-order-admin/update', 'id' => $model->id]),

                        ]); ?>

                        <div class="row control-group">
                            <div class="col-md-6">
                                <?= $form->field($model, 'full_name') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'email') ?>
                            </div>
                        </div>

                        <div class="row control-group">
                            <div class="col-md-6">
                                <?= $form
                                    ->field($model, 'country_id')
                                    ->dropDownList(
                                        [null => '--'] + Country::dropDownList()
                                    ) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form
                                    ->field($model, 'city_id')
                                    ->dropDownList(
                                        [null => '--'] + City::dropDownList($model->country_id)
                                    ) ?>
                            </div>
                        </div>

                        <?= $form->field($model, 'comment')->textarea(['rows' => 5]) ?>

                        <div class="row control-group">
                            <div class="col-md-6">
                                <?= $form->field($model, 'cost') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form
                                    ->field($model, 'currency')
                                    ->dropDownList($model::currencyRange())
                                    ->label('&nbsp;') ?>
                            </div>
                        </div>


                        <?= $form
                            ->field($model, 'partner_ids')
                            ->widget(Select2::class, [
                                'data' => User::dropDownListPartner(),
                                'options' => [
                                    'placeholder' => Yii::t('app', 'Select option'),
                                    'multiple' => true
                                ],
                            ]) ?>

                        <div class="buttons-cont">
                            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                            <?= Html::a(
                                Yii::t('app', 'Вернуться к списку'),
                                ['/shop/market/market-order-admin/list'],
                                ['class' => 'btn btn-primary']
                            ) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                        <br>

                    </div>
                </div>
            </div>

        </div>
    </div>
</main>


<?php
$url = Url::toRoute(['/location/location/get-cities']);
$script = <<<JS
$('select#marketorder-country_id').change(function(){
    var country_id = parseInt($(this).val());
    $.post('$url', {_csrf: $('#token').val(),country_id:country_id}, function(data){
        var select = $('select#marketorder-city_id');
        select.html(data.options);
        select.selectpicker("refresh");
    });
});
JS;

$this->registerJs($script);
?>
