<?php

use backend\app\bootstrap\ActiveForm;
use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\banner\models\BannerItem $model
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page factory-profile">
        <div class="container large-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="part-contact">

                <?php $form = ActiveForm::begin([]); ?>

                <div class="row">

                    <div class="col-sm-4 col-md-4 col-lg-4 one-row">

                        <?php if ($model->isNewRecord) { ?>
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                <?= Yii::t('app', 'Для загрузки изображений - сначала создайте') ?>
                            </div>
                        <?php } else { ?>
                            <?= $form->field($model, 'image_link')->imageOne($model->getImageLink()) ?>
                        <?php } ?>

                        <?= $form->field($modelLang, 'title') ?>

                        <?= $form->field($modelLang, 'link') ?>

                        <?= $form->field($model, 'position') ?>

                        <?= $form->switcher($model, 'published') ?>

                        <?= $form->field($model, 'user_id')
                            ->hiddenInput(['value' => Yii::$app->user->identity->id])
                            ->label(false); ?>

                        <?= $form->field($model, 'factory_id')
                            ->hiddenInput(['value' => Yii::$app->user->identity->profile->factory_id])
                            ->label(false); ?>

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
