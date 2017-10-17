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
        $dir = $this->getBaseUploadPath() . '/product';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * Product upload URL
     * @return string
     */
    public function getProductUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/product';
    }

    /**
     * Category upload path
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
     * Category upload URL
     * @return string
     */
    public function getCategoryUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/category';
    }

    /**
     * Samples upload path
     * @return string
     */
    public function getSamplesUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/samples';

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
        return $this->getBaseUploadUrl() . '/samples';
    }

    /**
     * Samples upload path
     * @return string
     */
    public function getSaleUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/sale';

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
        return $this->getBaseUploadUrl() . '/sale';
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
     * FactoryFile upload path
     * @return string
     */
    public function getFactoryFileUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/factory/files';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * FactoryFile upload URL
     * @return string
     */
    public function getFactoryFileUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/factory/files';
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