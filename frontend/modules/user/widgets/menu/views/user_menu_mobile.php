<?php

echo \yii\widgets\Menu::widget([
    'items' => $menuItems,
    'options' => [
        'class' => 'menu-list'
    ]
]);
