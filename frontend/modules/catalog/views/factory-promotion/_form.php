<?php

//use backend\themes\defaults\widgets\forms\ActiveForm;
use yii\widgets\ActiveForm;
//use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
//
use frontend\modules\catalog\models\{
    Category, Factory, Types, Specification, Collection
};
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\catalog\models\{
    FactoryPromotion
};
use backend\modules\catalog\widgets\grid\ManyToManySpecificationValueDataColumn;
//
use backend\themes\defaults\widgets\TreeGrid;

/**
 * @var \frontend\modules\catalog\models\FactoryPromotion $model
 */

$this->title = Yii::t('app', 'Рекламировать');

?>

<main>
    <div class="page create-sale">
        <div class="container large-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="column-center">
                <div class="form-horizontal">

                    <?php $form = ActiveForm::begin([
                        'action' => ($model->isNewRecord)
                            ? Url::toRoute(['/catalog/factory-promotion/create'])
                            : Url::toRoute(['/catalog/factory-promotion/update', 'id' => $model->id]),
                    ]); ?>

                    <?= $form
                        ->field($model, 'count_of_months')
                        //->radioList(FactoryPromotion::getCountOfMonthsRange(), [])
                        ->radioList(
                            FactoryPromotion::getCountOfMonthsRange(),
                            [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return
                                        '<div class="radio-e">' .
                                        Html::radio($name, $checked, ['value' => $value]) .
                                        Html::label('<span></span>' . $label) .
                                        '</div>';
                                },
                            ]
                        )
                    ?>

                    <?= $form
                        ->field($model, 'daily_budget')
                        //->radioList(FactoryPromotion::getDailyBudgetRange(), [])
                        ->radioList(
                            FactoryPromotion::getDailyBudgetRange(),
                            [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return
                                        '<div class="radio-e">' .
                                        Html::radio($name, $checked, ['value' => $value]) .
                                        Html::label('<span></span>' . $label) .
                                        '</div>';
                                },
                            ]
                        )
                    ?>

                    <?= $form->field($model, 'cost') ?>

                    <div class="buttons-cont">
                        <?= Html::submitButton(
                            Yii::t('app', 'Save'),
                            ['class' => 'btn btn-goods']
                        ) ?>

                        <?= Html::a(
                            Yii::t('app', 'Вернуться к списку'),
                            ['/catalog/factory-promotion/list'],
                            ['class' => 'btn btn-cancel']
                        ) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</main>