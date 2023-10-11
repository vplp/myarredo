<?php

use yii\helpers\{
    Html, Url
};
use backend\app\bootstrap\ActiveForm;
use frontend\modules\catalog\models\Collection;

/**
 * @var $model Collection
 */

$this->title = ($model->isNewRecord)
    ? Yii::t('app', 'Add')
    : Yii::t('app', 'Edit');

?>

<main>
    <div class="page create-sale factory-product">
        <div class="container large-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="column-center">
                <div class="form-horizontal">

                    <?php
                    $form = ActiveForm::begin([
                        'action' => ($model->isNewRecord)
                            ? Url::toRoute(['/catalog/factory-collections/create'])
                            : Url::toRoute(['/catalog/factory-collections/update', 'id' => $model->id]),
                    ]);
                    ?>

                    <?= $form
                        ->field($model, 'factory_id')
                        ->input('hidden')
                        ->label(false) ?>

                    <?= $form
                        ->field($model, 'first_letter')
                        ->input('hidden')
                        ->label(false) ?>

                    <?= $form->field($model, 'title') ?>

                    <?= $form->field($model, 'year') ?>

                    <div class="buttons-cont">
                        <?= Html::submitButton(
                            Yii::t('app', 'Save'),
                            ['class' => 'btn btn-goods']
                        ) ?>

                        <?= Html::a(
                            Yii::t('app', 'Вернуться к списку'),
                            ['/catalog/factory-collections/list'],
                            ['class' => 'btn btn-cancel']
                        ) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</main>
