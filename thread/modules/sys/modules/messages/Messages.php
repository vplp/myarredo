<?php

namespace thread\modules\sys\modules\messages;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\sys\Sys;

/**
 * Class Messages
 *
 * @package thread\modules\sys\modules\messages
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Messages extends aModule
{
    public $name = 'messages';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';
    /**
     * @var string
     */
    public $defaultLang = 'ru-RU';

    /**
     * @var array
     */
    public $pathes = [
        '@frontend',
    ];

    /**
     * @var array
     */
    public $pathesToModules = [
        '@frontend/modules',
    ];

    /**
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Sys::getDb();
    }
}
