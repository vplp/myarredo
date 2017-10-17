<?php

/**
 * @var \backend\modules\catalog\models\Category $model
 * @var \backend\modules\catalog\models\CategoryLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

?>

<?= $form->field($model, 'image_link')->imageOne($model->getImageLink()) ?>
