<?php
use yii\helpers\Html;

echo Html::beginTag('ul', [
    'class' => 'nav navbar-nav navbar-right'
]);
foreach ($items as $item):
    echo Html::tag('li', Html::a($item['lang']['title'], $item->getLink(), [
        'target' => $item->getTarget()
    ]), [
        'class' => 'mega-menu'
    ]);
endforeach;
echo Html::endTag('ul');