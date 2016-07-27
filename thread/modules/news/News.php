<?php

namespace thread\modules\news;

use thread\app\base\module\abstracts\Module as aModule;
use Yii;

/**
 * Class News
 *
 * @package thread\modules\news
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class News extends aModule
{
    public $name = 'news';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @return mixed
     */
    public static function getFormatDate()
    {
        return Yii::$app->getModule('news')->params['format']['date'];
    }
}
