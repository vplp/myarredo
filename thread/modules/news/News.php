<?php

namespace thread\modules\news;

use Yii;
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class News
 *
 * @package thread\modules\news
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
        return 'd.m.Y'; //Yii::$app->getModule('news')->params['format']['date'];
    }

    /**
     * Image upload path
     * @return string
     */
    public function getArticleUploadPath()
    {
        return $this->getBaseUploadPath() . '/article';
    }

    /**
     * Image upload URL
     * @return string
     */
    public function getArticleUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/article';
    }
}
