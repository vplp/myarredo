<?php

namespace thread\modules\seo;

use thread\app\base\module\abstracts\Module as aModule;
use Yii;

/**
 * Class Page
 *
 * @package thread\modules\page
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class Seo extends aModule
{

    public $name = 'Seo';
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

    public static function getDb()
    {
        return Yii::$app->get('db-core');
    }
    /**
     * @return string
     */
    public function getImageBasePath()
    {
        return Yii::getAlias('@uploads') . '/seo';
    }
}
