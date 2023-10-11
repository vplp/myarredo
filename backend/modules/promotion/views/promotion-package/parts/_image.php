<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\promotion\models\{
    PromotionPackage, PromotionPackageLang
};

/**
 * @var ActiveForm $form
 * @var PromotionPackage $model
 * @var PromotionPackageLang $modelLang
 */

echo $form
    ->field($model, 'image_link')
    ->imageOne($model->getImageLink());
