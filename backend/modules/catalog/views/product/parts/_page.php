<?php

/**
 * @var \backend\modules\catalog\models\Product $model
 * @var \backend\modules\catalog\models\ProductLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

?>

<?= $form->text_editor_lang($modelLang, 'description') ?>
<?= $form->text_editor_lang($modelLang, 'comment') ?>
