<?php

/**
 * @var \backend\modules\catalog\models\ItalianProduct $model
 * @var \backend\app\bootstrap\ActiveForm $form
 */

echo $form->field($model, 'image_link')->imageOne($model->getImageLink());

echo $form->field($model, 'gallery_image')->imageSeveral(['initialPreview' => $model->getGalleryImage()]);

echo $form->field($model, 'file_link')->fileInputWidget(
    $model->getFileLink(),
    ['accept' => '.jpeg,.png,.doc,.docx,.xlsx,application/pdf', 'maxFileSize' => 0],
    ['jpeg', 'png', 'pdf', 'doc', 'docx', 'xlsx']
);
