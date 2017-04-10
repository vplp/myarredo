<?php
use yii\helpers\Html;

echo Html::beginTag('nav') . Html::beginTag('ul', [
        'class' => 'nav nav-pills nav-stacked'
    ]);
foreach ($items as $item):
    echo Html::tag('li', Html::a($item['lang']['title'], $item->getLink(), [
        'target' => $item->getTarget()
    ]));
endforeach;
echo Html::endTag('ul') . Html::endTag('nav');