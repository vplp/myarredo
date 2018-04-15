<?php

use yii\helpers\Html;

/**
 * @var $item \frontend\modules\menu\models\MenuItem
 */

?>

<?php
echo Html::beginTag('ul', [
    'class' => 'nav navbar-nav'
]);
foreach ($items as $item):
    echo Html::tag('li', Html::a($item['lang']['title'], $item->getLink(), [
        'target' => $item->getTarget()
    ]), [
        'class' => ''
    ]);
endforeach;
echo Html::endTag('ul');