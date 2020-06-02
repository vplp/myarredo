<?php

use yii\helpers\Html;
use frontend\modules\menu\models\MenuItem;

/**
 * @var $item MenuItem
 */

echo Html::beginTag('ul', ['class' => 'nav navbar-nav']);

foreach ($items as $item) {
    echo Html::tag('li', Html::a(
        $item['lang']['title'],
        $item->getLink(),
        ['target' => $item->getTarget()]
    ));
}

echo Html::endTag('ul');
