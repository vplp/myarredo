<?php

namespace thread\modules\page;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Page
 *
 * @package thread\modules\page
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class Page extends aModule
{

    public $name = 'Page';
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
     * getImageBasePath
     *
     * @return string
     */
    public function getImageBasePath()
    {
        return Yii::getAlias('@uploads') . '/page';
    }

}
