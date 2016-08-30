<?php

namespace thread\modules\polls;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Polls
 *
 * @package thread\modules\polls
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class Polls extends aModule
{

    public $name = 'polls';
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
     * @return string
     */
    public function getPageUploadPath()
    {
        return $this->getBaseUploadPath();
    }

    /**
     * @return string
     */
    public function getPageUploadUrl()
    {
        return $this->getBaseUploadUrl();
    }
}
