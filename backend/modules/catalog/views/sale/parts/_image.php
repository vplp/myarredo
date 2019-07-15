<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Sale, SaleLang
};

/**
 * @var $form ActiveForm
 * @var $model Sale $model
 * @var $modelLang SaleLang
 */

echo $form->field($model, 'image_link')->imageOne($model->getImageLink());

echo $form->field($model, 'gallery_image')->imageSeveral(['initialPreview' => $model->getGalleryImage()]);
