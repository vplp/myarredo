<?php

namespace thread\modules\shop;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\shop\components\Cart;

/**
 * Class Shop
 *
 * @package thread\modules\shop
 */
class Shop extends aModule
{
    public $Cart = Cart::class;
    public $name = 'shop';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    /**
     * @return null|object
     */
    public static function getDb()
    {
        return Yii::$app->get('db-core');
    }
}