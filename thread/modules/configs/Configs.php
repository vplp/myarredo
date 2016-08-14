<?php

namespace thread\modules\configs;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Configs
 *
 * @package thread\modules\configs
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class Configs extends aModule
{

    public $name = 'Configs';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

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
