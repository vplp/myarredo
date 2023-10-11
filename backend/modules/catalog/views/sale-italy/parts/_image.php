<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang
};

/**
 * @var $form ActiveForm
 * @var $model ItalianProduct
 * @var $modelLang ItalianProductLang
 */

echo $form->field($model, 'image_link')->imageOne($model->getImageLink());

echo $form->field($model, 'gallery_image')->imageSeveral(['initialPreview' => $model->getGalleryImage()]);

echo $form->field($model, 'file_link')->fileInputWidget(
    $model->getFileLink(),
    ['accept' => '.jpeg,.png,.doc,.docx,.xlsx,application/pdf', 'maxFileSize' => 0]
);
