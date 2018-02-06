<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\user\models\Profile $model
 */

$this->title = Yii::t('app', 'Profile');

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
                        <?= $form->field($model, 'phone')
                            ->widget(\yii\widgets\MaskedInput::className(), [
                                'mask' => '79999999999',
                                'clientOptions' => [
                                    'clearIncomplete' => true
                                ]
                            ]) ?>
                        <?php if (Yii::$app->getUser()->getIdentity()->group->role == 'factory') { ?>
                            <?= $form->field($model, 'email_company') ?>
                        <?php } ?>
                    </div>

                    <?php if (Yii::$app->getUser()->getIdentity()->group->role == 'partner') { ?>
                        <div class="col-sm-4 col-md-4 col-lg-4 one-row">
                            <?= $form->field($model, 'name_company') ?>
                            <?= $form->field($model, 'website') ?>
                        </div>

                        <div class="col-sm-4 col-md-4 col-lg-4 one-row">
                            <?= $form->field($model, 'country_id')
                                ->dropDownList(
                                    [null => '--'] + Country::dropDownList(),
                                    ['class' => 'selectpicker']
                                ); ?>

                            <?= $form->field($model, 'city_id')
                                ->dropDownList(
                                    [null => '--'] + City::dropDownList($model->country_id),
                                    ['class' => 'selectpicker']
                                ); ?>

                            <?= $form->field($model, 'address') ?>
                        </div>

                    <?php } ?>


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
