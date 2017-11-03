<?php

use yii\helpers\Html;

/**
 * @var $item \frontend\modules\menu\models\MenuItem
 */

?>

<?= Html::beginTag('ul', ['class' => 'nav navbar-nav']); ?>

<?php foreach ($items as $item): ?>
    <?= Html::tag('li', Html::a($item['lang']['title'], $item->getLink(), ['target' => $item->getTarget()])); ?>
<?php endforeach; ?>

<?= Html::endTag('ul'); ?>