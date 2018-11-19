<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\user\models\form\ChangePassword $model
 */

$this->title = Yii::t('app', 'Change password');

?>

<main>
    <div class="page factory-profile">
        <div class="largex-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="part-contact passchange-form">

                <?php $form = ActiveForm::begin([
                    'action' => Url::toRoute(['/user/password/change']),
                ]); ?>

                <div class="row">

                    <div class="col-sm-4 col-md-4 col-lg-4 one-row">

                        <?php if (!empty($model->getFlash())) { ?>
                            <div class="row">
                                <div class="col-lg-5"><?= implode(',', ($model->getFlash())) ?></div>
                            </div>

                            <?php
                            $model->password_old = '';
                            $model->password = '';
                            $model->password_confirmation = '';
                            ?>
                        <?php } ?>

                        <?= $form->field($model, 'password_old')->passwordInput() ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <?= $form->field($model, 'password_confirmation')->passwordInput() ?>
                    </div>
                </div>
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
