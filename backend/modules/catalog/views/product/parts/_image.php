<?php

/**
 * @var \backend\app\bootstrap\ActiveForm $form
 * @var \backend\modules\catalog\models\Product $model
 */

?>

<?= $form->field($model, 'image_link')->imageOne($model->getImageLink()) ?>

<?= $form->field($model, 'gallery_image')->imageSeveral(['initialPreview' => $model->getGalleryImage()]) ?>
