<?php

namespace thread\modules\catalog;

use Yii;
//
use thread\app\base\module\abstracts\Module as aModule;

/**
 * Class Catalog
 *
 * @package thread\modules\catalog
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
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
        return Yii::$app->get('db-core');
    }

    /**
     * Image upload path
     * @return string
     */
    public function getGroupUploadPath()
    {
        return $this->getBaseUploadPath() . '/group';
    }

    /**
     * Group image upload URL
     * @return string
     */
    public function getGroupUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/group';
    }

    /**
     * Group image upload path
     * @return string
     */
    public function getProductUploadPath()
    {
        return $this->getBaseUploadPath() . '/product';
    }

    /**
     * Product image upload URL
     * @return string
     */
    public function getProductUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/product';
    }

    /**
     * Product image upload URL
     * @return string
     */
    public function getBaseUploadUrl()
    {
        return '/uploads/' . $this->name;
    }
}