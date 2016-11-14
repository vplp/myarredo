<?php

namespace thread\modules\sys\modules\images;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\sys\Sys;

/**
 * Class Images
 *
 * @package thread\modules\sys\modules\images
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Images extends aModule
{
    public $name = 'images';
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
