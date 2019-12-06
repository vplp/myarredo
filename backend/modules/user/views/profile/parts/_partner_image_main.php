<?php

use backend\modules\user\models\{
    Profile, ProfileLang
};

/** @var $model Profile */
/** @var $modelLang ProfileLang */

echo $form
    ->field($model, 'image_link')
    ->label(Yii::t('app', 'Главное фото') . ' (1070х800 px)')
    ->imageOne($model->getImageLink('image_link'));
