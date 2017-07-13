<?php

use yii\helpers\Html;

/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */

echo Html::beginTag('ul', [
    'class' => 'nav navbar-nav navbar-right'
]);
echo Html::tag('li', Html::a('sig in', ['/user/login/index']), [
    'class' => 'mega-menu'
]);

echo Html::endTag('ul');