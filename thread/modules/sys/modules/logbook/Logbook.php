<?php

namespace thread\modules\sys\modules\logbook;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Logbook
 *
 * @package thread\modules\sys\modules\logbook
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Logbook extends aModule
{
    public $name = 'logbook';
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
