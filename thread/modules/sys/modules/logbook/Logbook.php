<?php

namespace thread\modules\sys\modules\logbook;

use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\sys\Sys;

/**
 * Class Logbook
 *
 * @package thread\modules\sys\modules\logbook
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Logbook extends aModule
{
    public $id = 'sys-logbook';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    /**
     * @return object|string|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Sys::getDb();
    }
}
