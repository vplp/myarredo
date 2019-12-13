<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\banner\models\{
    BannerItemBackground, BannerItemLang
};

/**
 * @var $model BannerItemBackground
 * @var $modelLang BannerItemLang
 * @var $form ActiveForm
 */

echo $form->field($model, 'image_link')->imageOne($model->getImageLink());
