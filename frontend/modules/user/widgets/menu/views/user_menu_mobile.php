<?php

use yii\widgets\Menu;

/** @var $menuItems */

echo Menu::widget([
    'items' => $menuItems,
    'options' => [
        'class' => 'menu-list'
    ]
]);
