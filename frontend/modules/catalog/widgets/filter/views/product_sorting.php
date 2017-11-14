<?php

use yii\helpers\Html;

?>

<div class="location-buts flex">
    <a href="javascript:void(0);" data-style="small" class="tiles4 flex active">
        <i></i><i></i><i></i><i></i>
        <i></i><i></i><i></i><i></i>
    </a>
    <a href="javascript:void(0);" data-style="large" class="tiles2 flex">
        <i></i><i></i>
    </a>
</div>

<div class="dropdown sort-by">
    <span class="sort-by-name">Сортировать по цене:</span>
    <ul class="dropdown-menu">
        <?php foreach ($sortList as $key => $item): ?>
            <li><a href="<?= ($key != 'null') ? $url . '?sort=' . $key : $url; ?>"><?= $item ?></a></li>
        <?php endforeach; ?>
    </ul>
    <button class="btn dropdown-toggle selected" type="button" data-toggle="dropdown">
        <?= isset($sortList[Yii::$app->getRequest()->get('sort')]) ?  $sortList[Yii::$app->getRequest()->get('sort')] : $sortList['null']?>
    </button>
</div>

<div class="dropdown sort-by">
    <span class="sort-by-name">Показать:</span>
    <ul class="dropdown-menu">
        <?php foreach ($objectList as $key => $item): ?>
            <li><a href="<?= ($key != 'null') ? $url . '?object=' . $key : $url; ?>"><?= $item ?></a></li>
        <?php endforeach; ?>
    </ul>
    <button class="btn dropdown-toggle selected" type="button" data-toggle="dropdown">
        <?= isset($objectList[Yii::$app->getRequest()->get('object')]) ?  $objectList[Yii::$app->getRequest()->get('object')] : $objectList['null']?>
    </button>
</div>
