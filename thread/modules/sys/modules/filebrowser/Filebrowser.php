<?php

namespace thread\modules\sys\modules\filebrowser;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Filebrowser
 *
 * @package thread\modules\sys\modules\filebrowser
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Filebrowser extends aModule
{
    public $name = 'filebrowser';
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
}
