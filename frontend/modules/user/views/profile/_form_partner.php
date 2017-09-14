<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\user\models\Profile $model
 */

$this->title = 'Редактировать профиль';

?>

<main>
    <div class="page factory-profile">
        <div class="container large-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="part-contact">

                <?php $form = ActiveForm::begin([
                    'action' => Url::toRoute(['/user/profile/update']),
                ]); ?>

                <div class="row">

                    <div class="col-sm-4 col-md-4 col-lg-4 one-row">
                        <?= $form->field($model, 'first_name') ?>
                        <?= $form->field($model, 'last_name') ?>
                    </div>

                    <div class="col-sm-4 col-md-4 col-lg-4 one-row">
                        <?= $form->field($model, 'name_company') ?>
                        <?= $form->field($model, 'address') ?>
                    </div>

                    <div class="col-sm-4 col-md-4 col-lg-4 one-row">
                        <?= $form->field($model, 'phone') ?>
                        <?= $form->field($model, 'website') ?>
                    </div>

                </div>

                <?php //\thread\widgets\HtmlForm::imageOne($model, 'avatar', ['image_url' => $model->getAvatarImage()]) ?>

                <div class="row form-group">
                    <div class="col-sm-4">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>

                        <?= Html::a(Yii::t('app', 'Cancel'), ['/user/profile/index'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</main>
