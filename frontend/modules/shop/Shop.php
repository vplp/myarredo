<?php

namespace frontend\modules\shop;


/**
 * Class Shop
 *
 * @package frontend\modules\shop
 * @author Alla Kuzmenko
 * @copyright (c), Thread
 */
class Shop extends \common\modules\shop\Shop
{
    

    public $translationsFileMap = [
        'shop' => [
            'class' => \yii\i18n\PhpMessageSource::class,
            'basePath' => '@fro
            ntend/modules/shop/messages',
            'fileMap' => [
                'name' => ['app.php', 'cart.php'],
            ],
        ]
    ];

}
