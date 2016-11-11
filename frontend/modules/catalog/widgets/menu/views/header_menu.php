<?php

use yii\helpers\Html;

/**
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */

echo Html::beginTag('ul', ['class' => $addClass]);
foreach ($items as $item):
    echo Html::beginTag('li');
    echo Html::a($item['lang']['title'], $item->getUrl(), ['class' => '']);
    echo Html::endTag('li');
endforeach;
echo Html::beginTag('li');
echo Html::a('Акции', '#', ['class' => '']);
echo Html::endTag('li');
echo Html::endTag('ul');




