<?php

namespace thread\modules\seo\modules\modellink;

use thread\app\base\module\abstracts\Module as aModule;
use thread\modules\seo\Seo;

/**
 * Class Modellink
 *
 * @package thread\modules\seo\modules\modellink
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Modellink extends aModule
{

    public $name = 'modellink';
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
