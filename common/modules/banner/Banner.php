<?php

namespace common\modules\banner;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Banner
 *
 * @package common\modules\banner
 */
class Banner extends aModule
{
    public $name = 'banner';
    public $configPath = __DIR__ . '/config.php';
    public $translationsBasePath = __DIR__ . '/messages';

    /**
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db-core');
    }

    /**
     * @return string
     */
    public function getBannerUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/banner';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * @return string
     */
    public function getBannerUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/banner';
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
