<?php

namespace thread\modules\sys\modules\growl;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\sys\Sys;

/**
 * Class Growl
 *
 * @package thread\modules\sys\modules\growl
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Growl extends aModule
{
    public $name = 'growl';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    /**
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Sys::getDb();
    }
}
