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
        return Yii::$app->get('db_myarredo');
    }

    /**
     * Product upload path
     * @return string
     */
    public function getProductUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/images';

        return $dir;
    }

    /**
     * Product upload URL
     * @return string
     */
    public function getProductUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/images';
    }

    /**
     * Category upload path
     * @return string
     */
    public function getCategoryUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/images';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * Category upload URL
     * @return string
     */
    public function getCategoryUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/images';
    }

    /**
     * Samples upload path
     * @return string
     */
    public function getSamplesUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/images';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * Samples upload URL
     * @return string
     */
    public function getSamplesUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/images';
    }

    /**
     * Samples upload path
     * @return string
     */
    public function getSaleUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/images';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * Samples upload URL
     * @return string
     */
    public function getSaleUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/images';
    }

    /**
     * Factory upload path
     * @return string
     */
    public function getFactoryUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/factory';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * Factory upload URL
     * @return string
     */
    public function getFactoryUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/factory';
    }

    /**
     * @return string
     */
    public function getFactoryCatalogsFilesUploadPath()
    {
        return $this->getBaseUploadPath() . '/factoryFileCatalog';
    }

    /**
     * @return string
     */
    public function getFactoryCatalogsFilesUploadUrl()
    {
        return $this->getBaseUploadPath() . '/factoryFileCatalog';
    }

    /**
     * @return string
     */
    public function getFactoryPricesFilesUploadPath()
    {
        return $this->getBaseUploadPath() . '/factoryFileCatalog';
    }

    /**
     * @return string
     */
    public function getFactoryPricesFilesUploadUrl()
    {
        return $this->getBaseUploadPath() . '/factoryFileCatalog';
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