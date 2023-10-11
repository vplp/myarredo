<?php
use thread\app\bootstrap\{
    ActiveForm
};

use thread\modules\seo\modules\modellink\models\Modellink;

/**
 * @var ActiveForm $form
 */

?>
<?= $form->field($model, 'model_key')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'model_id')->hiddenInput()->label(false) ?>
<?= $form->text_line_lang($model, 'title') ?>
<?= $form->text_line_lang($model, 'description') ?>
<?= $form->text_line_lang($model, 'keywords') ?>

<?= $form->text_line($model, 'image_url') ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'meta_robots')->dropDownList(Modellink::statusMetaRobotsRange()) ?>
        </div>
        <div class="col-md-3">
            <?= $form->switcher($model, 'add_to_sitemap') ?>
        </div>
        <div class="col-md-3">
            <?= $form->switcher($model, 'dissallow_in_robotstxt') ?>
        </div>
    </div>
<?= $form->switcher($model, 'published') ?>