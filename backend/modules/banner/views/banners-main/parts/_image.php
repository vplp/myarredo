<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\banner\models\{
    BannerItemMain, BannerItemLang
};

/**
 * @var $model BannerItemMain
 * @var $modelLang BannerItemLang
 * @var $form ActiveForm
 */

echo $form
    ->field($model, 'image_link')
    ->imageOne($model->getImageLink())
    ->label(Yii::t('app', 'Image link') . ' 1650х580px');
