<?php

namespace thread\modules\sys\modules\crontab;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Crontab
 *
 * @package thread\modules\sys\modules\crontab
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Crontab extends aModule
{
    public $name = 'crontab';
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
