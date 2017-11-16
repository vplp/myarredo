<?php

use common\modules\seo\modules\directlink\models\Directlink;

?>

<?= $form->text_line($model, 'url') ?>
<?= $form->text_line($model, 'title') ?>
<?= $form->text_line($model, 'description') ?>
<?= $form->text_line($model, 'keywords') ?>


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