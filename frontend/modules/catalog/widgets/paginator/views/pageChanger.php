<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $pageArray */
/** @var $pages */

?>

<div class="this-page">

    <?php
    echo Html::beginTag('form', ['method' => 'get']);

    echo '<span class="label">' . Yii::t('app', 'Page') . '</span>';

    if ($pageArray['page'] > 1) {
        $route = $pageArray;
        $route['page'] = $route['page'] - 1;

        if ($route['page'] == 1) {
            unset($route['page']);
        }

        echo Html::a(
            '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
            Url::toRoute(['/catalog/category/list'] + $route),
            [
                'class' => 'pageChanger',
            ]
        );
    }

    echo Html::textInput('page', $pageArray['page'] ?? 1, ['class' => 'pageInput']);

    echo Yii::t('app', 'из') . ' ' . $pages->getPageCount();

    if ($pageArray['page'] < $pages->getPageCount()) {
        $route = $pageArray;
        $route['page'] = $route['page'] + 1;

        echo Html::a(
            '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
            Url::toRoute(['/catalog/category/list'] + $route),
            [
                'class' => 'pageChanger',
                'disabled' => true
            ]
        );
    }
    echo Html::endTag('form');
    ?>

</div>
