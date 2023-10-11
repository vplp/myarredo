<?php

namespace common\modules\books;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class FormsModule
 *
 * @package common\modules\forms
 */
class Books extends aModule
{
    public $name = 'books';
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
        return Yii::$app->getModule('books')->params['format']['date'];
    }
}
