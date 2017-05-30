<?php
use thread\app\bootstrap\ActiveForm;
use common\modules\seo\modules\directlink\models\Directlink;

?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line($model, 'url') ?>
<?= $form->text_line_lang($model, 'title') ?>
<?= $form->text_line_lang($model, 'description') ?>
<?= $form->text_line_lang($model, 'keywords') ?>

<?= $form->text_line($model, 'image_url') ?>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'meta_robots')->dropDownList(Directlink::statusMetaRobotsRange()) ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'add_to_sitemap') ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'dissallow_in_robotstxt') ?>
    </div>
</div>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
