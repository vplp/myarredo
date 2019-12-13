<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\banner\models\{
    BannerItem, BannerItemLang
};

/**
 * @var $model BannerItem
 * @var $modelLang BannerItemLang
 * @var $form ActiveForm
 */

echo $form
    ->field($model, 'image_link')
    ->imageOne($model->getImageLink())
    ->label(Yii::t('app', 'Image link') . ' 1650х580px');
