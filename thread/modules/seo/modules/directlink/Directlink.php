<?php

namespace thread\modules\seo\modules\directlink;

use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\seo\Seo;

/**
 * Class Directlink
 *
 * @package thread\modules\seo\modules\directlink
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Directlink extends aModule
{

    public $name = 'directlink';
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
