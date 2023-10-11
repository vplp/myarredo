<?php

namespace thread\modules\seo\modules\pathcache;

use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\seo\Seo;

/**
 * Class Pathcache
 *
 * @package thread\modules\seo\modules\pathcache
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Pathcache extends aModule
{

    public $name = 'pathcache';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    public $secretKey = "thread";

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
