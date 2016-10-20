<?php

namespace thread\modules\shop;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Shop
 *
 * @package thread\modules\shop
 * @author Alla Kuzmenko
 * @copyright (c), Thread
 */
class Shop extends aModule
{
    public $name = 'shop';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    /**
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db-core');
    }

    /**
     * @return mixed
     */
    public static function getFormatDate()
    {
        return Yii::$app->getModule('shop')->params['format']['date'];
    }

}
