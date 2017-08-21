<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\user\models\form\ChangePassword $model
 */

$this->title = 'ChangePassword';

?>

<main>
    <div class="page sign-up-page">
        <div class="container large-container">

            <div class="row">
                <?= Html::tag('h2', $this->title); ?>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">

                    <?php $form = ActiveForm::begin([
                        'action' => Url::toRoute(['/user/password/change']),
                    ]); ?>

                    <?php if (!empty($model->getFlash())) : ?>

                        <div class="row">
                            <div class="col-lg-5"><?= implode(',', ($model->getFlash())) ?></div>
                        </div>

                        <?php
                        $model->password_old = '';
                        $model->password = '';
                        $model->password_confirmation = '';
                        ?>

                    <?php endif; ?>

                    <?= $form->field($model, 'password_old')->passwordInput() ?>
                    <hr/>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'password_confirmation')->passwordInput() ?>

                    <div class="row form-group">
                        <div class="col-sm-4">
                            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>
                        <div class="col-sm-8">
                            <?= Html::a(Yii::t('app', 'Cancel'), ['/user/profile/index'], ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
                <div class="col-xs-12 col-sm-6 col-lg-offset-2 col-sm-6 col-md-6 col-lg-5">

                </div>
            </div>

        </div>
    </div>
</main>
