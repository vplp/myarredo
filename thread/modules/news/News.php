<?php

namespace thread\modules\news;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class News
 *
 * @package thread\modules\news
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class News extends aModule
{
    public $name = 'news';
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

    /**
     * @return mixed
     */
    public static function getFormatDate()
    {
        return Yii::$app->getModule('news')->params['format']['date'];
    }
}
