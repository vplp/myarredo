<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Composition, CompositionLang
};

/**
 * @var $form ActiveForm
 * @var $model Composition
 * @var $modelLang CompositionLang
 */

echo $form->field($model, 'image_link')->imageOne($model->getImageLink());

echo $form->field($model, 'gallery_image')->imageSeveral(['initialPreview' => $model->getGalleryImage()]);
