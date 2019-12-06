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
