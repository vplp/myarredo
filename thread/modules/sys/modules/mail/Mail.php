<?php

namespace thread\modules\sys\modules\mail;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\sys\Sys;

/**
 * Class Mail
 *
 * @package thread\modules\sys\modules\mail
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Mail extends aModule
{
    public $name = 'mail';
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
