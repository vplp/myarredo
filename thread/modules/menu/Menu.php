<?php

namespace thread\modules\menu;

use thread\app\base\module\abstracts\Module as aModule;
use Yii;

/**
 * Class Menu
 *
 * @package thread\modules\menu
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Menu extends aModule
{
    public $name = 'Menu';
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
