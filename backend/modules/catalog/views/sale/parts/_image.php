<?php

/**
 * @var \backend\modules\catalog\models\Sale $model
 * @var \backend\app\bootstrap\ActiveForm $form
 */

?>

<?= $form->field($model, 'image_link')->imageOne($model->getImageLink()) ?>

<?= $form->field($model, 'gallery_image')->imageSeveral(['initialPreview' => $model->getGalleryImage()]) ?>
