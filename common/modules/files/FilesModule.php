<?php

namespace common\modules\files;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class FormsModule
 *
 * @package common\modules\forms
 */
class FilesModule extends aModule
{
    public $name = 'files';
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
        return Yii::$app->getModule('files')->params['format']['date'];
    }

    /**
     * Product upload path
     * @return string
     */
    public function getArticleUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/files';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * Product upload URL
     * @return string
     */
    public function getArticleUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/files';
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
