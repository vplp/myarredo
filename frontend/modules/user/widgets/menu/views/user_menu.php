<?php

use yii\widgets\Menu;

/** @var $menuItems */

?>

<ul class="nav navbar-nav navbar-right">
    <li>
        <div class="my-notebook dropdown">
            <span class="red-but notebook-but dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars" aria-hidden="true"></i>
                <?= Yii::t('app', 'Menu') ?>
                <object>

                    <?= Menu::widget([
                        'items' => $menuItems,
                        'options' => [
                            'class' => 'dropdown-menu'
                        ]
                    ]) ?>

                </object>
            </span>
        </div>
    </li>
</ul>