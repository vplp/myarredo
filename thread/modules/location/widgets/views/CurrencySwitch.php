<?php

use yii\bootstrap\Nav;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-left'],
    'items' => [
        [
            'label' => $current->title,
            'items' => $items,
        ],
    ],
]);
