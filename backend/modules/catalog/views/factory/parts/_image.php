<?php

/**
 * @var \backend\modules\catalog\models\Factory $model
 * @var \backend\modules\catalog\models\FactoryLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

?>

<?= $form->field($model, 'image_link')->imageOne($model->getImageLink()) ?>
