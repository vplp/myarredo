<?php

use yii\helpers\Html;

?>

<div class="dropdown sort-by">
    <span class="sort-by-name"><?= Yii::t('app', 'Сортировать по цене') ?>:</span>
    <ul class="dropdown-menu">
        <?php foreach ($sortList as $key => $item) { ?>
            <li>
                <?= Html::a(
                    $item,
                    ($key != 'null') ? $url . '?sort=' . $key : $url,
                    []
                ) ?>
            </li>
        <?php } ?>
    </ul>
    <button class="btn dropdown-toggle selected" type="button" data-toggle="dropdown">
        <?= isset($sortList[Yii::$app->getRequest()->get('sort')]) ? $sortList[Yii::$app->getRequest()->get('sort')] : $sortList['null'] ?>
    </button>
</div>

<div class="dropdown sort-by">
    <span class="sort-by-name"><?= Yii::t('app', 'Показать') ?>:</span>
    <ul class="dropdown-menu">
        <?php foreach ($objectList as $key => $item) { ?>
            <li><a href="<?= ($key != 'null') ? $url . '?object=' . $key : $url; ?>"><?= $item ?></a></li>
        <?php } ?>
    </ul>
    <button class="btn dropdown-toggle selected" type="button" data-toggle="dropdown">
        <?= isset($objectList[Yii::$app->getRequest()->get('object')]) ? $objectList[Yii::$app->getRequest()->get('object')] : $objectList['null'] ?>
    </button>
</div>
