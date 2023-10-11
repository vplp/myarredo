<?php

namespace thread\modules\sys\modules\mailcarrier;

use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\sys\Sys;

/**
 * Class MailCarrier
 *
 * @package thread\modules\sys\modules\mailcarrier
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MailCarrier extends aModule
{
    public $name = 'mailcarrier';
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
