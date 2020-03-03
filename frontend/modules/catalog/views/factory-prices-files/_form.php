<?php

use yii\helpers\{
    Html, Url
};
use backend\app\bootstrap\ActiveForm;
use frontend\modules\catalog\models\FactoryCatalogsFiles;

/**
 * @var $model FactoryCatalogsFiles
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
                            ? Url::toRoute(['/catalog/factory-prices-files/create'])
                            : Url::toRoute(['/catalog/factory-prices-files/update', 'id' => $model->id]),
                    ]);
                    ?>

                    <?= Html::activeHiddenInput($model, 'factory_id', ['value' => Yii::$app->user->identity->profile->factory_id]) ?>

                    <?= $form->field($model, 'file_link')->fileInputWidget(
                        $model->getFileLink()
                    ) ?>

                    <?= $form->field($model, 'title') ?>

                    <div class="buttons-cont">
                        <?= Html::submitButton(
                            Yii::t('app', 'Save'),
                            ['class' => 'btn btn-goods']
                        ) ?>

                        <?= Html::a(
                            Yii::t('app', 'Вернуться к списку'),
                            ['/catalog/factory-prices-files/list'],
                            ['class' => 'btn btn-cancel']
                        ) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</main>
