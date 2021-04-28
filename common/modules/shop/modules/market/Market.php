<?php

namespace  common\modules\shop\modules\market;

use common\modules\shop\Shop;
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Market
 *
 * @package common\modules\shop\modules\market
 */
class Market extends aModule
{
    public $name = 'shop';
    public $configPath = __DIR__ . '/config.php';
    public $translationsBasePath = __DIR__ . '/messages';

    /**
     * @return object|string|null
     */
    public static function getDb()
    {
        return Shop::getDb();
    }
}
