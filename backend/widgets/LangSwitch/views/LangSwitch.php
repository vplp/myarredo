<?php
use yii\bootstrap\Nav;

/**
 * @var \backend\widgets\LangSwitch\LangSwitch $current
 * @var \thread\app\model\Language $models
 */
echo Nav::widget([
    'options' => ['class' => 'nav navbar-top-links navbar-right'],
    'items' => [
        [
            'label' => $current,
            'items' => $models,
        ],
    ],
]);
