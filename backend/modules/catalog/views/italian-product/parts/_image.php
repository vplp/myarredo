<?php

/**
 * @var \backend\modules\catalog\models\ItalianProduct $model
 * @var \backend\app\bootstrap\ActiveForm $form
 */

echo $form->field($model, 'image_link')->imageOne($model->getImageLink());

echo $form->field($model, 'gallery_image')->imageSeveral(['initialPreview' => $model->getGalleryImage()]);
