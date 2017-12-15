<?php

/**
 * @var \backend\modules\banner\models\BannerItem $model
 * @var \backend\modules\banner\models\BannerItemLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

?>

<?= $form->field($model, 'image_link')->imageOne($model->getImageLink()) ?>
