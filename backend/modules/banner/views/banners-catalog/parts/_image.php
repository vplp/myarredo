<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\banner\models\{
    BannerItemCatalog, BannerItemLang
};

/**
 * @var $model BannerItemCatalog
 * @var $modelLang BannerItemLang
 * @var $form ActiveForm
 */

echo $form->field($model, 'image_link')->imageOne($model->getImageLink());
