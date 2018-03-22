<?php

use common\modules\seo\modules\directlink\models\Directlink;

?>

<?= $form->text_line($model, 'url') ?>
<?= $form->text_line($modelLang, 'title') ?>
<?= $form->text_line($modelLang, 'description') ?>
<?= $form->text_line($modelLang, 'keywords') ?>

<?= $form->text_line($model, 'image_url') ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'meta_robots')->dropDownList(Directlink::statusMetaRobotsRange()) ?>
        </div>
    </div>
<?= $form->switcher($model, 'published') ?>