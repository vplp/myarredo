<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\banner\models\{
    BannerItemFactory, BannerItemLang
};

/**
 * @var $model BannerItemFactory
 * @var $modelLang BannerItemLang
 * @var $form ActiveForm
 */

echo $form->field($model, 'image_link')->imageOne($model->getImageLink());
