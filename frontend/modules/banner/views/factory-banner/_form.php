<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\banner\models\BannerItem $model
 */

$this->title = 'Banner';

?>

<main>
    <div class="page factory-profile">
        <div class="container large-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="part-contact">

                <?php $form = ActiveForm::begin([
                    //'action' => Url::toRoute(['/user/profile/update']),
                ]); ?>

                <div class="row">

                    <div class="col-sm-4 col-md-4 col-lg-4 one-row">
                        <?= $form->field($modelLang, 'title') ?>
                        <?= $form->field($modelLang, 'link') ?>
                        <?= $form->field($model, 'position') ?>
                    </div>

                </div>

                <div class="row form-group">
                    <div class="col-sm-4">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>

                        <?= Html::a(Yii::t('app', 'Cancel'), ['/banner/factory-banner/list'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</main>
