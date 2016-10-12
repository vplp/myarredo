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

    public $name = 'Catalog';
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

}