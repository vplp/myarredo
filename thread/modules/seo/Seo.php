<?php

namespace thread\modules\seo;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Seo
 *
 * @package thread\modules\seo
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class Seo extends aModule
{
    public $name = 'seo';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    /**
     * Sitemap objects
     * @var array
     */
    public $objects = [];

    /**
     * Sitemap secret key
     * @var string
     */
    public $secretKey = 'thread';

    /**
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db-core');
    }
   
}
