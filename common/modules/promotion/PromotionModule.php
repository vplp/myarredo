<?php

namespace common\modules\promotion;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class PromotionModule
 *
 * @package common\modules\promotion
 */
class PromotionModule extends aModule
{
    public $name = 'promotion';
    public $configPath = __DIR__ . '/config.php';
    public $translationsBasePath = __DIR__ . '/messages';

    /**
     * @return object|string|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * Product upload path
     * @return string
     */
    public function getUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/promotion';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * Product upload URL
     * @return string
     */
    public function getUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/promotion';
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
