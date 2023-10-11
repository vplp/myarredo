<?php

namespace thread\modules\sys\modules\configs;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\sys\Sys;

/**
 * Class Configs
 *
 * @package thread\modules\sys\modules\configs
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Configs extends aModule
{

    public $name = 'configs';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    /**
     * Db connection
     *
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Sys::getDb();
    }
}
