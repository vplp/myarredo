<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
use frontend\modules\shop\modules\market\models\{
    MarketOrder, MarketOrderAnswer
};

/* @var $this yii\web\View */
/* @var $model MarketOrder */
/* @var $modelAnswer MarketOrderAnswer */

?>

<?php $form = ActiveForm::begin([
    'options' => ['data' => ['pjax' => true]],
    'action' => Url::toRoute(['/shop/market/market-order-partner/update', 'id' => $model->id])
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

            <div class="form-group">
                <div><?= Yii::t('market', 'Ответы других салонов') ?>:</div>

                <?php foreach ($model->answers as $key => $answer) {
                    $options = ($model->winner_id == $answer['user']->id) ? ['style' => 'color:red;'] : [];

                    if ($answer['user']->id == Yii::$app->user->id) {
                        echo Html::tag(
                            'div',
                            ($answer['user']['profile']['lang']
                                ? $answer['user']['profile']['lang']['name_company']
                                : '') .
                            ' = ' . $answer['commission_percentage'] . ' %',
                            $options
                        );
                    } else {
                        echo Html::tag(
                            'div',
                            Yii::t('app', 'Partner') . ($key + 1) . ' = ' . $answer['commission_percentage'] . ' %',
                            $options
                        );
                    }
                } ?>
            </div>

            <div class="row control-group">
                <div class="col-md-6">
                    <?= $form
                        ->field($modelAnswer, 'commission_percentage')
                        ->textInput(['disabled' => (!$model->winner_id ? false : true)])
                        ->label(Yii::t('market', 'Готов предоставить процент комиссии, %')) ?>
                </div>
            </div>


            <?php if (!$model->winner_id) { ?>
                <div class="form-group">
                    <?= Html::submitButton(
                        Yii::t('app', 'Save'),
                        [
                            'class' => 'btn btn-success',
                        ]
                    ) ?>
                </div>
            <?php } ?>

        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>
