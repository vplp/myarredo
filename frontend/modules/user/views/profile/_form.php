<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
//
use frontend\modules\location\models\{
    Country, City
};

/**
 * @var \frontend\modules\user\models\Profile $model
 */

$this->title = Yii::t('app', 'Profile');

?>

<main>
    <div class="page factory-profile">
        <div class="largex-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="part-contact part-contact-update">

                <?php $form = ActiveForm::begin([
                    'action' => Url::toRoute(['/user/profile/update']),
                    'options' => ['class' => 'user-update-form']
                ]); ?>

                <div class="row">

                    <div class="col-md-4 col-lg-4 one-row">
                        <?= $form->field($model, 'first_name') ?>
                        <?= $form->field($model, 'last_name') ?>
                        <?= $form->field($model, 'phone')
                            ->widget(\yii\widgets\MaskedInput::className(), [
                                'mask' => Yii::$app->city->getPhoneMask(),
                                'clientOptions' => [
                                    'clearIncomplete' => true
                                ]
                            ]) ?>
                    </div>

                    <?php
                    /**
                     * for factory
                     */
                    if (Yii::$app->user->identity->group->role == 'factory') { ?>
                        <div class="col-md-4 col-lg-4 one-row">
                            <?= $form->field($model, 'email_company') ?>
                            <?= $form->field($model, 'address') ?>
                            <?= $form->field($model, 'website') ?>
                        </div>
                    <?php } ?>

                    <?php
                    /**
                     * for partner
                     */
                    if (Yii::$app->user->identity->group->role == 'partner') { ?>
                        <div class="col-md-4 col-lg-4 one-row">
                            <?= $form->field($model, 'name_company') ?>
                            <?= $form->field($model, 'website') ?>
                        </div>

                        <div class="col-md-4 col-lg-4 one-row">
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
