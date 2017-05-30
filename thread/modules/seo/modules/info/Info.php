<?php

namespace thread\modules\seo\modules\info;

use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\seo\Seo;

/**
 * Class Info
 *
 * @package thread\modules\seo\modules\info
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Info extends aModule
{

    public $name = 'info';
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
        return Seo::getDb();
    }
}
