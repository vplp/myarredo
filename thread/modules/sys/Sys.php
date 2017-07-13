<?php

namespace thread\modules\sys;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Sys
 *
 * @package thread\modules\sys
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Sys extends aModule
{
    public $name = 'sys';
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
     * Image upload path
     * @return string
     */
    public function getFlagUploadPath()
    {
        return $this->getBaseUploadPath() . '/language';
    }

    /**
     * Image upload URL
     * @return string
     */
    public function getFlagUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/language';
    }
}
