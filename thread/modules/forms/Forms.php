<?php

namespace thread\modules\forms;

use thread\app\base\module\abstracts\Module as aModule;
use Yii;

/**
 * Class Forms
 *
 * @package thread\modules\forms
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Forms extends aModule
{

    public $name = 'Forms';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';


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
