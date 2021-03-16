<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\shop\models\FormFindProduct;

/** @var $model FormFindProduct */

echo Html::a(
    Yii::t('app', 'Не нашли то что искали? Оставьте заявку тут'),
    'javascript:void(0);',
    [
        'class' => 'btn btn-showmore btn-request-find-product',
        'data-url' => Url::toRoute('/shop/cart/ajax-get-request-find-product'),
    ]
);
