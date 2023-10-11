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
                            ? Url::toRoute(['/catalog/factory-catalogs-files/create'])
                            : Url::toRoute(['/catalog/factory-catalogs-files/update', 'id' => $model->id]),
                    ]);
                    ?>

                    <?= Html::activeHiddenInput($model, 'factory_id', ['value' => Yii::$app->user->identity->profile->factory_id]) ?>

                    <div><?= Yii::t('app', 'Принимаем только файлы в формате pdf') ?></div>

                    <?= $form->field($model, 'file_link')->fileInputWidget(
                        $model->getFileLink(),
                        ['accept' => 'application/pdf', 'maxFileSize' => 0]
                    ) ?>

                    <?= $form->field($model, 'title') ?>

                    <div class="buttons-cont">
                        <?= Html::submitButton(
                            Yii::t('app', 'Save'),
                            ['class' => 'btn btn-goods']
                        ) ?>

                        <?= Html::a(
                            Yii::t('app', 'Вернуться к списку'),
                            ['/catalog/factory-catalogs-files/list'],
                            ['class' => 'btn btn-cancel']
                        ) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</main>
