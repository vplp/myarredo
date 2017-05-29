<?php

namespace thread\modules\seo\modules\sitemap;

use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\seo\Seo;

/**
 * Class Sitemap
 *
 * @package thread\modules\seo\modules\sitemap
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Sitemap extends aModule
{

    public $name = 'sitemap';
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
