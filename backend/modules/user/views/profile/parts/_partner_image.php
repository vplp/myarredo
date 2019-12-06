<?php

use backend\modules\user\models\{
    Profile, ProfileLang
};

/** @var $model Profile */
/** @var $modelLang ProfileLang */

echo $form
    ->field($model, 'image_link')
    ->label('Главное фото')
    ->imageOne($model->getImageLink('image_link'));

echo $form
    ->field($model, 'image_salon')
    ->label(Yii::t('app', 'Фото салона') . ' (1070х800 px)')
    ->imageOne($model->getImageLink('image_salon'));

echo $form
    ->field($model, 'image_salon2')
    ->label(Yii::t('app', 'Фото салона') . ' (1070х800 px)')
    ->imageOne($model->getImageLink('image_salon2'));
