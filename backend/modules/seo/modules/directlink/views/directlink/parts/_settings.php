<?php

use common\modules\seo\modules\directlink\models\Directlink;
use yii\helpers\{
    Url, Html, ArrayHelper
};
?>

<?= $form->text_line($model, 'url') ?>
<?= $form->text_line($modelLang, 'title') ?>
<?= $form->field($modelLang, 'description')->textarea(['rows' => '5']); ?>
<?= $form->text_line($modelLang, 'keywords') ?>

<?= $form->text_line($model, 'image_url') ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'meta_robots')->dropDownList(Directlink::statusMetaRobotsRange()) ?>
        </div>
    </div>

    <div class="row control-group">
        <div class="col-md-3">
            <?= $form
                ->field($model, 'created_at')
                ->textInput(['disabled' => true, 'value' => date('d.m.Y H:i', $model->created_at)]) ?>
        </div>
        <div class="col-md-3">
            <?= $form
                ->field($model, 'updated_at')
                ->textInput(['disabled' => true, 'value' => date('d.m.Y H:i', $model->updated_at)]) ?>
        </div>
    </div>

<?= $form->switcher($model, 'published') ?>
