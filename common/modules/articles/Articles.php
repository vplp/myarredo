<?php

namespace common\modules\articles;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Articles
 *
 * @package common\modules\articles
 */
class Articles extends aModule
{

    public $name = 'articles';
    public $configPath = __DIR__ . '/config.php';
    public $translationsBasePath = __DIR__ . '/messages';

    /**
     * @return null|object|string
     * @throws \yii\base\InvalidConfigException
     */
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

    /**
     * Product upload path
     * @return string
     */
    public function getArticleUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/articles';

        return $dir;
    }

    /**
     * Product upload URL
     * @return string
     */
    public function getArticleUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/articles';
    }

    /**
     * Image upload path
     * @return string
     */
    public function getBaseUploadPath()
    {
        return Yii::getAlias('@uploads');
    }

    /**
     * Base upload URL
     * @return string
     */
    public function getBaseUploadUrl()
    {
        return '/uploads';
    }
}
