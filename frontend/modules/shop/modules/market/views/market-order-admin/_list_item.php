<?php

use yii\helpers\{ArrayHelper, Html, Url};
use yii\widgets\ActiveForm;
use frontend\modules\shop\modules\market\models\MarketOrder;

/* @var $this yii\web\View */
/* @var $model MarketOrder */

?>

<?php $form = ActiveForm::begin([
    'options' => ['data' => ['pjax' => true]],
    'action' => Url::toRoute(['/shop/market/market-order-admin/update', 'id' => $model->id])
]); ?>

<div class="hidden-order-in ordersanswer-box">
    <div class="form-wrap">
        <div class="form-group">
            <?= $form
                ->field($model, 'comment')
                ->textarea(['rows' => 5, 'disabled' => true]) ?>

            <div class="row control-group">
                <div class="col-md-6">
                    <?= $form
                        ->field($model, 'cost')
                        ->textInput(['disabled' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form
                        ->field($model, 'currency')
                        ->dropDownList($model::currencyRange(), ['disabled' => true])
                        ->label('&nbsp;') ?>
                </div>
            </div>

            <div><?= Yii::t('market', 'Ответы салонов') ?>:</div>

            <?php
            $items = ArrayHelper::map($model->answers, 'id', function ($answer) {
                return ($answer['user']['profile']['lang']
                        ? $answer['user']['profile']['lang']['name_company']
                        : '') .
                    ' = ' . $answer['commission_percentage'] . ' %';
            });

            echo $form
                ->field($model, 'winner_id')
                ->label($model->getAttributeLabel('winner_id'))
                ->radioList(
                    $items,
                    [
                        'item' => function ($index, $label, $name, $checked, $value) {
                            return
                                '<div><label class="">' .
                                Html::radio($name, $checked, [
                                    'value' => $value,
                                ]) . '&nbsp;' .
                                $label .
                                '<span class=""></span>' .
                                '</label></div>';
                        },
                    ]
                ); ?>

            <div class="form-group">
                <?= Html::submitButton(
                    Yii::t('app', 'Save'),
                    [
                        'class' => 'btn btn-success',
                    ]
                ) ?>
            </div>

        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>
