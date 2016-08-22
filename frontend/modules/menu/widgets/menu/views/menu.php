<?php
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
$itm = [];
foreach ($items as $item):
    $itm[] = [
        'label' => $item['lang']['title'],
        'url' => $item->getLink()
    ];
endforeach;

NavBar::begin([
    'brandLabel' => 'Core CMS', // название организации
    'brandUrl' => Yii::$app->homeUrl, // ссылка на главную страницу сайта
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top', // стили главной панели
    ]
]);
echo Nav::widget([
    'items' => $itm,
    'options' => ['class' => 'navbar-nav'],
]);
NavBar::end();