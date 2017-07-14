<?php

namespace common\modules\catalog;

use Yii;
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Catalog
 *
 * @package common\modules\catalog
 */
class Catalog extends aModule {

    public $name = 'catalog';
    public $configPath = __DIR__ . '/config.php';
    public $translationsBasePath = __DIR__ . '/messages';

    /**
     * Db connection
     *
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('db-myarredo');
    }

    /**
     * Product Image upload path
     * @return string
     */
    public function getProductUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/product';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * Product Image upload URL
     * @return string
     */
    public function getProductUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/product';
    }

    /**
     * Category Image upload path
     * @return string
     */
    public function getCategoryUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/category';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * Category Image upload URL
     * @return string
     */
    public function getCategoryUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/category';
    }

    /**
     * Base upload URL
     * @return string
     */
    public function getBaseUploadUrl()
    {
        return '/uploads/' . $this->name;
    }
}