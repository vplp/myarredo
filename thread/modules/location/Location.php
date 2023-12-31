<?php

namespace thread\modules\location;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Location
 *
 * @package thread\modules\location
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Location extends aModule
{

    public $name = 'location';
    public $configPath = __DIR__ . '/config.php';
    public $translationsBasePath = __DIR__ . '/messages';

    /**
     * Db connection
     *
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db-core');
    }
}
