<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\user\models\Profile $model
 */

$this->title = 'Profile update';

?>

<main>
    <div class="page sign-up-page">
        <div class="container large-container">

            <div class="row">
                <?= Html::tag('h2', $this->title); ?>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">

                    <?php $form = ActiveForm::begin([
                        'action' => Url::toRoute(['/user/profile/update']),
                    ]); ?>


                    <?= $form->field($model, 'first_name') ?>
                    <?= $form->field($model, 'last_name') ?>

                    <?php \thread\widgets\HtmlForm::imageOne($model, 'avatar', ['image_url' => $model->getAvatarImage()]) ?>

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
